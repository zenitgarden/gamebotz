@extends('layouts.welcome')

@section('title')
Tag : {{$tag->title}} - Gamebotz
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="card" data-aos="fade-up">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 mb-4">
              <h1 class="font-weight-600 mb-4">
                Tag : {{$tag->title}}
              </h1>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8">
            @foreach ($posts as $post)
              <div class="row">
                <div class="col-sm-5 grid-margin">
                  <div class="rotate-img">
                    <a href="{{route('news.detail',$post->slug)}}">
                    <img
                      src="{{asset($post->thumbnail)}}"
                      alt="banner"
                      class="list-p rounded img-fluid"
                    />
                    </a>
                  </div>
                </div>
                <div class="col-sm-7 grid-margin">
                  <h2 class="font-weight-600 mb-2">
                    <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
                  </h2>
                  <p class="fs-13 text-muted mb-0">
                    <span class="mr-2">by <a href="{{route('news.author',$post->authors->slug)}}" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
                    <i class="far fa-clock text-primary"></i>&nbsp; {{$post->created_at->diffForHumans()}}
                  </p>
                  <p class="fs-15">
                    {{Str::limit($post->excerpt,100)}}
                  </p>
                </div>
              </div>
              @endforeach
              <div class="d-flex justify-content-center mt-3 mb-3">
                {{ $posts->links('vendor.pagination.bootstrap-4')}}
            </div>
          </div>
          <div class="col-lg-4">
            <h2 class="mb-4 text-primary font-weight-600">
              Latest news
            </h2>
            <div class="row">
            @foreach ($latestPost as $post)
              <div class="col-sm-12">
                <div class="border-bottom pb-4 pt-4">  
                  <div class="row">
                    <div class="col-sm-8">
                      <h5 class="font-weight-600 mb-1">
                        <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
                      </h5>
                      <p class="fs-13 text-muted mb-0">
                        <span class="mr-2">by <a href="#" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
                        <i class="far fa-clock text-primary"></i>&nbsp; {{$post->created_at->diffForHumans()}}
                      </p>
                    </div>
                    <div class="col-sm-4">
                      <div class="rotate-img">
                        <a href="{{route('news.detail',$post->slug)}}">
                        <img
                          src="{{asset($post->thumbnail)}}"
                          alt="banner"
                          class="rounded img-fluid"
                        />
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <div class="trending">
              <h2 class="mb-4 text-primary font-weight-600">
                Trending
              </h2>
              @foreach ($trending as $post)   
              <div class="mb-4">
                <div class="rotate-img">
                  <a href="{{route('news.detail',$post->slug)}}">
                  <img
                    src="{{asset($post->thumbnail)}}"
                    alt="banner"
                    class="img-fluid"
                  />
                  </a>
                </div>
                <h3 class="mt-3 font-weight-600">
                  <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
                </h3>
                <p class="fs-13 text-muted mb-0">
                  <span class="mr-2">by <a href="#" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
                  <i class="far fa-clock text-primary"></i>&nbsp; {{$post->created_at->diffForHumans()}}
                </p>
              </div>  
              @endforeach          
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 </div>
</div>
@endsection