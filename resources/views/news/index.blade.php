@extends('layouts.welcome')

@section('title')
Gamebotz
@endsection

@section('content')
<div class="container">
  <div class="row" data-aos="fade-up">
    <div class="col-xl-8">
    <div class="row" data-aos="fade-up">
      <div class="col-xl-12 stretch-card grid-margin">
        <div class="rounded owl-carousel owl-theme" id="main-banner-carousel">
          @foreach ($postCarousel as $post)
          <div class="item">
            <div class="carousel-content-wrapper mb-2">
              <div class="carousel-content">
                <h1 class="font-weight-bold">
                 <a href="{{route('news.detail',$post->slug)}}" style="color:white;" class="text-decoration-none">{{$post->title}}</a>
                </h1>
                <p class="text-color m-0 pt-2 d-flex align-items-center">
                  BY &nbsp;<span class="fs-5 mr-1 font-weight-bold">{{Str::upper($post->authors->name)}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                  <i class="far fa-clock mr-1"></i>
                  <span class="fs-5 mr-1">{{Str::upper($post->created_at->diffForHumans())}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                  <i class="far fa-comment text-light"></i>&nbsp;<a href="{{route('news.detail',$post->slug)}}#disqus_thread" class="text-light font-weight-bold">0</a>
                </p>
              </div>
              <div class="carousel-image">
                <img class="caro rounded img-fluid" src=" {{asset($post->thumbnail)}}" alt="" />
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    
      <div class="col-lg-12">
        <h4 class="recom"><i class="fas fa-dice"></i><span> RECOMENDATION GAME THIS WEEK</span></h4>
      </div>
 
    <div class="row" data-aos="fade-up">
        <div class="col-lg-12 pb-4 ">
            <div class="row">
                <div class="col-sm-5 grid-margin">
                  <div class="position-relative">
                    <div class="rotate-img">
                      <a href="{{route('news.recom')}}">
                      <img
                        src="{{asset($recom->thumbnail)}}"
                        alt="thumb"
                        class="list-p rounded img-fluid"
                      />
                    </a>
                    </div>
                  </div>
                </div>
                <div class="col-sm-7  grid-margin">
                  <h2 class="mb-2 font-weight-600">
                    <a href="{{route('news.recom')}}" class="text-secondary text-decoration-none">{{$recom->title}}</a>
                  </h2>
                  <div class="fs-13 mb-2">
                    <span class="mr-2"><i class="fas fa-dot-circle"></i></span> Recommendation Game
                  </div>
                  <p class="mb-0">
                    {{Str::limit($recom->excerpt,140)}}
                  </p>
                </div>
              </div>
        </div>
    </div> 
   
      <div class="col-lg-12 ">
        <h4 class="recom com1"><i class="far fa-newspaper"></i><span> LATEST NEWS</span></h4>
      </div>

    <div class="row" data-aos="fade-up">
      <div class="col-lg-12 stretch-card grid-margin">
        <div class="card">
          <div class="card-body">
            @foreach ($posts1 as $post)
            <div class="row">
              <div class="col-sm-5 grid-margin">
                <div class="position-relative">
                  <div class="rotate-img">
                    <a href="{{route('news.detail',$post->slug)}}">
                      <img
                      src="{{asset($post->thumbnail)}}"
                      alt="thumb"
                      class="list-p rounded img-fluid" />
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-sm-7  grid-margin">
                <h2 class="mb-2 font-weight-600">
                  <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
                </h2>
                <div class="fs-13 mb-2">
                  <span class="mr-2">by <a href="{{route('news.author',$post->authors->slug)}}" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span> 
                  <i class="far fa-clock text-primary"></i>&nbsp; {{$post->created_at->diffForHumans()}}
                  &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-comment text-primary"></i>&nbsp;<a href="{{route('news.detail',$post->slug)}}#disqus_thread" class="text-secondary">0</a>
                </div>
                <p class="mb-0">
                  {{Str::limit($post->excerpt,100)}}
                </p>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  
      <div class="col-lg-12 ">
        <h4 class="recom com2"><i class="fas fa-gamepad"></i><span> PC & CONSOLE</span></h4>
      </div>
    
    <div class="row" data-aos="fade-up">
      <div class="col-lg-12">
        <div id="owl-demo" class="caro-owl owl-carousel text-center">
          @foreach ($postsCaroP as $post)
          <div class="col-sm-12">
            <div class="border-bottom pb-3">
              <div class="rotate-img">
                <a href="{{route('news.detail',$post->slug)}}">
                <img
                  src="{{asset($post->thumbnail)}}"
                  alt="thumb"
                  class="caro-thumb-sm rounded img-fluid"
                />
                </a>
              </div>
              <p class="fs-16 font-weight-600 mb-0 mt-3" style="color:black;">
                <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
              </p>
              <p class="fs-13 text-muted mb-0">
                  {{$post->created_at->diffForHumans()}}
              </p>
            </div>
          </div>
          @endforeach
        </div>
        <div class="customNavigation">
          <a class="btn btn-outline-primary btn-sm mb-2 prev"><i class="fas fa-angle-left"></i> </a>
          <a class="btn btn-outline-primary btn-sm mb-2 next"><i class="fas fa-angle-right"></i> </a>
        </div>
        <hr>
      </div>
    </div>
    <div class="row" data-aos="fade-up">
      <div class="col-lg-12 stretch-card grid-margin">
        <div class="card">
          <div class="card-body">
            @foreach ($posts2 as $post)
            <div class="row">
              <div class="col-sm-5 grid-margin">
                <div class="position-relative">
                  <div class="rotate-img">
                    <a href="{{route('news.detail',$post->slug)}}">
                      <img
                      src="{{asset($post->thumbnail)}}"
                      alt="thumb"
                      class="list-p rounded img-fluid" />
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-sm-7  grid-margin">
                <h2 class="mb-2 font-weight-600">
                  <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
                </h2>
                <div class="fs-13 mb-2">
                  <span class="mr-2">by <a href="{{route('news.author',$post->authors->slug)}}" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
                  <i class="far fa-clock text-primary"></i>&nbsp; {{$post->created_at->diffForHumans()}}
                  &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-comment text-primary"></i>&nbsp;<a href="{{route('news.detail',$post->slug)}}#disqus_thread" class="text-secondary">0</a>
                </div>
                <p class="mb-0">
                  {{Str::limit($post->excerpt,100)}}
                </p>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    
      <div class="col-lg-12 ">
        <h4 class="recom com3"><i class="fas fa-mobile-alt"></i><span> Mobile</span></h4>
      </div>
 
    <div class="row" data-aos="fade-up">
      <div class="col-lg-12">
        <div id="owl-demo" class="caro-owl owl-carousel text-center">
          @foreach ($postsMb as $post)
          <div class="col-sm-12">
            <div class="border-bottom pb-3">
              <div class="rotate-img">
                <a href="{{route('news.detail',$post->slug)}}">
                <img
                  src="{{asset($post->thumbnail)}}"
                  alt="thumb"
                  class="caro-thumb-sm rounded img-fluid"
                />
                </a>
              </div>
              <p class="fs-16 font-weight-600 mb-0 mt-3" style="color:black;">
                <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
              </p>
              <p class="fs-13 text-muted mb-0">
                {{$post->created_at->diffForHumans()}}
              </p>
            </div>
          </div>
          @endforeach
        </div>
        <div class="customNavigation">
          <a class="btn btn-outline-primary btn-sm mb-2 prev"><i class="fas fa-angle-left"></i> </a>
          <a class="btn btn-outline-primary btn-sm mb-2 next"><i class="fas fa-angle-right"></i> </a>
        </div>
        <hr>
      </div>
    </div>
    <div class="row" data-aos="fade-up">
      <div class="col-lg-12 stretch-card grid-margin">
        <div class="card">
          <div class="card-body">
            @foreach ($posts->skip(6) as $post)
            <div class="row">
              <div class="col-sm-5 grid-margin">
                <div class="position-relative">
                  <div class="rotate-img">
                    <a href="{{route('news.detail',$post->slug)}}">
                      <img
                      src="{{asset($post->thumbnail)}}"
                      alt="thumb"
                      class="list-p rounded img-fluid" />
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-sm-7  grid-margin">
                <h2 class="mb-2 font-weight-600">
                  <a href="{{route('news.detail',$post->slug)}}" class="text-secondary text-decoration-none">{{$post->title}}</a>
                </h2>
                <div class="fs-13 mb-2">
                  <span class="mr-2">by <a href="{{route('news.author',$post->authors->slug)}}" class="text-primary font-weight-bold">{{$post->authors->name}}</a> </span>  
                  <i class="far fa-clock text-primary"></i>&nbsp; {{$post->created_at->diffForHumans()}}&nbsp;
                  &nbsp;&nbsp;&nbsp;<i class="far fa-comment text-primary"></i>&nbsp;<a href="{{route('news.detail',$post->slug)}}#disqus_thread" class="text-secondary">0</a>
                </div>
                <p class="mb-0">
                  {{Str::limit($post->excerpt,100)}}
                </p>
              </div>
            </div>
            @endforeach
            <div class="text-center load-more-val">
              <a href="{{route('news.news')}}" class="btn btn-primary"><span class="text-light">View All</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 sticky-top" id="side-tren">
    <div class="card bg-dark text-white">
      <div class="card-body">
        <h2 class="font-weight-bold">Trending news</h2>
        @foreach ($trending as $post)
        <div class="border-bottom-blue pb-4 pt-4">  
          <div class="row">
            <div class="col-sm-7">
              <h5 class="font-weight-600 mb-1">
                <a href="{{route('news.detail',$post->slug)}}" class="text-light text-decoration-none">{{$post->title}}</a>
              </h5>
              <p class="fs-13 text-muted mb-0">
                <i class="far fa-clock text-primary"></i>&nbsp; {{$post->created_at->diffForHumans()}}
                &nbsp;&nbsp;&nbsp;<i class="far fa-comment text-primary"></i>&nbsp;&nbsp;<a href="{{route('news.detail',$post->slug)}}#disqus_thread" class="text-light">0</a>
              </p>
            </div>
            <div class="col-sm-5">
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
        @endforeach
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('css-internal')
<style>
.sticky-top {
  align-self: flex-start;
  top:80px;
  z-index: 1;
}
</style>
@endpush
