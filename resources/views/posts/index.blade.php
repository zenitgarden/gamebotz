@extends('layouts.dashboard')

@section('title')
All Post - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Posts</h1>
      <div class="section-header-button">
        @can('post_create')
        <a href="{{route('posts.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
        @endcan
      </div>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Posts</div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Posts</h2>
      <p class="section-lead">
        You can manage all posts, such as editing, deleting and more.
      </p>

      <div class="row">
        <div class="col-12">
          <div class="card mb-0">
            <div class="card-body">
              <div class="buttons">
                <form action="" method="get">
                  @switch(request()->get('f'))
                    @case("publish")
                    <button  type="submit" name="f"  value="all" class="btn btn-lg btn-link">All <span class="badge badge-primary">@hasrole('Admin') {{$postCount}} @else {{$postCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[1]}}" class="btn btn-lg btn-primary">@hasrole('Admin') All @endhasrole Publish <span class="badge badge-white">@hasrole('Admin') {{$publishCount}} @else {{$publishCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[0]}}" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Draft <span class="badge badge-primary">@hasrole('Admin') {{$draftCount}} @else {{$draftCountUser}} @endhasrole</span></button>
                    <a href="{{ route('posts.trash') }}"  class="btn btn-lg btn-link">@hasrole('Admin') My @endhasrole Trash <span class="badge badge-primary">{{$trashCountUser}}</span></a>
                    @hasrole('Admin')
                    <button  type="submit" name="f" value="myp" class="btn btn-lg btn-link">My Post <span class="badge badge-primary">{{$postCountUser}}</span></button>
                    @endhasrole  
                    @break

                    @case("draft")
                    <button  type="submit" name="f"  value="all" class="btn btn-lg btn-link">All <span class="badge badge-primary">@hasrole('Admin') {{$postCount}} @else {{$postCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[1]}}" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Publish <span class="badge badge-primary">@hasrole('Admin') {{$publishCount}} @else {{$publishCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[0]}}" class="btn btn-lg btn-primary">@hasrole('Admin') All @endhasrole Draft <span class="badge badge-white">@hasrole('Admin') {{$draftCount}} @else {{$draftCountUser}} @endhasrole</span></button>
                    <a href="{{ route('posts.trash') }}"  class="btn btn-lg btn-link">@hasrole('Admin') My @endhasrole Trash <span class="badge badge-primary">{{$trashCountUser}} </span></a>
                    @hasrole('Admin')
                    <button  type="submit" name="f" value="myp" class="btn btn-lg btn-link">My Post <span class="badge badge-primary">{{$postCountUser}}</span></button>
                    @endhasrole  
                    @break
                  
                    @case("myp")
                    <button  type="submit" name="f"  value="all" class="btn btn-lg btn-link">All <span class="badge badge-primary">@hasrole('Admin') {{$postCount}} @else {{$postCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[1]}}" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Publish <span class="badge badge-primary">@hasrole('Admin') {{$publishCount}} @else {{$publishCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[0]}}" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Draft <span class="badge badge-primary">@hasrole('Admin') {{$draftCount}} @else {{$draftCountUser}} @endhasrole</span></button>
                    <a href="{{ route('posts.trash') }}"  class="btn btn-lg btn-link">@hasrole('Admin') My @endhasrole Trash <span class="badge badge-primary">{{$trashCountUser}} </span></a>
                    @hasrole('Admin')
                    <button  type="submit" name="f" value="myp" class="btn btn-lg btn-primary">My Post <span class="badge badge-white">{{$postCountUser}}</span></button>
                    @endhasrole  
                    @break

                    @default
                    <button  type="submit" name="f"  value="all" class="btn btn-lg btn-primary">All <span class="badge badge-white">@hasrole('Admin') {{$postCount}} @else {{$postCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[1]}}" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Publish <span class="badge badge-primary">@hasrole('Admin') {{$publishCount}} @else {{$publishCountUser}} @endhasrole</span></button>
                    <button  type="submit" name="f" value="{{$status[0]}}" class="btn btn-lg btn-link">@hasrole('Admin') All @endhasrole Draft <span class="badge badge-primary">@hasrole('Admin') {{$draftCount}} @else {{$draftCountUser}} @endhasrole</span></button>
                    <a href="{{ route('posts.trash') }}"  class="btn btn-lg btn-link">@hasrole('Admin') My @endhasrole Trash <span class="badge badge-primary">{{$trashCountUser}} </span></a>
                    @hasrole('Admin')
                    <button  type="submit" name="f" value="myp" class="btn btn-lg btn-link">My Post <span class="badge badge-primary">{{$postCountUser}}</span></button>
                    @endhasrole  
                  @endswitch
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              @switch(request()->get('f'))
                @case("publish")
                <h4>Publish Post</h4> &nbsp; &nbsp; | &nbsp; &nbsp;
                @break
                @case("draft")
                <h4>Draft Post</h4> &nbsp; &nbsp; | &nbsp; &nbsp;
                @break
                @default
                <h4>All post</h4> &nbsp; &nbsp; | &nbsp; &nbsp;
              @endswitch
              Category
              <form method="get">
              <div class="col-sm-2 col-md-2 float-right"> 
              <select id="select-2-c" name="category" style="clear:both;" class="form-control select2 d-inline" data-placeholder="Choose category">
                @if (old('category',request()->get('category')))
                  <option value="{{old('category',request()->get('category'))}}" selected>{{old('category',request()->get('category'))}}</option>
                @endif
              </select>
              </div>   
              @hasrole('Admin')
              Author
              <div class="col-sm-2 col-md-2 float-right"> 
                <select id="select-2-u" name="author" style="clear:both;" class="form-control select2 d-inline" data-placeholder="Choose Author">
                  @if (old('author',request()->get('author')))
                    <option value="{{old('author',request()->get('author'))}}" selected>{{old('author',request()->get('author'))}}</option>
                  @endif
                </select>
                </div>
              @endhasrole 
              <button  class="btn btn-primary rounded-sm d-inline" role="button" name="f" value="{{request()->get('f')}}" type="submit">
                Filter
              </button> 
              </form>
              &nbsp;
              @if (request()->has('author') || request()->has('category'))
              <button  class="btn btn-warning rounded-sm d-inline" role="button" onclick="clicked()" type="submit">
                Reset
              </button>  
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
                      @hasrole('Admin')
                      @if (request()->f == 'myp')
                      <th>Description</th>
                      @else
                      <th>Author</th>
                      @endif
                      @else
                      <th>Description</th>
                      @endhasrole
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
                          <a class="font-weight-bold" href="{{route('posts.index')}}?category={{$category->title}}">{{$category->title}}</a>
                        @endforeach
                      </td>
                      <td>        
                        @hasrole('Admin')
                        @if (request()->f == 'myp')
                        {{Str::limit($post->excerpt,60)}}
                        @else
                        <a href="{{route('users.show',$post->authors->slug)}}"><img alt="image" src="@if ($post->authors->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} @else {{asset('uploads/avatar/'.$post->authors->avatar)}} @endif" 
                          class="rounded-circle" width="35" data-toggle="title" title=""></a> 
                          <div class="d-inline-block ml-1"><a href="{{route('users.show',$post->authors->slug)}}">{{$post->authors->name}}</a></div>
                        @endif
                        @else
                        {{Str::limit($post->excerpt,60)}}
                        @endhasrole 
                      </td>
                      <td>{{$post->created_at->format('d F Y')}}</td>
                      @if ($post->status == 'publish')
                      <td><div class="badge badge-primary">{{ucfirst($post->status)}}</div></td>
                      @else
                      <td><div class="badge badge-danger">{{ucfirst($post->status)}}</div></td>
                      @endif
                      <td>
                        @if (!auth()->user()->can('post_detail') && !auth()->user()->can('post_update')  && !auth()->user()->can('post_delete'))
                          Dont'have permission to perform an action
                        @else
                        <div class="">
                          {{-- View --}}
                          @can('post_detail')
                          <a data-toggle="tooltip" title="Click here to view post" href="{{route('posts.show',['post'=>$post])}}" class="btn btn-sm btn-info my-1 mx-1" role="button">
                            <i class="fas fa-eye"></i>
                          </a>
                          @endcan
                          {{-- EDIT --}}
                          @can('post_update')
                          <a data-toggle="tooltip" title="Click here to edit post" href="{{route('posts.edit',['post'=>$post])}}" class="btn btn-sm btn-primary my-1 mx-1" role="button">
                            <i class="fas fa-edit"></i>
                          </a>
                          @endcan
                          {{-- DELETE --}}
                          @can('post_delete')
                          <form  class="d-inline" action="{{route('posts.destroy',['post'=> $post])}}" method="POST" role="alert" 
                            alert-title="Delete post" 
                            alert-text="{{'Are you sure want to delete "'.$post->title.'" ?' }}"
                            alert-btn-yes="Yes"
                            alert-btn-cancel="Cancel">
                            @method('DELETE')
                            @csrf
                              <button type="submit" data-toggle="tooltip" title="Click here to delete post" class="btn btn-sm btn-danger my-1 mx-1">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          @endcan
                        </div>
                        @endif
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

<link rel="stylesheet" href="{{asset('assets/modules/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/select2/css/select2-bootstrap4.min.css')}}">
@endpush

@push('css-internal')
<style>
.select2 {
width:100%!important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    min-height: 42px;
    line-height: 42px;
    padding-left: 12px !important;
    padding-right: 20px;
}
.select2-selection__clear{
    margin-right: 18px;
    width: 0.9em;
    height: 0.9em;
    padding-left: 0.15em;
    margin-top: 1em;
    margin-right: 1.3em;
    line-height: .75em;
    color: #f8f9fa;
    background-color: #c8c8c8;
     border-radius: 100%;
}
</style>
@endpush

@push('javascript-external')
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/page/modules-datatables.js')}}"></script>

<script src="{{asset('assets/modules/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/modules/select2/js/i18n/en.js')}}"></script>
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

      $(function() {
          //select parent_category
        $('#select-2-c').select2({
            
            language: "{{ app()->getLocale() }}",
            allowClear: true,
            ajax: {
               url: "{{route('categories.select')}}",
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                  return {
                     results: $.map(data, function(item) {
                        return {
                           text: item.title,
                           id: item.title
                        }
                     })
                  };
               }
            }
         });

         $('#select-2-u').select2({
            
            language: "{{ app()->getLocale() }}",
            allowClear: true,
            ajax: {
               url: "{{route('users.select')}}",
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                  return {
                     results: $.map(data, function(item) {
                        return {
                           text: item.name,
                           id: item.name
                        }
                     })
                  };
               }
            }
         });
      });

      function clicked () {
        window.location ="{{route('posts.index')}}?f={{request()->get('f')}}";
    }
</script>

@endpush

