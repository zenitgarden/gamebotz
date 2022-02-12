@extends('layouts.dashboard')

@section('title')
{{$user->name}} - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>{{$user->name}}</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></div>
        <div class="breadcrumb-item">{{$user->name}}</div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">{{$user->name}}</h2>
      <p class="section-lead">
        Let see more about {{$user->name}}.
      </p>

      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
          <div class="card profile-widget">
            <div class="profile-widget-header">                     
              <img alt="image" src="@if ($user->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} @else {{asset('uploads/avatar/'.$user->avatar)}} @endif" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Username</div>
                  <div class="profile-widget-item-value">@if ($user->username == null) - @else {{$user->username}} @endif</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Posts</div>
                  <div class="profile-widget-item-value">{{$user->postPub->count()}}</div>
                </div>
              </div>
            </div>
            <div class="profile-widget-description">
              <div class="profile-widget-name">{{$user->name}}<div class="text-muted d-inline font-weight-normal"><div class="slash"></div> @if ($user->hasanyrole($roles) == true) {{$user->roles->first()->name}} @else <span class="text-danger">DO NOT HAVE ROLE</span>  @endif</div></div>
              @if ($user->description == null)  <label class="text-muted font-italic"> No description , who am i ?</label> @else {!!$user->description!!} @endif
            </div>
            <div class="card-footer text-center">
              <div class="font-weight-bold mb-2">@if ($user->facebook_link == null && $user->twitter_link == null && $user->instagram_link == null && $user->youtube_link == null) I don't have social media :( @else Follow {{$user->name}} On @endif</div>
              <a href="{{$user->facebook_link}}" class="btn btn-social-icon btn-facebook mr-1 @if ($user->facebook_link == null) d-none @endif">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="{{$user->twitter_link}}" class="btn btn-social-icon btn-twitter mr-1 @if ($user->twitter_link == null) d-none @endif">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="{{$user->instagram_link}}" class="btn btn-social-icon btn-instagram mr-1 @if ($user->instagram_link == null) d-none @endif">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="{{$user->youtube_link}}" class="btn btn-social-icon btn btn-light @if ($user->youtube_link == null) d-none @endif">
                <i style="color: red;" class="fab fa-youtube"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>{{$user->name}}, Latest Posts</h4>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Created at</th>
                        <th>Views</th>
                        <th> </th>
                      </tr>
                    </thead>
                    <tbody>     
                    @forelse ($userPost as $post )                     
                      <tr>
                        <td >
                           <a href="{{route('posts.show',$post->slug)}}">{{Str::limit($post->title,50)}}</a>
                        </td>
                        <td>
                            {{$post->created_at->diffForHumans()}}
                        </td>
                        <td>
                            {{$post->views}}
                        </div>
                        <td>
                            <a href="{{route('posts.show',$post->slug)}}" data-toggle="tooltip" title="View detail post"><i class="fas fa-eye" style="font-size: 20px;"></i></a>
                        </div>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td class="text-center font-italic" colspan="4">
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
    </div>
  </section>
@endsection

@push('css-external')
<link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}">
@endpush

@push('javascript-internal')
<script>
        
</script>
@endpush


