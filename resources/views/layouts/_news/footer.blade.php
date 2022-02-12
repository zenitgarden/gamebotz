<div class="footer-top">
    <div class="container">
      <div class="row">
        <div id="this-long" class="col-sm-5">
          <img src="" class="footer-logo" alt="" />
          <h5 class="font-weight-normal mt-4 mb-5">
            Newspaper is your news, entertainment, music fashion website. We
            provide you with the latest breaking news and videos straight from
            the entertainment industry.
          </h5>
          <ul class="social-media mb-3">
            <li>
              <a href="@if ($site != null){{$site->facebook_link}}@else#@endif">
                <i class="mdi mdi-facebook"></i>
              </a>
            </li>
            <li>
              <a href="@if ($site != null){{$site->youtube_link}}@else#@endif">
                <i class="mdi mdi-youtube"></i>
              </a>
            </li>
            <li>
              <a href="@if ($site != null){{$site->twitter_link}} @else#@endif">
                <i class="mdi mdi-twitter"></i>
              </a>
            </li>
            <li>
              <a href="@if ($site != null){{$site->instagram_link}}@else#@endif">
                <i class="mdi mdi-instagram"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-sm-4">
          <h3 class="font-weight-bold mb-3">Trending POSTS</h3>
          @foreach ($trending as $post)
          <div class="row">
            <div class="col-sm-12">
              <div class="footer-border-bottom pb-4 mb-1">
                <div class="row">
                  <div class="col-3">
                    <a href="{{route('news.detail',$post->slug)}}">
                    <img
                      src="{{asset($post->thumbnail)}}"
                      alt="thumb"
                      class="img-fluid"
                    />
                  </a>
                  </div>
                  <div class="col-9">
                    <h5 class="font-weight-600">
                      <a href="{{route('news.detail',$post->slug)}}" class="text-decoration-none text-light">{{$post->title}}</a>
                    </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="col-sm-3">
          <h3 class="font-weight-bold mb-3">CATEGORIES</h3>
          <div class="footer-border-bottom pb-2">
            <div class="d-flex justify-content-between align-items-center">
              <a href="{{route('news.index')}}/category/pc" class="text-decoration-none text-light"><h5 class="mb-0 font-weight-600">PC</h5></a>
            </div>
          </div>
          <div class="footer-border-bottom pb-2 pt-2">
            <div class="d-flex justify-content-between align-items-center">
              <a href="{{route('news.index')}}/category/console" class="text-decoration-none text-light"><h5 class="mb-0 font-weight-600">Console</h5></a>
            </div>
          </div>
          <div class="footer-border-bottom pb-2 pt-2">
            <div class="d-flex justify-content-between align-items-center">
              <a href="{{route('news.index')}}/category/mobile" class="text-decoration-none text-light"><h5 class="mb-0 font-weight-600">Mobile</h5></a>
            </div>
          </div>
          <div class="footer-border-bottom pb-2 pt-2">
            <div class="d-flex justify-content-between align-items-center">
              <a href="{{route('news.index')}}/category/ps-5" class="text-decoration-none text-light"><h5 class="mb-0 font-weight-600">PS 5</h5></a>
            </div>
          </div>
          <div class="footer-border-bottom pb-2 pt-2">
            <div class="d-flex justify-content-between align-items-center">
             <a href="{{route('news.index')}}/category/xbox" class="text-decoration-none text-light"><h5 class="mb-0 font-weight-600">XBOX</h5></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="d-sm-flex justify-content-center align-items-center">
            <div class="fs-14 font-weight-600">
              © 2020  All rights reserved.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>