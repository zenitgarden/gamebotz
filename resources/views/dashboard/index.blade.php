@extends('layouts.dashboard')

@section('title')
Dashboard - Gamebotz
@endsection

@section('content')

  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Author</h4>
            </div>
            <div class="card-body">
              {{$authorCount}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="far fa-newspaper"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>News / Post</h4>
            </div>
            <div class="card-body">
              {{$postCount}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-th-list"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Category</h4>
            </div>
            <div class="card-body">
              {{$categCount}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-tag"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Tag</h4>
            </div>
            <div class="card-body">
              {{$tagCount}}
            </div>
          </div>
        </div>
      </div>                  
    </div>
    @if(Auth::user()->username == "")
    <div class="col-12 mb-4">
      <div class="hero text-white hero-bg-image hero-bg-parallax" style="background-image: url('assets/img/unsplash/andre-benz-1214056-unsplash.jpg');">
        <div class="hero-inner">
          <h2>Welcome, {{Auth::user()->name}}</h2>
          <p class="lead">You need to complete the information about your account, so you can create post.</p>
          <div class="mt-4">
            <a href="{{route('users.profile')}}" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i> Setup Account</a>
          </div>
        </div>
      </div>
    </div>
    @endif
    <div class="row">
      <div class="col-12 col-sm-12 col-lg-9">
       <div class="col-12 col-sm-12 col-lg-12">
        <div class="card card-danger">
          <div class="card-header">
            <h4>Users</h4> 
            @can('user_show')
            <div class="card-header-action">
              <a href="{{route('users.index')}}" class="btn btn-danger btn-icon icon-right">View All <i class="fas fa-chevron-right"></i></a>
            </div>
            @endcan
          </div>
          <div class="card-body">
            <div class="owl-carousel owl-theme" id="users-carousel">
              @foreach ($users as $user)
              <div>
                <div class="user-item">
                  <img alt="image" width="30" height="60"
                  src="@if ($user->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} 
                  @else {{asset('uploads/avatar/'.$user->avatar)}}@endif" class="img-fluid">
                  <div class="user-details">
                    <div class="user-name">{{$user->name}}</div>
                    <div class="text-job text-muted">{{$user->roles->first()->name}}</div>
                    @can('user_detail')
                    <div class="user-cta">
                      <a href="{{route('users.show',$user->slug)}}" class="btn btn-primary " >View</a>
                    </div>
                    @endcan
                  </div>  
                </div>
              </div>      
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Popular posts in a week</h4>
            @hasrole('Admin')
            <div class="card-header-action">
              <a href="{{route('posts.index')}}" class="btn btn-primary">View All</a>
            </div>
            @endhasrole
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped mb-0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Action</th>
                    <th>Views</th>
                  </tr>
                </thead>
                <tbody>     
                  @foreach ($popularPost as $postP)  
                  <tr>
                    <td>
                      {{Str::limit($postP->title,60)}}
                      <div class="table-links">
                        <div class="bullet"></div>
                        <a href="{{route('posts.show',$postP->slug)}}">View</a>
                      </div>
                    </td>
                    <td>
                      @can('user_detail')
                      <a href="{{route('users.show',$postP->authors->slug)}}" class="font-weight-600"><img src="@if ($postP->authors->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} 
                        @else {{asset('uploads/avatar/'.$postP->authors->avatar)}}@endif" alt="avatar" width="30" class="rounded-circle mr-1">{{$postP->authors->name}}</a>
                      @else
                      <img src="@if ($postP->authors->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} 
                      @else {{asset('uploads/avatar/'.$postP->authors->avatar)}}@endif" alt="avatar" width="30" class="rounded-circle mr-1"><span class="text-primary font-weight-bold">{{$postP->authors->name}}</span>
                      @endcan
                    </td>
                    <td>
                      {{$postP->created_at->diffForHumans()}}
                    </td>
                    <td>
                      {{$postP->views}}
                    </td>
                  </tr>
                  @endforeach 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>@hasrole('Admin') @else Your @endhasrole Latest Post</h4>
            <div class="card-header-action">
              <a href="{{route('posts.index')}}" class="btn btn-primary">View All</a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped mb-0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Action</th>
                    <th>Views</th>
                  </tr>
                </thead>
                <tbody>     
                  @forelse($latestPost as $postL)  
                  <tr>
                    <td>
                      {{Str::limit($postL->title,60)}}
                      <div class="table-links">
                        <div class="bullet"></div>
                        <a href="{{route('posts.show',$postL->slug)}}">View</a>
                      </div>
                    </td>
                    <td>
                      @can('user_detail')
                      <a href="{{route('users.show',$postL->authors->slug)}}" class="font-weight-600"><img src="@if ($postL->authors->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} 
                        @else {{asset('uploads/avatar/'.$postL->authors->avatar)}}@endif" alt="avatar" width="30" class="rounded-circle mr-1">{{$postL->authors->name}}</a>
                      @else
                      <img src="@if ($postP->authors->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} 
                      @else {{asset('uploads/avatar/'.$postL->authors->avatar)}}@endif" alt="avatar" width="30" class="rounded-circle mr-1"><span class="text-primary font-weight-bold">{{$postL->authors->name}}</span>
                      @endcan
                    </td>
                    <td>
                    {{$postL->created_at->diffForHumans()}}
                    </td>
                    <td>
                      {{$postL->views}}
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center font-italic">
                        No post yet
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
     </div>
     <div class="col-12 col-sm-12 col-lg-3 sticky-top">
      <div class="card ">
        <div class="card-header">
          <h4 class="d-inline">Who's online ?</h4>
        </div>
        <div class="card-body">             
          <ul class="list-unstyled list-unstyled-border">
            @foreach ($users as $user)
            @if($user->isOnline())
            <li class="media">
              <img alt="image" width="50"
                src="@if ($user->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} 
                @else {{asset('uploads/avatar/'.$user->avatar)}}@endif" class="mr-3 rounded-circle" alt="avatar">
              <div class="media-body">
                <div class="badge badge-pill badge-white mb-1 float-right"><span class="text-primary">Online</span></div>
                <h6 class="media-title"> 
                  <a @can('user_detail')href="{{route('users.show',$user->slug)}} @endcan">{{$user->name}}</a>
                </h6>
                <div class="text-small text-muted">{{$user->roles->first()->name}}</div>
              </div>
            </li>
            @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    </div>
  </section>
@endsection

@push('css-external')
<link rel="stylesheet" href="{{asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">
@endpush

@push('css-internal')
<style>
.sticky-top {
  align-self: flex-start;
  top:10px;
  z-index: 1;
}

</style>
@endpush

@push('javascript-external')
<script src="{{asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/page/components-user.js')}}"></script>
@endpush