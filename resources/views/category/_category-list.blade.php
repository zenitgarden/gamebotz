@foreach ($categories as $category)
<!-- category list -->
<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
    <label class="mt-auto mb-auto font-weight-bold">
     {!! str_repeat('<i class="fa fa-minus"></i> ', $count) . ' ' . $category->title!!}
   
    </label>
    <div class="my-2">
      @can('category_update')
      <!-- edit -->
      <a href="{{route('categories.edit',['category'=>$category])}}" class="btn btn-sm btn-primary" role="button">
        <i class="fas fa-edit"></i>
      </a>
      @endcan
      @can('category_delete')
      <!-- delete -->
      <form class="d-inline" action="{{route('categories.destroy',['category'=> $category])}}" method="POST" role="alert" 
      alert-title="Delete category" 
      alert-text="{{'Are you sure want to delete "'.$category->title.'" ?' }}"
      alert-btn-yes="Yes"
      alert-btn-cancel="Cancel">
      @method('DELETE')
      @csrf
        <button type="submit" class="btn btn-sm btn-danger">
          <i class="fas fa-trash"></i>
        </button>
      </form>
      @endcan
    </div>
  @if($category->descendants && !trim(request()->get('keyword')))
  @include('category._category-list',[
    'categories' => $category->descendants,
    'count'=> $count + 2,
    ])
  @endif
  </li>
  <!-- end  category list -->
  @endforeach