@extends('layouts.dashboard')

@section('title')
Category - Gamebotz
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Category</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
      <div class="breadcrumb-item">Category</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Guide !</h2>
    <p class="section-lead">
      This icon ( <i class="fa fa-minus"></i> <i class="fa fa-minus"></i> ) meaning the sub-category of the category above it. 
      The sub-category also can have their sub-category and the icons will increase like ( <i class="fa fa-minus"></i> <i class="fa fa-minus"></i> <i class="fa fa-minus"></i> <i class="fa fa-minus"></i> )
    </p>
    <div class="row">
      <div class="col-12">
        <div class="card ">
          <div class="card-header">
            <h4>All Tag</h4> &nbsp;
            @can('category_create')
            <a href="{{route('categories.create')}}" class="btn btn-primary rounded-sm" role="button">
              <i class="fas fa-plus"></i> Add Category
            </a><h4></h4>
            @endcan
            <div class="card-header-form">
              <form>
                <div class="input-group float-right">
                  <form action="{{route('categories.index')}}" method="GET">
                  <input type="text" name="keyword" class="form-control" value="{{request()->get('keyword')}}" placeholder="Search">
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
               @if (count($categories))
               @include('category._category-list',[
                'categories' => $categories,
                'count'=> 0
                ])
               @else
               <p>
                  <strong>
                    @if (request()->get('keyword'))
                    "{{request()->get('keyword')}}" category not found
                    @else
                     No category data yet
                    @endif 
                  </strong>
              </p>
                    
               @endif
            </ul>
         </div>
         @if ($categories->hasPages())
          <div class="card-footer">
            {{$categories->links('vendor.pagination.bootstrap-4')}}
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
      $(document).ready(function(){
      // Event: Delete category
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
               // todo: process of deleting categories
              event.target.submit();
            }
         });

         })
      });
   </script>
@endpush
