<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{route('dashboard.index')}}">{{config('app.name')}}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">GB</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="dropdown {{set_active('dashboard.index')}}">
      <a href="{{route('dashboard.index')}}" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
    </li>
    @if (Auth::user()->can('manage_posts') == true || Auth::user()->can('manage_categories') == true || Auth::user()->can('manage_tags') == true )
    <li class="menu-header">Master</li>
    @endif
    @can('manage_posts')
      @can('post_show')
    <li class="dropdown {{set_active(['posts.index','posts.create','posts.edit','posts.trash','posts.show'])}}">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-newspaper"></i><span>Post</span></a>
      <ul class="dropdown-menu">
        @can('post_create')
        <li class="{{set_active('posts.create')}}"><a class="nav-link" href="{{route('posts.create')}}">Add Post </a></li>
        @endcan
        <li class="{{set_active('posts.index')}}"><a class="nav-link" href="{{route('posts.index')}}">All Post<label id="label-custom-0">@hasrole('Admin') {{$postCount}} @else  {{$postCountUser}} @endhasrole</label></a></li>
        <li class="{{set_active('posts.trash')}}"><a class="nav-link" href="{{route('posts.trash')}}">@hasrole('Admin') My @endhasrole Trash Post &nbsp;<label id="label-custom-0" >{{$trashCountUser}}</label></a></li>
      </ul>
    </li>
      @endcan
    @endcan
   
    @can('manage_categories')
      @can('category_show')
    <li class="dropdown {{set_active(['categories.index','categories.create','categories.edit'])}}">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-th-list"></i> <span>Category</span></a>
      <ul class="dropdown-menu">
        @can('category_create')
        <li class="{{set_active('categories.create')}}"><a class="nav-link" href="{{route('categories.create')}}">Add Category</a></li>
        @endcan
        <li class="{{set_active('categories.index')}}"><a class="nav-link" href="{{route('categories.index')}}">All Category<label id="label-custom-0" >{{$categCount}}</label></a></li>
      </ul>
    </li>
      @endcan
    @endcan

    @can('manage_tags')
      @can('tag_show')
    <li class="dropdown {{set_active(['tags.index','tags.create','tags.edit'])}}">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tag"></i> <span>Tag</span></a>
      <ul class="dropdown-menu">
        @can('tag_create')
        <li class="{{set_active('tags.create')}}"><a class="nav-link" href="{{route('tags.create')}}">Add Tag</a></li>
        @endcan
        <li class="{{set_active('tags.index')}}"><a class="nav-link" href="{{route('tags.index')}}">All Tag<label id="label-custom-0">{{$tagCount}}</label></a></li>
      </ul>
    </li>
      @endcan
    @endcan
 
    @if (Auth::user()->can('recommendation_game_edit') || Auth::user()->can('recommendation_game_show'))
    <li class="dropdown {{set_active('dashboard.recom')}}">
      <a href="{{route('dashboard.recom')}}" class="nav-link"><i class="fas fa-gamepad"></i><span>Recommendation Game</span></a>
    </li>
    @endif
    <li class="menu-header">File</li>
    <li class="dropdown {{set_active('filemanager.index')}}">
      <a href="{{route('filemanager.index')}}" class="nav-link"><i class="fas fa-images"></i><span>Images Manager</span></a>
    </li>
    @if (Auth::user()->can('manage_users') == true || Auth::user()->can('manage_roles') == true)
      <li class="menu-header">Authorization</li>
    @endif
    @can('manage_users')
      @can('user_show')
    <li class="dropdown {{set_active(['users.index','users.edit','users.create'])}}">
      <a href="{{route('users.index')}}" class="nav-link"><i class="fas fa-user"></i><span>User</span></a>
    </li>
      @endcan
    @endcan
    @can('manage_roles')
      @can('role_show')
    <li class="dropdown {{set_active(['roles.index','roles.create','roles.edit',])}}">
      <a href="{{route('roles.index')}}" class="nav-link"><i class="fas fa-user-shield"></i><span>Role</span></a>
    </li>
      @endcan
    @endcan
      <li class="menu-header">settings</li>
    @can('site_settings')
      @can('site_settings_show')
    <li class="dropdown {{set_active('settings.index')}}">
      <a href="{{route('settings.index')}}" class="nav-link"><i class="fas fa-cog"></i> <span>Site Setting</span></a>
    </li>
      @endcan
    @endcan
    <li class="dropdown {{set_active('users.profile')}}">
      <a href="{{route('users.profile')}}" class="nav-link"><i class="far fa-id-card"></i> <span>Profile</span></a>
    </li>
    

  <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="#" class="btn btn-primary btn-lg btn-block btn-icon-split">
      <i class="fas fa-user"></i> Login as {{Auth::user()->name}}
    </a>
  </div>        
</aside>