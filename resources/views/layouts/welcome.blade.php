<!DOCTYPE html>
<html lang="zxx">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @stack('meta')
    <title> @yield('title')</title>
    <!-- plugin css for this page -->
    <link
      rel="stylesheet"
      href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}"
    />
    <link rel="stylesheet" href="{{asset('assets/vendors/aos/dist/aos.css/aos.css')}}" />

    <link
    rel="stylesheet"
    href="{{asset('assets/vendors/owl.carousel/dist/assets/owl.carousel.min.css')}}"
    />
    <link
    rel="stylesheet"
    href="{{asset('assets/vendors/owl.carousel/dist/assets/owl.theme.default.min.css')}}"
     />
     <link rel="stylesheet" href="{{asset('assets/css/carousel.css')}}">
     <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">
    <!-- End plugin css for this page -->
    <link rel="shortcut icon" href="{{asset('assets/img/'.$site->favicon)}}" />

    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('assets/css/news/style.css')}}">
    <!-- endinject -->
    <style>
      @media (min-width: 992px){
      #se {
          margin-left: 35px !important;
      }
    }
    .active-nav{
        color:#007bff !important;
      }
      @media (max-width: 400px){
        .pagination .page-item .page-link{
        padding: 7px 25px;
      }
    }
    @media (max-width: 290px){
        .pagination .page-item .page-link{
        padding: 5px 15px;
      }
    }
    </style>
    @stack('css-internal')
  </head>

  <body>
    <div class="container-scroller">
      <div class="main-panel">
        <!-- partial:partials/_navbar.html -->
        <header id="header">
          {{-- Header --}}
          @include('layouts._news.header')
        </header>

        <!-- partial -->
        <div class="flash-news-banner">
          <div class="container">
            <div id="news-flash" class="owl-carousel text-center">
            @foreach ($flashPost as $fp)     
            <div class="d-lg-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <span class="badge badge-dark mr-3">Flash news</span>
                <a href="{{route('news.detail',$fp->title)}}" class="text-decoration-none">
                <p class="mb-0 font-weight-bold" style="color: black">
                  {{Str::limit($fp->title,80)}}
                </p>
              </a>
              </div>
              <div class="d-flex">
                <span class="mr-3 text-danger">{{date('D, F j , Y', strtotime($fp->created_at))}}</span>
              </div>
            </div>
            @endforeach
          </div>
          </div>
        </div>

        <div class="content-wrapper">
          {{-- Content --}}
          @yield('content')
        </div>
        <!-- main-panel ends -->
        <!-- container-scroller ends -->

        <!-- partial:partials/_footer.html -->
        <footer>
        {{-- Footer --}}
          @include('layouts._news.footer')
        </footer>

        <!-- partial -->
      </div>
    </div>
    <!-- inject:js -->
    <script id="dsq-count-scr" src="//gamebotz.disqus.com/count.js" async></script>
    <script src="{{asset('assets/modules/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{asset('assets/vendors/aos/dist/aos.js/aos.js')}}"></script>
    <script src="{{asset('assets/vendors/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{asset('assets/js/news/demo.js')}}"></script>
    <script src="{{asset('assets/js/caro.js')}}"></script>
    <script src="{{asset('assets/js/news/jquery.easeScroll.js')}}"></script>
    <!-- End custom js for this page-->
    @stack('javascript-internal')
  </body>
</html>
