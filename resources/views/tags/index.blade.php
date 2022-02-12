@extends('layouts.dashboard')

@section('title')
Tags - Gamebotz
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Tag</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
      <div class="breadcrumb-item">Tag</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Guide !</h2>
    <p class="section-lead">
        You can manage all tag, such as creating new tag ,editing, deleting and more.
    </p>
    <div class="row">
      <div class="col-12">
        <div class="card ">
          <div class="card-header">
            <h4>All Tag</h4> &nbsp;
            @can('tag_create')  
            <a href="{{route('tags.create')}}" class="btn btn-primary rounded-sm" role="button">
              <i class="fas fa-plus"></i> Add Tag
            </a><h4></h4>
            @endcan
            <div class="card-header-form">
              <form>
                <div class="input-group float-right">
                  <form action="{{route('tags.index')}}" method="GET">
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

                @if (count($tags))
                         <!-- tag list -->
                     @foreach ($tags as $tag)
                         
                    
                         <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
                             <label class="mt-auto mb-auto font-weight-bold">
                                {{$tag->title}}
                             </label>
                             <div>
                                 @can('tag_update')            
                                 <!-- edit -->
                                 <a href="{{route('tags.edit',['tag'=>$tag])}}" class="btn btn-sm btn-primary" role="button">
                                 <i class="fas fa-edit"></i>
                                 </a>
                                 @endcan
                                 @can('tag_delete')  
                                 <!-- delete -->
                                 <form class="d-inline" role="alert" alert-text="{{ 'Are you sure want to delete "'.$tag->title.'" ?'}}" 
                                  action="{{route('tags.destroy',['tag'=>$tag])}}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                 <button type="submit" class="btn btn-sm btn-danger">
                                     <i class="fas fa-trash"></i>
                                 </button>
                                 </form>
                                 @endcan
                             </div>
                         </li>
                         <!-- end  tag list -->
                     @endforeach
                @else
                <p>
                     <strong>
                        @if (request()->get('keyword'))
                        "{{request()->get('keyword')}}" tag not found
                        @else
                        No tag data yet
                        @endif
                        
                     </strong>    
                </p>    
                @endif     
              </ul>
         </div>
         @if ($tags->hasPages())
          <div class="card-footer">
            {{$tags->links('vendor.pagination.bootstrap-4')}}
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
         // Event :delete tag
         $("form[role='alert'").submit(function(event) {
            event.preventDefault();
            Swal.fire({
            title: "Delete tag",
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

