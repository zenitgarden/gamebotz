@extends('layouts.welcome')

@section('title')
{{$post->title}}
@endsection

@section('content')
<div class="container">
    <div class="col-sm-12">
      <div class="card" data-aos="fade-up">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8">
              <div>
                <h1 class="font-weight-600 mb-1">
                 {{$post->title}}
                </h1>
                <div class="row">
                  <div class="col-12">
                    <p class="fs-13 text-muted mb-0 d-inline">
                      <img alt="image" src="{{asset('uploads/avatar/'.$post->authors->avatar)}}" width="35" class="rounded-circle mr-1"> 
                      <span class="mr-2">by <a href="#" class="text-primary font-weight-bold">{{$post->authors->name}}</a></span>| &nbsp;{{$post->created_at->diffForHumans()}} &nbsp;&nbsp; In 
                      @foreach ($post->categories as $category)
                      {{ $loop->first ? '' : ', ' }}
                      <label class="font-weight-bold"> <a href="@if ($category->title == 'News') {{route('news.news')}} @elseif($category->title == 'Esports') {{route('news.esport')}} @elseif($category->title == 'Tips & Tricks') {{route('news.tipsNtrick')}} @else {{route('news.category',$category->slug)}} @endif" class="text-secondary text-decoration-none">{{$category->title}}</a></label>
                      @endforeach
                      <div id="detail-txt" class=" pt-2 pr-2 float-right d-inline"> 
                        <i class="far fa-comment text-primary "></i>&nbsp;<a href="{{route('news.detail',$post->slug)}}#disqus_thread" class="text-secondary">0</a>
                      </div>
                  </p>
                  </div>
                </div>
                <div class="mt-1 rotate-img">
                  <img
                    src="{{asset($post->thumbnail)}}"
                    alt="banner"
                    class="rounded img-fluid mt-4 mb-4"
                  />
                </div>
                <p class="mb-4 fs-15">
                 {!!$post->content !!}
                </p>
              </div>
              <div class="d-lg-flex">
                <span class="fs-16 font-weight-600 mr-2 mb-1">Tags</span> : &nbsp;
                @foreach ($post->tags as $tag )
                <a href="{{route('news.tag',$tag->slug)}}" class="text-decoration-none"><span class="badge badge-outline-dark mr-2 mb-1 font-weight-bold active-tag">{{$tag->title}}</span></a>
                @endforeach
              </div>
              <div class="post-comment-section">
                <h3 class="font-weight-600">Related Posts</h3>
                <div class="row">
                  @foreach ($related as $p)
                  <div class="col-sm-6">
                    <div class="post-author">
                      <div class="rotate-img">
                        <a href="{{route('news.detail',$p->slug)}}">
                        <img
                          src="{{asset($p->thumbnail)}}"
                          alt="banner"
                          class="img-fluid"
                        />
                        </a>
                      </div>
                      <div class="post-author-content">
                        <h5 class="mb-1">
                          <a href="{{route('news.detail',$p->slug)}}" class="text-dark text-decoration-none">{{$p->title}}</a>
                        </h5>
                        <p class="fs-13 text-muted mb-0">
                          <span class="mr-2">by <a href="{{route('news.author',$p->authors->slug)}}" class="text-primary font-weight-bold">{{$p->authors->name}}</a> </span>  
                          <i class="far fa-clock text-primary"></i>&nbsp; {{$p->created_at->diffForHumans()}}
                        </p>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>

                <div class="comment-section">
                  <h3 class="font-weight-600">Comments</h3>
                  <div id="disqus_thread"></div>
                  
                  <script>
                      /**
                      *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                      *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                      
                      var disqus_config = function () {
                      this.page.url = '{{Request::url()}}';  // Replace PAGE_URL with your page's canonical URL variable
                      this.page.identifier = '/news/{{$post->slug}}'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                      };
                      
                      (function() { // DON'T EDIT BELOW THIS LINE
                      var d = document, s = d.createElement('script');
                      s.src = '{{$site->disqus_plugin}}';
                      s.setAttribute('data-timestamp', +new Date());
                      (d.head || d.body).appendChild(s);
                      })();
                  </script>
                  <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                 
              
                </div>
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
@endsection

@push('css-internal')
<style>  
.active-tag:hover{
  color: #007bff
  }
</style>
@endpush