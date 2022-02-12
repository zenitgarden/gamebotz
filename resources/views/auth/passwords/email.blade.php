<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Forgot Password &mdash; Gamebotz</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  {{-- <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css"> --}}

  <!-- Template CSS -->
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/components.css">

  <link rel="shortcut icon" href="{{asset('assets/img/'.$site->favicon)}}" />
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{asset('assets/img/'.$site->favicon)}}" alt="logo" width="100"  class="mr-5">
            </div>

            <div class="card card-primary">
                <div class="card-header"><h4>Forgot Password</h4></div>

                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <span class="text-dark font-weight-bold">{{ session('status') }}</span>
                </div>
                @endif

                <div class="card-body">
                  <p class="text-muted">We will send a link to reset your password</p>
                  <form method="POST" id="formSubmit" action="{{route('password.email')}}">
                      @csrf
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" tabindex="1" placeholder="Enter email" value="{{old('email')}}" required autofocus>
                      @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                     @enderror
                    </div>
  
                    <div class="form-group">
                      <div class="pls-wait d-none">It takes time, please wait...</div>
                      <button type="submit" id="submitBtn" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Forgot Password
                      </button>
                    </div>
                    <div class="row justify-content-center">
                      <div class="">
                        <a href="{{ route('login') }}" class="text-small">
                          Back to login
                        </a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('assets/modules/jquery.min.js')}}"></script>
  <script src="{{asset('assets/modules/popper.js')}}"></script>
  <script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('assets/modules/moment.min.js')}}"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="/assets/js/scripts.js"></script>
  <script src="/assets/js/custom.js"></script>
  <script>
    $(function () {

    $("#formSubmit").on('submit',function(e){
      
      $('#submitBtn').attr("disabled", true);
      $('.pls-wait').removeClass("d-none");
    });
  });
  </script>

  <!-- Page Specific JS File -->
</body>
</html>
