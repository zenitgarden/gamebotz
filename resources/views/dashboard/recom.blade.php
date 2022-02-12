@extends('layouts.dashboard')

@section('title')
Recommendation Game - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Recommendation Game</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
        <div class="breadcrumb-item">Recommendation Game</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">This is Recommendation Game Page</h2>
      <p class="section-lead">This page is for you to updating a new recommendation game for this week.</p>
      <div class="card">
        @if (Auth::user()->can('recommendation_game_edit'))
        <div class="card-header">
              <a data-toggle="tooltip" title="Click here to edit post" href="{{route('dashboard.recom.edit')}}" class="btn btn-sm btn-info" role="button">
                <i class="fas fa-edit"></i> Edit 
              </a>
        </div>
        @endif
        <div class="card-body">
            <h3 class="text-dark font-weight-bold">{{$post->title}}</h3>
          
          <div class="d-sm-none d-lg-inline-block">
             Last Update : {{$post->updated_at->diffForHumans()}}&nbsp; by <span class="text-primary  font-weight-bold">{{$post->authors->name}}</span> &nbsp;in
              @foreach ($categories as $category)
              {{ $loop->first ? '' : ', ' }}
            <label class="font-weight-bold">{{$category->title}}</label>
              @endforeach
            </div>  
            
            <img src="{{$post->thumbnail}}" class="img-fluid rounded mx-auto d-block my-4"  alt="Responsive image">
            {!!$post->content!!}
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
