@extends('layouts.dashboard')

@section('title')
Users - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">User</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Users</h2>
      <p class="section-lead">Components relating to users, lists of users and so on.</p>
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
                <h4>All Users</h4> &nbsp;
                @can('user_create') 
                <a href="{{route('users.create')}}" class="btn btn-primary rounded-sm" role="button">
                  <i class="fas fa-plus"></i> Add User
                </a><h4></h4>
                @endcan
                <div class="card-header-form">
                  <form>
                    <div class="input-group float-right">
                      <form action="{{route('users.index')}}" method="GET">
                      <input type="search" name="keyword" aria-label="Search" class="form-control" value="{{request()->get('keyword')}}" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                      </div>
                      
                      </form>
                    </div>
                  </form>
                </div>
              </div>
            <div class="card-body">
              <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                @forelse ($users as $user)
                <li class="media">
                  <img alt="image" class="mr-3 rounded-circle" width="50" src="@if ($user->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} @else {{asset('uploads/avatar/'.$user->avatar)}} @endif">
                  <div class="media-body">
                    <div class="media-title"  style="font-size: 15px"> @if(Auth::user()->name == $user->name)Hi, @endif{{$user->name}}</div>
                    <div class="text-job text-muted">@if ($user->hasanyrole($roles) == true) {{$user->roles->first()->name}} @else <span class="text-danger">DO NOT HAVE ROLE</span>  @endif</div>
                  </div>
                  <div class="media-body">
                    <div class="media-title"  style="font-size: 15px"> @if($user->username != "") {{$user->username}} @else - @endif</div>
                    <div class="text-job text-muted">Username</div>
                  </div>
                  <div class="media-body">
                      <div class="media-title"  style="font-size: 15px">{{$user->email}}</div>
                      <div class="text-job text-muted">Email</div>
                  </div>
                  <div class="media-body">
                      <div class="media-title" style="font-size: 15px">{{$user->postPub->count()}}</div>
                      <div class="text-job text-muted">Posts</div>
                  </div>
                  <div class="media-cta">
                  @can('user_detail')   
                    <a href="{{route('users.show',['user'=>$user])}}" class="btn btn-outline-primary"> <i class="fas fa-eye"></i>View</a>
                  @endcan
                  @can('user_update')                     
                    <a href="{{route('users.edit',['user'=>$user])}}" class="btn btn-outline-info"> <i class="fas fa-edit"></i>Edit </a>
                  @endcan
                  @can('user_delete') 
                    @if(Auth::user()->id == $user->id)
                    <button data-toggle="tooltip" title="Cannot Delete your self" id="tryC" type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i>Delete
                    </button>
                    @else
                      @if ($user->hasRole('Admin'))
                      <button data-toggle="tooltip" title="Cannot Delete Admin" id="tryC" type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i>Delete
                      </button>
                      @else   
                      <form class="d-inline" role="alert" alert-text="{{'Are you sure want to delete user "'.$user->name.'" ?'}}" 
                          action="{{route('users.destroy',['user'=> $user])}}" method="POST">
                          @csrf
                          @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash"></i>Delete
                        </button>
                        </form>  
                        @endif   
                    @endif 
                    @endcan      
                  </div>
                </li>
                @empty 
                @if (request()->get('keyword'))
                <strong>
                "{{request()->get('keyword')}}" user not found
               </strong>
                @else
                <strong>
                No users yet
               </strong>
                @endif
                @endforelse      
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="suprise">
        <img src="{{url('suprise.png')}}" alt="display image on button click" class="mySuprise"/>
    </div>
  </section>
@endsection

@push('css-internal')
<style>
.suprise{
    display:none;

}
.mySuprise{
    position: absolute;
    top: 0;
    left: 0;
    width: 120%;
    height: 140%;


    /* Center and scale the image nicely */
  
}

@media (max-width: 940.98px){
.user-progress .media, .user-details .media img {
    text-align: center;
    display: inline-block;
    width: 100%;
}
.user-progress .media img, .user-details .media img {
    margin: 0 !important;
    margin-bottom: 10px !important;
}
}
</style>
@endpush

@push('javascript-internal')
   <script>
      $(document).ready(function() {
         // Event :delete user
         $("form[role='alert'").submit(function(event) {
            event.preventDefault();
            Swal.fire({
            title: "Delete User",
            text: $(this).attr('alert-text'),
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText: "Cancel",
            reverseButtons: true,
            confirmButtonText: "Yes",
         }).then((result) => {
            if (result.isConfirmed) {
               // todo: process of deleting user
               event.target.submit();
            }
         });

         })


         $("#tryC").click(function(event) {
            event.preventDefault();
            Swal.fire({
            icon: 'error',
            title: 'I TOLD YOU BOYOOOOO!!',
            text: 'Cannot delete ur self !',
            confirmButtonText: "OK",   
            closeOnConfirm: false 
            }).then(function() {
             
            $('.suprise').show();
                
            setTimeout(function(){ 
                window.location.reload(); 
            }, 1000);
            });    

         })
      });
   </script>
@endpush


