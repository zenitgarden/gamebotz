@extends('layouts.dashboard')

@section('title')
Profile - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Profile</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Profile</div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Hi, {{$user->name}}</h2>
      <p class="section-lead">
        Change information about yourself on this page.
      </p>

      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
          <div class="card profile-widget">
            <div class="profile-widget-header">                     
              <img alt="image" src="@if ($user->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} @else {{asset('uploads/avatar/'.$user->avatar)}} @endif" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Username</div>
                  <div class="profile-widget-item-value">@if ($user->username == null) - @else {{$user->username}} @endif</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Posts</div>
                  <div class="profile-widget-item-value">{{$user->postPub->count()}}</div>
                </div>
              </div>
            </div>
            <div class="profile-widget-description">
              <div class="profile-widget-name">{{$user->name}}<div class="text-muted d-inline font-weight-normal"><div class="slash"></div> {{$user->roles->first()->name}}</div></div>
              @if ($user->description == null)  <label class="text-muted font-italic"> No description , who am i ?</label> @else {!!$user->description!!} @endif
            </div>
            <div class="card-footer text-center">
              <div class="font-weight-bold mb-2">@if ($user->facebook_link == null && $user->twitter_link == null && $user->instagram_link == null && $user->youtube_link == null) I don't have social media :( @else Follow {{$user->name}} On @endif</div>
              <a href="{{$user->facebook_link}}" class="btn btn-social-icon btn-facebook mr-1 @if ($user->facebook_link == null) d-none @endif">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="{{$user->twitter_link}}" class="btn btn-social-icon btn-twitter mr-1 @if ($user->twitter_link == null) d-none @endif">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="{{$user->instagram_link}}" class="btn btn-social-icon btn-instagram mr-1 @if ($user->instagram_link == null) d-none @endif">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="{{$user->youtube_link}}" class="btn btn-social-icon btn btn-light @if ($user->youtube_link == null) d-none @endif">
                <i style="color: red;" class="fab fa-youtube"></i>
              </a>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4>Social Media</h4>
              <div class="card-header-action">
                <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
              </div>
            </div>
            <div class="collapse show" id="mycard-collapse">
              <form  method="post" id="submitSM" action="{{route('users.update.sm')}}">
                @csrf
                @method('PUT')
              <div class="card-body">
                  <div class="form-group ">
                    <label>Facebook</label>
                    <input type="text" class="form-control @error('facebook') is-invalid @enderror" 
                    name="facebook" value="{{old('facebook',$user->facebook_link)}}" 
                    placeholder="https://www.facebook.com ?? share here !" @if ($errors->has('facebook')) autofocus @endif>
                    @error('facebook')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group ">
                    <label>Twitter</label>
                    <input type="text" class="form-control @error('twitter') is-invalid @enderror" 
                    name="twitter" value="{{old('twitter',$user->twitter_link)}}" 
                    placeholder="https://www.twitter.com ?? share here !" @if ($errors->has('twitter')) autofocus @endif>
                    @error('twitter')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group ">
                    <label>Instagram</label>
                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" 
                    name="instagram" value="{{old('instagram',$user->instagram_link)}}" 
                    placeholder="https://www.twitter.com ?? share here !" @if ($errors->has('instagram')) autofocus @endif>
                    @error('instagram')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group ">
                    <label>YouTube</label>
                    <input type="text" class="form-control @error('youtube') is-invalid @enderror" 
                    name="youtube" value="{{old('youtube',$user->youtube_link)}}" 
                    placeholder="https://www.youtube.com ?? share here !" @if ($errors->has('youtube')) autofocus @endif>
                    @error('youtube')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary" id="btnSM" type="submit">Save Changes</button>
                  </div>
              </div>
              <div class="card-footer bg-whitesmoke">
                Share the social media links. Make sure the link include : (https://example.com) Okay <i class="fas fa-thumbs-up"></i>
              </div>
              </form>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-md-12 col-lg-7">
          <div class="card">
              <div class="card-header">
                <h4>Edit Profile</h4>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-center">
                  <div class="text-center border-0">
                      <div class="card-body">
                          <h5 class="card-title">Avatar Profile</h5>
                          <div class="profile-img p-3">
                              <img src="@if ($user->avatar == null) {{asset('assets/img/avatar/avatar-1.png')}} @else {{asset('uploads/avatar/'.$user->avatar)}} @endif" 
                              class="rounded-circle profile-widget-picture" id="profile-pic">
                             
                          </div>
                          <div class="btn btn-primary">
                              <input type="file" class="file-upload @error('profile_picture') is-invalid @enderror" id="file-upload" 
                              name="profile_picture"  accept="image/*">
                              Change avatar
                          </div>
                          @error('profile_picture')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                  </div>
              </div>
              <form method="post" id="formSubmit" action="{{route('users.update.profile')}}" class="needs-validation"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                <div class="row">                               
                    <div class="form-group col-md-12 col-12">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid
                      @enderror" value="{{old('name',$user->name)}}" placeholder="Your name" @if ($errors->has('name')) autofocus @endif>
                      @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6 col-12">
                      <label>Username</label>
                      <input type="text" name="username" id="input_username" value="{{old('username',$user->username)}}" 
                      class="form-control @error('username') is-invalid @enderror" placeholder="What do we call you ?" @error('username') autofocus @endif>
                      <input type="text" name="slug" id="input_slug" class="form-control d-none" value="{{old('slug',$user->slug)}}" placeholder="it's hidden" readonly>
                      @error('username')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                      value="{{old('email',$user->email)}}" placeholder="Your email" @if ($errors->has('email')) autofocus @endif readonly>
                      @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-12">
                      <label>Bio</label>
                      <textarea id="description" name="description" class="form-control" placeholder="Tell us about you here !">{{old('description',$user->description)}}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-12 text-md-right">
                      <button class="btn btn-primary" id="submitBtn" type="submit" >Save Changes</button>
                    </div>
                  </div>
              </div>
            </form>
          </div>
          <div class="card">
            <div class="card-body border-left border-primary">
              <a href="{{route('users.passwordPage')}}" class="text-dark font-weight-bold">Change password</a> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
              <h4 class="modal-title">Upload image</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
              <div id="resizer"></div>
              <button class="btn btn-block btn-primary" id="upload" >Save</button>
          </div>
      </div>
  </div>
</div>
@endsection


@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('css-external')
<link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/croppie/croppie.css')}}">
@endpush

@push('css-internal')
<style type="text/css">
  .nounderline, .violet{
      color: #7c4dff !important;
  }
  .btn-primary {
      background-color: #7c4dff !important;
      border-color: #7c4dff !important;
  }
  .btn-primary .file-upload {
      width: 100%;
      padding: 10px 0px;
      position: absolute;
      left: 0;
      opacity: 0;
      cursor: pointer;
  }
  .profile-img img{
      width: 150px;
      border-radius: 50%;
  }    
  </style>
@endpush

@push('javascript-external')
{{-- TinyMCE5 --}}
<script src="{{asset('vendor/tinymce5/jquery.tinymce.min.js')}}"></script>
<script src="{{asset('vendor/tinymce5/tinymce.min.js')}}"></script>

<script src="{{asset('assets/modules/croppie/croppie.js')}}"></script>
@endpush

@push('javascript-internal')
<script>
    $(document).ready(function(){
        
      // Event:auto generate slug
            $("#input_username").change(function (event) {
            $("#input_slug").val(
         event.target.value
            .trim()
            .toLowerCase()
            .replace(/[^a-z\d-]/gi, "-")
            .replace(/-+/g, "-")
            .replace(/^-|-$/g, "")
      );
      });
   

      // TinyMCE5
      $("#description").tinymce({
        content_style: "body { font-family: Source Sans Pro; color: black; }",
        statusbar: false,
        language: "en",
        height : "250",
        menubar: false,
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
       
   });
            
    

     });


         function checkImg(){
            let file = document.getElementById("profile-pic");
            var fileName = file.value,
            idxDot = fileName.lastIndexOf(".") + 1,
            extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile =="jfif" || extFile =="ico"){
             
            }else{
               Swal.fire({
               title: "Information !",
               text: "Only jpg, jpeg, png, and jfif files are allowed!",
               icon: 'warning',
               allowOutsideClick: false,
               reverseButtons: true,
               confirmButtonText: "OK",
            }).then(function(){
               document.getElementById('labelchange').innerText ='Choose file';
                })
               file.value = "";  // Reset the input so no files are uploaded
               imgPreview.src = ""; 
            }

         }

     $(function() {
    var croppie = null;
    var el = document.getElementById('resizer');

    $.base64ImageToBlob = function(str) {
        // extract content type and base64 payload from original string
        var pos = str.indexOf(';base64,');
        var type = str.substring(5, pos);
        var b64 = str.substr(pos + 8);
      
        // decode base64
        var imageContent = atob(b64);
      
        // create an ArrayBuffer and a view (as unsigned 8-bit)
        var buffer = new ArrayBuffer(imageContent.length);
        var view = new Uint8Array(buffer);
      
        // fill the view, using the decoded base64
        for (var n = 0; n < imageContent.length; n++) {
          view[n] = imageContent.charCodeAt(n);
        }
      
        // convert ArrayBuffer to Blob
        var blob = new Blob([buffer], { type: type });
      
        return blob;
    }

    $.getImage = function(input, croppie) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {  
                croppie.bind({
                    url: e.target.result,
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#file-upload").on("change", function(event) {
      let file = document.getElementById("file-upload");
            var fileName = file.value,
            idxDot = fileName.lastIndexOf(".") + 1,
            extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile =="jfif"){
              $("#myModal").modal();
        // Initailize croppie instance and assign it to global variable
        croppie = new Croppie(el, {
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 250,
                    height: 250
                },
                enableOrientation: true
            });
        $.getImage(event.target, croppie); 
            }else{
               Swal.fire({
               title: "Information !",
               text: "Only jpg, jpeg, png, and jfif files are allowed!",
               icon: 'warning',
               allowOutsideClick: false,
               reverseButtons: true,
               confirmButtonText: "OK",
            }).then(function(){
               document.getElementById('labelchange').innerText ='Choose file';
                })
               file.value = "";  // Reset the input so no files are uploaded
               imgPreview.src = ""; 
            }
    });

    $("#upload").on("click", function() {
        croppie.result('base64').then(function(base64) {
            $("#myModal").modal("hide"); 
            $("#profile-pic").attr("src","{{asset('assets/img/image-loader.gif')}}");

            var url = "{{ url('/dashboard/profile/avatar') }}";
            var formData = new FormData();
            formData.append("profile_picture", $.base64ImageToBlob(base64));

            // This step is only needed if you are using Laravel
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == "uploaded") {
                        $("#profile-pic").attr("src", base64);
                        Swal.fire({
                        icon: 'success',
                        title: 'Avatar Change',
                        text: 'Succesfull changing avatar',
                        confirmButtonText: "OK",   
                        closeOnConfirm: false 
                      }).then(function() {
                        window.location.reload();
                      });     
                    } else {
                        $("#profile-pic").attr("src","{{asset('assets/img/avatar/avatar-1.png')}}"); 
                        console.log(data['profile_picture']);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $("#profile-pic").attr("src","{{asset('assets/img/avatar/avatar-1.png')}}"); 
                }
            });
        });
    });


    $('#myModal').on('hidden.bs.modal', function (e) {
        // This function will call immediately after model close
        // To ensure that old croppie instance is destroyed on every model close
        setTimeout(function() { croppie.destroy(); }, 100);
    })

});

$(function () {

$("#submitSM").on('submit',function(e){
  
  $('#btnSM').attr("disabled", true);
  
});
$("#formSubmit").on('submit',function(e){
  
  $('#submitBtn').attr("disabled", true);
  
});
});
         
</script>
@endpush


