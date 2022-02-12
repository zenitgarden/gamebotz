@extends('layouts.dashboard')

@section('title')
Roles - Gamebotz
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Role</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
      <div class="breadcrumb-item">Role</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Guide !</h2>
    <p class="section-lead">
        You can manage all role, such as creating new role ,editing, deleting and more.
    </p>
    <div class="row">
      <div class="col-12">
        <div class="card ">
          <div class="card-header">
            <h4>All Roles</h4>
            @can('role_create')
            <a href="{{route('roles.create')}}" class="btn btn-primary rounded-sm" role="button">
              <i class="fas fa-plus"></i> Add role
            </a><h4></h4>
            @endcan
            <div class="card-header-form">
              <form>
                <div class="input-group float-right">
                  <form action="{{route('categories.index')}}" method="GET">
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
            <ul class="list-group list-group-flush">

                         <!-- tag list -->
                     @forelse ($roles as $role)
                         
                    
                         <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
                             <label class="mt-auto mb-auto font-weight-bold">
                                {{$role->name}}
                             </label>
                             <div>
                               @can('role_detail')
                                <!-- View -->
                                <a href="{{route('roles.show',['role'=>$role])}}" class="btn btn-sm btn-info"
                                    role="button">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                @can('role_update') 
                                 <!-- edit -->
                                 <a href="{{route('roles.edit',['role'=> $role])}}" class="btn btn-sm btn-primary" role="button">
                                 <i class="fas fa-edit"></i>
                                 </a>
                                 @endcan
                                 @can('role_delete') 
                                    <!-- delete -->
                                    @if ($role->name == "Admin")
                                    @else
                                    <form class="d-inline" role="alert" alert-text="{{ 'Are you sure want to delete "'.$role->name.'" ?'}}" 
                                      action="{{route('roles.destroy',['role'=> $role])}}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </form>
                                    @endif
                                 @endcan
                             </div>
                         </li>
                         <!-- end  tag list -->
                    
                @empty  
                <p>
                     <strong>
                        @if (request()->get('keyword'))
                        "{{request()->get('keyword')}}" role not found
                        @else
                        No role data yet
                        @endif
                        
                     </strong>    
                </p>  
                @endforelse    
              </ul>
         </div>
         @if ($roles->hasPages())
          <div class="card-footer">
            {{$roles->links('vendor.pagination.bootstrap-4')}}
         </div>
         @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('javascript-internal')
   <script>
      $(document).ready(function() {
         // Event :delete role
         $("form[role='alert'").submit(function(event) {
            event.preventDefault();
            Swal.fire({
            title: "Delete role",
            text: $(this).attr('alert-text'),
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText: "Cancel",
            reverseButtons: true,
            confirmButtonText: "Yes",
         }).then((result) => {
            if (result.isConfirmed) {
               // todo: process of deleting categories
               event.target.submit();
            }
         });

         })
      });
   </script>
@endpush

