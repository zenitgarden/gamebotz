<div class="container">
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="navbar-top">
      <div class="d-flex justify-content-between align-items-center">
        <ul class="navbar-top-left-menu">
          <li class="nav-item">
            <a href="{{route('news.index')}}/category/pc" class="nav-link">PC</a>
          </li>
          <li class="nav-item">
            <a href="{{route('news.index')}}/category/console" class="nav-link">Console</a>
          </li>
          <li class="nav-item">
            <a href="{{route('news.index')}}/category/mobile" class="nav-link">Mobile</a>
          </li>
          <li class="nav-item">
            <a href="{{route('news.index')}}/category/ps-5" class="nav-link">PS 5</a>
          </li>
          <li class="nav-item">
            <a href="{{route('news.index')}}/category/xbox" class="nav-link">XBOX</a>
          </li>
        </ul>
        <ul class="social-media">
          <li>
            <a href="@if ($site != null) {{$site->facebook_link}} @else # @endif">
              <i class="mdi mdi-facebook"></i>
            </a>
          </li>
          <li>
            <a href="@if ($site != null) {{$site->youtube_link}} @else # @endif">
              <i class="mdi mdi-youtube"></i>
            </a>
          </li>
          <li>
            <a href="@if ($site != null) {{$site->twitter_link}} @else # @endif">
              <i class="mdi mdi-twitter"></i>
            </a>
          </li>
          <li>
            <a href="@if ($site != null) {{$site->instagram_link}} @else # @endif">
              <i class="mdi mdi-instagram"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="navbar-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <a class="navbar-brand" style="padding-top:0rem;" href="{{route('news.index')}}"
            ><img src="{{asset('assets/img/'.$site->logo)}}" alt="none"
          /></a>
        </div>
        <div>
          <button
            class="navbar-toggler"
            type="button"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="navbar-collapse justify-content-center collapse"
            id="navbarSupportedContent"
          >
            <ul
              class="navbar-nav d-lg-flex justify-content-between align-items-center"
            >
              <li>
                <button class="navbar-close">
                  <i class="mdi mdi-close"></i>
                </button>
              </li>
              <li class="nav-item">
                <a class="nav-link {{set_active('news.index')}}-nav" href="{{route('news.index')}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{set_active('news.news')}}-nav" href="{{route('news.news')}}">News</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{set_active('news.esport')}}-nav" href="{{route('news.esport')}}">Esport</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{set_active('news.tipsNtrick')}}-nav" href="{{route('news.tipsNtrick')}}">Tips & Trick</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{set_active('news.recom')}}-nav" href="{{route('news.recom')}}">Recommendation game</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{set_active('news.about')}}-nav" href="{{route('news.about')}}">About us</a>
              </li>
              <li id="se" class="nav-item">
                <div class="cntr">
                  <div class="cntr-innr">
                    <form  action="{{route('news.search')}}" method="GET" autocomplete="off">
                    <label class="search text-light" style="line-height: 0rem;" for="inpt_search">
                      <input id="inpt_search" type="search" name="s"/>
                    </label>
                  </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <ul class="social-media">
         
        </ul>
      </div>
    </div>
  </nav>
</div>