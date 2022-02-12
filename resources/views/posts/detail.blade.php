@extends('layouts.dashboard')

@section('title')
{{$post->title}} - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Detail Page</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('posts.index')}}">Post</a></div>
        <div class="breadcrumb-item">{{$post->title}}</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p>
      <div class="card">
        <div class="card-header">
            <a href="{{route('posts.index')}}" class="btn btn-primary rounded-sm" role="button">
                <i class="fas fa-arrow-left"></i> Back
              </a><h4></h4>
              @if (Auth::user()->hasRole('Admin') || Auth::user()->id == $post->user_id)
              <a data-toggle="tooltip" title="Click here to edit post" href="{{route('posts.edit',['post'=>$post])}}" class="btn btn-sm btn-info" role="button">
                <i class="fas fa-edit"></i> Edit 
              </a>
              @endif
        </div>
        <div class="card-body">
            <h3 class="text-dark font-weight-bold">{{$post->title}}</h3>
            <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" width="35" class="rounded-circle mr-1">
          <div class="d-sm-none d-lg-inline-block">
              by <label class="text-primary"> 
                @can('user_detail')
                <a href="{{route('users.show',$post->authors->slug)}}">{{$post->authors->name}}</a>
                @else
                <span class="text-primary font-weight-bold">{{$post->authors->name}}</span>
                @endcan
              </label> &nbsp;| 
              &nbsp;{{$post->created_at->diffForHumans()}} &nbsp;in
              @foreach ($categories as $category)
              {{ $loop->first ? '' : ', ' }}
            <label class="font-weight-bold">{{$category->title}}</label>
              @endforeach
            </div>  
            
            <img src="{{$post->thumbnail}}" class="img-fluid rounded mx-auto d-block my-4"  alt="Responsive image">
            {!!$post->content!!}
        </div>
        <div class="card-footer bg-whitesmoke">
          Tags : 
          @foreach ($tags as $tag)
            {{ $loop->first ? '' : ', ' }}
            <label class="font-weight-bold">{{$tag->title}}</label>
          @endforeach
        </div>
      </div>
    </div>
    
  </section>
@endsection
@push('css-internal')
<style>
    .img-fluid {
    width: 700px;				/* width of image (px or % or auto) */
    height: 400px;				/* height of image (px or % or auto) */
}
</style>
@endpush
