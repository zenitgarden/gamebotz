@extends('layouts.dashboard')

@section('title')
My Trash Post - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Trash Posts</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('posts.index')}}">Post</a></div>
        <div class="breadcrumb-item">@hasrole('Admin') My @endhasrole Trash Posts</div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Trash Posts</h2>
      <p class="section-lead">
        You can restore post or delete it permanent.
      </p>

      <div class="row">
        <div class="col-12">
          <div class="card mb-0">
            <div class="card-body">
              <div class="buttons">
                <form action="" method="get">
            
                    <a  href="{{route('posts.index')}}?f=all" class="btn btn-lg btn-link">All <span class="badge badge-primary">@hasrole('Admin') {{$postCount}} @else {{$postCountUser}} @endhasrole</span></a>
                    <a  href="{{route('posts.index')}}?f=publish" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Publish <span class="badge badge-primary">@hasrole('Admin') {{$publishCount}} @else {{$publishCountUser}} @endhasrole</span></a>
                    <a  href="{{route('posts.index')}}?f=draft" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Draft <span class="badge badge-primary">@hasrole('Admin') {{$draftCount}} @else {{$draftCountUser}} @endhasrole</span></a>
                    <button  type="submit" name="f" value="draft" class="btn btn-lg btn-primary">@hasrole('Admin') My @endhasrole Trash <span class="badge badge-white">{{$trashCountUser}}</span></button>
                    @hasrole('Admin')
                    <a  href="{{route('posts.index')}}?f=myp" class="btn btn-lg btn-link">My Post <span class="badge badge-primary">{{$postCountUser}}</span></a>
                    @endhasrole  
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Trash Post</h4>
              @if (!$posts->isEmpty())
              <form id="delA" action="{{route('posts.deleteAll')}}" method="POST">
                @csrf
                @method('DELETE')
              <button type="submit" name="delA"  class="btn btn-danger rounded-sm" role="button">
                <i class="fas fa-trash"></i> Delete all
              </button>
              </form>
              @else
              , Don't have any trash
              @endif
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-3">
                  <thead>                                 
                    <tr>
                      <th class="text-center">
                        #
                      </th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Description</th>
                      <th>Created At</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach ( $posts as $post )                                
                    <tr>
                      <td>
                        {{$loop->iteration}}
                      </td>
                      <td>
                        {{$post->title}}
                      </td>
                      <td>
                        @foreach ($post->categories as $category)
                        {{ $loop->first ? '' : ', ' }}
                          <a href="#">{{$category->title}} </a>
                        @endforeach
                      </td>
                      <td>
                        {{Str::limit($post->excerpt,60)}}
                      </td>
                      <td>{{$post->created_at->format('d F Y')}}</td>
                      @if ($post->status == 'publish')
                      <td><div class="badge badge-primary">{{ucfirst($post->status)}}</div></td>
                      @else
                      <td><div class="badge badge-danger">{{ucfirst($post->status)}}</div></td>
                      @endif
                      <td>
                        <div class="">
                    
                          {{-- Restore --}}
                          <a data-toggle="tooltip" title="Click here to restore post" href="{{route('posts.restore',$post->slug)}}" class="btn btn-sm btn-primary my-1" role="button">
                            <i class="fas fa-heart"></i> Restore
                          </a>
                          {{-- DELETE --}}
                          <form  class="d-inline" action="{{route('posts.kill',$post->slug)}}" method="POST" role="alert" 
                            alert-title="Delete post" 
                            alert-text="{{'Are you sure want to delete permanent "'.$post->title.'" ?' }}"
                            alert-btn-yes="Yes"
                            alert-btn-cancel="Cancel">
                            @method('DELETE')
                            @csrf
                              <button type="submit" data-toggle="tooltip" title="Click here to delete permanent" class="btn btn-sm btn-danger my-1">
                                <i class="fas fa-trash"></i> Delete
                              </button>
                            </form>
                        </div>
                      </td>
                    </tr>
                    @endforeach 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@push('css-internal')
<style>
 .btn-link:hover, .btn-link:visited {
    background-color: #edeffd !important;
    text-decoration: none !important;
    color: #007bff !important;
}
.btn.btn-lg {
    font-size: 14px !important;
}
</style>
@endpush

@push('css-external')
<link rel="stylesheet" href="{{asset('assets/modules/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
@endpush

@push('javascript-external')

<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/page/modules-datatables.js')}}"></script>
@endpush

@push('javascript-internal')
   <script>
      $(document).ready(function(){
      // Event: Delete post
         $("form[role='alert']").submit(function(event) {
            event.preventDefault();
            Swal.fire({
            title: $(this).attr('alert-title'),
            text: $(this).attr('alert-text'),
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText:$(this).attr('alert-btn-cancel'),
            reverseButtons: true,
            confirmButtonText: $(this).attr('alert-btn-yes'),
         }).then((result) => {
            if (result.isConfirmed) {
               // todo: process of deleting post
              event.target.submit();
            }
         });

         })
      });

      $(document).ready(function(){
      // Event: Delete post
         $("#delA").submit(function(event) {
            event.preventDefault();
            Swal.fire({
            title: "Delete all trash",
            text: "Are you sure ?",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText:"Cancel",
            reverseButtons: true,
            confirmButtonText: "Yes",
         }).then((result) => {
            if (result.isConfirmed) {
               // todo: process of deleting post
              event.target.submit();
            }
         });

         })
      });
      

   </script>
@endpush

