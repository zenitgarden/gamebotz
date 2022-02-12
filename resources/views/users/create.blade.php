@extends('layouts.dashboard')

@section('title')
Add User - Gamebotz
@endsection

@section('content')
    <section class="section">
      <div class="section-header">
        <h1>Add User</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></div>
          <div class="breadcrumb-item">Add User</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Guide !</h2>
            <p class="section-lead">You can do it boyoooo...!</p>
                <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                      <a href="{{route('users.index')}}" class="btn btn-primary rounded-sm" role="button">
                        <i class="fas fa-arrow-left"></i> Go back
                      </a>
                    </div>
                  <form action="{{route('users.store')}}" method="POST">
                    @csrf         
                    <div class="card-body">
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                        {{-- Name --}}
                        <div class="col-sm-12 col-md-7">
                            <input type="text" id="input_user_name" name="name" value="{{old('name')}}" 
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                        {{-- Email --}}
                        <div class="col-sm-12 col-md-7">
                            <input type="email" id="input_user_email" name="email" value="{{old('email')}}"
                             class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" >
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Role</label>
                            {{-- Role --}}
                            <div class="col-sm-12 col-md-7">
                                <select id="select-2" name="role" 
                                    data-placeholder="Select Role" style="clear:both;" class="form-control select2 @error('role') is-invalid @enderror ">
                                    @if (old('role'))
                                        <option value="{{old('role')->id}}" selected>{{old('role')->name}}</option>
                                    @endif
                                </select>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                                {{-- Password --}}
                                <div class="col-sm-12 col-md-7">
                                    <input type="password" id="input_user_password" name="password" 
                                     class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" autocomplete="new-password">
                                     @error('password')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                     <div class="custom-control custom-checkbox mt-2">
                                     <input type="checkbox" class="custom-control-input" id="customCheck1"  onclick="myFunction()">
                                    <label class="custom-control-label" for="customCheck1">Show Password</label>
                                </div>
                                </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Confirmation</label>
                                    {{-- Confirm Password --}}
                                    <div class="col-sm-12 col-md-7">
                                        <input type="password" id="input_user_password_confirmation" name="password_confirmation" 
                                         class="form-control" placeholder="Re-enter password" autocomplete="new-password">
                                    </div>
                                    </div>
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                        </div>
                    </div>
                  </form>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection

@push('css-external')
<link rel="stylesheet" href="{{asset('assets/modules/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/select2/css/select2-bootstrap4.min.css')}}">
@endpush

@push('css-internal')
<style>
.select2 {
width:100%!important;

}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    min-height: 42px;
    line-height: 42px;
    padding-left: 12px !important;
    padding-right: 20px;
}
.select2-selection__clear{
    margin-right: 18px;
    width: 0.9em;
    height: 0.9em;
    padding-left: 0.15em;
    margin-top: 1em;
    margin-right: 1.3em;
    line-height: .75em;
    color: #f8f9fa;
    background-color: #c8c8c8;
     border-radius: 100%;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #050505;
    line-height: 28px;
    font-weight: bold;
}
</style>
@endpush

@push('javascript-external')
<script src="{{asset('assets/modules/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/modules/select2/js/i18n/en.js')}}"></script>
@endpush

@push('javascript-internal')
   <script>
     $(function() {
         //select role
         $('#select-2').select2({
           
            language: "{{ app()->getLocale() }}",
            allowClear: true,
            ajax: {
               url: "{{ route('roles.select') }}",
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                  return {
                     results: $.map(data, function(item) {
                        return {
                           text: item.name,
                           id: item.id
                        }
                     })
                  };
               }
            }
         });     
      });

    function myFunction() {
    var x = document.getElementById("input_user_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    }
</script>
@endpush