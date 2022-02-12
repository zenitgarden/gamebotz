@extends('layouts.dashboard')

@section('title')
Edit Recommendation Game - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Recommendation Game</h1>
      <div class="section-header-button">
         <a href="{{route('dashboard.recom')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
       </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
            <div class="breadcrumb-item">Edit</div>
            <div class="breadcrumb-item">Recommendation Game</div>
        </div>
    </div>
    
    <div class="section-body">
        <div class="card">                 
            <div class="card-body">
            <form action="{{route('dashboard.recom.update')}}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
            <div class="col-md-12">
               {{-- Title --}}
                <div class="form-group">
            
                        <p class="col-form-label text-md-left col-12 col-md-12 col-lg-3 font-weight-bold">Last Update : {{$post->updated_at->diffForHumans()}}</p>
                        <label class="col-form-label text-md-left col-12 col-md-12 col-lg-3 font-weight-bold">Title</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control @error('title') is-invalid
                            @enderror" name="title" id="title" value="{{old('title',$post->title)}}" placeholder="Enter Title">
                            @error('title')
                              <div class="invalid-feedback">
                                    {{$message}}
                              </div>
                            @enderror
                        </div>
                    </div>
               {{-- Thumbnail --}}
                <div class="form-group">
                    <label class="col-form-label text-md-left col-12 col-md-12 col-lg-3 font-weight-bold">Thumbnail</label>
                    <div class="col-md-12 ">
                        <div class="custom-file">
                           <input type="hidden" name="oldImage" value="{{$post->thumbnail}}">
                            <input class="custom-file-input @error('thumbnail') is-invalid @enderror" type="file" id="image" name="thumbnail" onChange="previewImage()" accept="image/*">
                            <label class="custom-file-label" id="labelchange" for="customFile">Choose file</label>
                            <div class="invalid-feedback">
                              @error('thumbnail')
                                 {{$message}}  
                              @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @if ($post->thumbnail)
                <img src="{{asset($post->thumbnail)}}" class="img-preview img-fluid mx-auto d-block mb-3 col-sm-8">
                @endif
                <img class="img-preview img-fluid mx-auto d-block mb-3 col-sm-8">
                {{-- <label id="image-name" class="mx-auto d-block mb-3 col-sm-8"></label> --}}
                {{-- Content --}}
                <div class="form-group">
                        <label class="col-form-label text-md-left col-12 col-md-12 col-lg-3 font-weight-bold">Content</label>
                        <div class="col-md-12">
                            <textarea id="input_post_content" name="content" 
                            placeholder="Write your content here !" 
                            class="form-control @error('content') is-invalid @enderror"
                               rows="20">{{old('content',$post->content)}}</textarea>
                               @error('content')
                                 <div class="invalid-feedback">    
                                    {{$message}}
                                 </div>
                               @enderror
                        </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-5">
                      <button class="btn btn-primary btn-block " type="submit">Edit</button>
                    </div>
                </div>
            </div>
    </div>      
  
</form>
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
#tag-label{
   color: #34395e;
   font-size: 12px;
}
.tox.tinymce{
   border: 1px solid #e00202!important;
}



</style>
@endpush

@push('javascript-external')
{{-- TinyMCE5 --}}
<script src="{{asset('vendor/tinymce5/jquery.tinymce.min.js')}}"></script>
<script src="{{asset('vendor/tinymce5/tinymce.min.js')}}"></script>
@endpush

@push('javascript-internal')
<script>
    $(document).ready(function(){
      
      // Event:generate file name
      $("#image").change(function (event) {
         
         var from = $(this).val();
         from = from.substring(from.lastIndexOf("\\") + 1, from.length)
         $("#labelchange").text(from);
      });


      // TinyMCE5
      $("#input_post_content").tinymce({
      relative_urls: false,
      language: "en",
      height : "780",
      plugins: [
         "advlist autolink lists link image charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code ",
         "insertdatetime media nonbreaking save table directionality",
         "emoticons template paste textpattern",
      ],
      toolbar1: "code preview",
      toolbar2: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media ",
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

         let file = document.getElementById("image");
         function previewImage(){

            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

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
               imgPreview.src = "{{asset($post->thumbnail)}}"; 
            }

         }

</script>
@endpush