<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Change Password &mdash; Gamebotz</title>

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
              <img src="{{asset('assets/img/'.$site->favicon)}}" alt="logo" width="100" class="mr-5">
            </div>
            <div class="card card-primary">
                <div class="card-header"><h4>Change Password</h4></div>
  
                <div class="card-body">
                  <form method="POST" id="submitPass" action="{{route('users.updatePassword')}}">
                    @csrf
                    <div class="form-group">
                      <label for="current_password">Current Password</label>
                      <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" value="{{old('current_password') }}" name="current_password" tabindex="1" required >
                      @error('current_password')
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                    </div>
  
                    <div class="form-group">
                      <label for="password">New Password</label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"  name="password" tabindex="2" required >
                      @error('password')
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                    @enderror
                      </div>
                      <div class="form-group">
                        <label for="password-confirm">Confirm New Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" tabindex="3" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" id="btnSM" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Save
                      </button>
                    </div>
                  </form>
                  <div class="row justify-content-center">
                    <div class="">
                      <a href="{{ route('users.profile') }}" class="text-small">
                        <i class="fas fa-arrow-left"></i> Back to profile
                      </a>
                    </div>
                  </div>
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
  <script>$(function () { $("#submitPass").on('submit',function(e){ $('#btnSM').attr("disabled", true); }); });</script>
  <!-- Page Specific JS File -->
</body>
</html>
