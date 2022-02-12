@extends('layouts.dashboard')

@section('title')
Site Setting - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Site Setting</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Site Setting</div>
      </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">All About Site Settings</h2>
        <p class="section-lead">
          You can adjust all site settings here
        </p>

        <div id="output-status"></div>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h4>Jump To</h4>
              </div>
              <div class="card-body">
                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="general-tab4" data-toggle="tab" href="#general4" role="tab" aria-controls="general" aria-selected="true">General Setting</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link  @if ($errors->has('facebook')) autofocus @endif" id="social-tab4" data-toggle="tab" href="#social4" role="tab" aria-controls="scoial" aria-selected="false">Social Media</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="about-tab4" data-toggle="tab" href="#about4" role="tab" aria-controls="about" aria-selected="false">About Us</a>
                      </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="tab-content no-padding">
             <div class="tab-pane fade show active" id="general4" role="tabpanel" aria-labelledby="general-tab4">
              <div class="card" id="settings-card">
                <form action="{{route('settings.general')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-header">
                  <h4>General Settings</h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">General settings such as, site logo, site favicon, and disqus plugin</p>
                            <div id="logo1" class="@if (!$siteSetting->logo) d-none @endif form-group row align-items-center">
                                <label  class="form-control-label col-sm-3 text-md-right">Site Logo</label>
                                <div class="col-sm-6 col-md-9">
                                    <img id="logoPreview" class="img-preview img-fluid" src="{{asset('/assets/img/'.$siteSetting->logo)}}">
                                </div>
                              </div>
                         

                            <div class="form-group row align-items-center">
                              <label id="labLogo" class="form-control-label col-sm-3 text-md-right">@if (!$siteSetting->logo) Site Logo  @endif</label>
                              <div class="col-sm-6 col-md-9">
                                <div class="custom-file">
                                  <input type="file" name="site_logo" class="custom-file-input @error('site_logo') is-invalid @endif" id="site-logo" onChange="previewLogo()" accept="image/*">
                                  <label class="custom-file-label" id="labelchange2">Change logo</label>
                                    @error('site_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-text text-muted">The logo must have a maximum size of 1MB</div>
                              </div>
                            </div>

                          
                            <div id="icon1" class="@if (!$siteSetting->favicon) d-none @endif form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">Favicon</label>
                                <div class="col-sm-6 col-md-9">
                                    <img id ="faviconPreview" class="img-preview img-fluid" src="{{asset('/assets/img/'.$siteSetting->favicon)}}">
                                </div>
                              </div>
                         
                           
                            <div class="form-group row align-items-center">
                              <label id="labIcon" class="form-control-label col-sm-3 text-md-right">@if (!$siteSetting->favicon) Favicon  @endif </label>
                              <div class="col-sm-6 col-md-9">
                                <div class="custom-file">
                                  <input type="file" name="site_favicon" class="custom-file-input @error('site_favicon') is-invalid @endif" id="site-favicon" onChange="previewFavicon()" accept="image/*">
                                  <label class="custom-file-label"  id="labelchange1">Change favicon</label>
                                  @error('site_favicon')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                                <div class="form-text text-muted">The favicon must have a maximum size of 1MB</div>
                              </div>                             
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="meta_keyword" class="form-control-label col-sm-3 text-md-right">Disques Plugin</label>
                                <div class="col-sm-6 col-md-9">
                                  <input type="text" name="disqus_plugin" 
                                  value="{{old('disqus_plugin',$siteSetting->disqus_plugin)}}" 
                                  class="form-control @error('disqus_plugin') is-invalid @endif" id="meta_keyword" placeholder="">
                                  @error('disqus_plugin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                              </div>
                </div>
                    @can('site_settings_update')
                    <div class="card-footer bg-whitesmoke text-md-right">
                        <button class="btn btn-primary" type="submit" id="save-btn">Save Changes</button>
                    </div>
                    @endcan
                </form>
              </div>
             </div>
             {{-- BREAK --}}
             <div class="tab-pane fade" id="social4" role="tabpanel" aria-labelledby="social-tab4">
                <div class="card" id="settings-card">
                <form action="{{route('settings.sm')}}" method="POST">
                    @csrf
                    @method('PUT')
                  <div class="card-header">
                    <h4>Social Media</h4>
                  </div>
                  <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Facebook</label>
                            <div class="col-sm-6 col-md-9">
                            <input type="text" name="facebook" value="{{old('youtube',$siteSetting->facebook_link)}}" class="form-control @error('facebook') is-invalid @enderror" id="facebook" placeholder="https://www.facebook.com ??">
                            @error('facebook')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Twitter</label>
                            <div class="col-sm-6 col-md-9">
                            <input type="text" name="twitter" value="{{old('twitter',$siteSetting->twitter_link)}}" class="form-control @error('twitter') is-invalid @enderror" id="twitter" placeholder="https://www.twitter.com ??">
                            @error('twitter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Instagram</label>
                            <div class="col-sm-6 col-md-9">
                            <input type="text" name="instagram" value="{{old('instagram',$siteSetting->instagram_link)}}" class="form-control @error('instagram') is-invalid @enderror" id="instagram" placeholder="https://www.instagram.com ??">
                            @error('instagram')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">YouTube</label>
                            <div class="col-sm-6 col-md-9">
                            <input type="text" name="youtube" value="{{old('youtube',$siteSetting->youtube_link)}}" class="form-control @error('youtube') is-invalid @enderror" id="youtube" placeholder="https://www.youtube.com ??">
                            @error('youtube')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                        </div>
                        @can('site_settings_update')
                        <div class="form-group text-md-right">
                          <button class="btn btn-primary" type="submit">Save Changes</button>
                        </div>
                        @endcan
                  </div>
                  <div class="card-footer bg-whitesmoke text-md-right">
                    Share the social media links. Make sure the link include : (https://example.com) Okay <i class="fas fa-thumbs-up"></i> 
                  </div>
                </form>
                </div>
             </div>
               {{-- BREAK --}}
               <div class="tab-pane fade" id="about4" role="tabpanel" aria-labelledby="about-tab4">
                <div class="card" id="settings-card">
                <form action="{{route('settings.about')}}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="card-header">
                    <h4>About Us</h4>
                  </div>
                  <div class="card-body">
                        <div class="form-group row align-items-center">
                            <div class="form-group col-12">
                                <label>About Us</label> <small  class="text-muted"> *Change about us on the user page</small >
                                <textarea id="about" name="about" class="form-control" placeholder="Who are we ? !">{{old('disqus_plugin',$siteSetting->about)}}</textarea>
                            </div>
                        </div> 
                  </div>             
                  @can('site_settings_update')  
                  <div class="card-footer bg-whitesmoke text-md-right">
                      <button class="btn btn-primary" type="submit" id="save-btn">Save Changes</button>
                  </div>
                  @endcan
                </form>
                </div>
             </div>
             {{-- BREAK --}}
            </div>
          </div>
        </div>
    </div>
  </section>
@endsection

@push('javascript-external')
{{-- TinyMCE5 --}}
<script src="{{asset('vendor/tinymce5/jquery.tinymce.min.js')}}"></script>
<script src="{{asset('vendor/tinymce5/tinymce.min.js')}}"></script>

@endpush

@push('javascript-external')
<script>
$(document).ready(function(){

     // Event:generate file name favicon
     $("#site-favicon").change(function (event) {
         
         var from = $(this).val();
         from = from.substring(from.lastIndexOf("\\") + 1, from.length)
         $("#labelchange1").text(from);
      });

      // Event:generate file name logo
     $("#site-logo").change(function (event) {
         
         var from = $(this).val();
         from = from.substring(from.lastIndexOf("\\") + 1, from.length)
         $("#labelchange2").text(from);
      });


    // TinyMCE5
    $("#about").tinymce({
    relative_urls: false,
    language: "en",
    height : "480",
    plugins: [
    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code ",
    "insertdatetime media nonbreaking save table directionality",
    "emoticons template paste textpattern",
    ],
    toolbar1: "code preview",
    toolbar2: "insertfile undo redo | styleselect | bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent | link image media ",
    file_picker_callback: function(callback, value, meta) {
    let x = window.innerWidth || document.documentElement.clientWidth || document
        .getElementsByTagName('body')[0].clientWidth;
    let y = window.innerHeight || document.documentElement.clientHeight || document
        .getElementsByTagName('body')[0].clientHeight;

    let cmsURL = "{{route('unisharp.lfm.show')}}" + '?editor=' + meta.fieldname;
    if (meta.filetype == 'image') {
        cmsURL = cmsURL + "&type=Images";
    } else {
        cmsURL = cmsURL + "&type=Files";
    }

    tinyMCE.activeEditor.windowManager.openUrl({
        url: cmsURL,
        title: 'Filemanager',
        width: x * 0.8,
        height: y * 0.8,
        resizable: "yes",
        close_previous: "no",
        onMessage: (api, message) => {
            callback(message.content);
        }
    });
    }

    });

});

        // favicon
   
        
         function previewFavicon(){
            let file = document.getElementById("site-favicon");
            const image = document.querySelector('#site-favicon');
            const imgPreview = document.querySelector('#faviconPreview');

            var fileName = file.value,
            idxDot = fileName.lastIndexOf(".") + 1,
            extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile =="jfif" || extFile =="ico"){

               imgPreview.style.display = 'block';

               const oFReader = new FileReader();
               oFReader.readAsDataURL(image.files[0]);

               oFReader.onload = function(oFREvent){
               imgPreview.src = oFREvent.target.result;
               }
              
                $("#icon1").removeClass('d-none');
           
                document.getElementById('labIcon').innerText =' ';
  
            }else{
               Swal.fire({
               title: "Information !",
               text: "Only jpg, jpeg, png, ico, and jfif files are allowed!",
               icon: 'warning',
               allowOutsideClick: false,
               reverseButtons: true,
               confirmButtonText: "OK",
            }).then(function(){
                location.reload();
              //  document.getElementById('labelchange1').innerText ='Choose file';
                })
              //  file.value = "";  // Reset the input so no files are uploaded
              //  imgPreview.src = "{{asset('/assets/img/'.$siteSetting->favicon)}}"; 
              
              //   $("#icon1").addClass('d-none');
           
              //   document.getElementById('labIcon').innerText ='Favicon';
            }

         }

        // logo
   
        function previewLogo(){
        let file = document.getElementById("site-logo");
        const image = document.querySelector('#site-logo');
        const imgPreview = document.querySelector('#logoPreview');

        var fileName = file.value,
        idxDot = fileName.lastIndexOf(".") + 1,
        extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile =="jfif"){
        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
        imgPreview.src = oFREvent.target.result;
        }
        $("#logo1").removeClass('d-none');
           
        document.getElementById('labLogo').innerText =' ';

        }else{
        Swal.fire({
        title: "Information !",
        text: "Only jpg, jpeg, png, and jfif files are allowed!",
        icon: 'warning',
        allowOutsideClick: false,
        reverseButtons: true,
        confirmButtonText: "OK",
        }).then(function(){
          location.reload();
        // document.getElementById('labelchange2').innerText ='Choose file';
            })
        // file.value = "";  // Reset the input so no files are uploaded
        // imgPreview.src = "{{asset('/assets/img/'.$siteSetting->logo)}}"; 

        // $("#logo1").addClass('d-none');
           
        //    document.getElementById('labLogo').innerText ='Favicon';
        }

        }

</script>
@endpush




