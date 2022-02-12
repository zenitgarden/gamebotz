@extends('layouts.welcome')

@section('title')
{{$author->name}}, Author at Gamebotz
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4" data-aos="fade-up">
              <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                    <div class="post-comment-section" style="border-top:0px; margin-top: 0px; padding-top: 0px;">
                        <div class="testimonial" style="margin-bottom: 0px;">
                          <div
                            class="d-lg-flex justify-content-between align-items-center"
                          >
                            <div class="d-flex align-items-center mb-3">
                              <div class="">
                                <img
                                  src="@if (!$author->avatar == null) {{asset('uploads/avatar/'.$author->avatar)}} 
                                  @else {{asset('/assets/img/avatar/avatar-1.png')}} @endif"
                                  alt="banner"
                                  class="img-fluid img-rounded mr-3"
                                />
                              </div>
                              <div>
                                <p class="fs-12 mb-1 line-height-xs">
                                  Author
                                </p>
                                <h4
                                  class=" font-weight-600 mb-0 line-height-xs"
                                >
                                  {{$author->name}}
                            </h4>
                              </div>
                            </div>
                            <ul class="social-media mb-3">
                                @if ($author->facebook_link != null)
                                <li>
                                    <a href="{{$author->facebook_link}}">
                                      <i class="mdi mdi-facebook"></i>
                                    </a>
                                  </li>
                                @endif
                                @if ($author->youtube_link != null)
                              <li>
                                <a href="{{$author->youtube_link}}">
                                  <i class="mdi mdi-youtube"></i>
                                </a>
                              </li>
                              @endif
                              @if ($author->twitter_link != null)
                              <li>
                                <a href="{{$author->twitter_link}}">
                                  <i class="mdi mdi-twitter"></i>
                                </a>
                              </li>
                              @endif
                              @if ($author->instagram_link != null)
                              <li>
                                <a href="{{$author->instagram_link}}">
                                  <i class="mdi mdi-instagram"></i>
                                </a>
                              </li>
                              @endif
                            </ul>
                          </div>
                          <p class="fs-12">
                           @if ($author->description == null)
                               <p class="font-italic">No description about author for now</p>
                               @else
                               {!!$author->description!!}
                           @endif
                          </p>
                        </div>
                    </div>
                      </div>
                </div>
            </div>
          </div>
        </div>
    <div class="col-sm-12">
      <div class="card" data-aos="fade-up">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 mb-4">
              <h2 class="font-weight-600 mb-4 text-center">
                Showing all news by {{$author->name}}
              </h2>
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
                    <span class="mr-2">by <a href="#" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
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
                        <span class="mr-2">by <a href="{{route('news.author',$post->authors->slug)}}" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
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
                  <img
                    src="{{asset($post->thumbnail)}}"
                    alt="banner"
                    class="img-fluid"
                  />
                </div>
                <h3 class="mt-3 font-weight-600">
                 {{$post->title}}
                </h3>
                <p class="fs-13 text-muted mb-0">
                  <span class="mr-2">by <a href="{{route('news.author',$post->authors->slug)}}" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
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