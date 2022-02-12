@extends('layouts.dashboard')

@section('title')
Edit : {{$post->title}} - Gamebotz
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Post</h1>
      <div class="section-header-button">
         <a href="{{route('posts.index')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
       </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Posts</a></div>
            <div class="breadcrumb-item">Edit Post</div>
            <div class="breadcrumb-item">{{$post->title}}</div>
        </div>
    </div>
    
    <div class="section-body">
        <div class="card">                 
            <div class="card-body">
            <form action="{{route('posts.update',['post'=> $post])}}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
            <div class="col-md-8">
               {{-- Title --}}
               @hasrole('Admin')
               <div class="form-group">
                  <div class="col-md-12">
                     <h5>Author : {{$post->authors->name}} @if ($post->authors->username != null) / <label class="text-muted">{{$post->authors->username}}</label>  @endif</h2>
                  </div>
               </div>
               @endhasrole
                <div class="form-group">
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
               {{-- Slug --}}
                <div class="form-group">
                        <label class="col-form-label text-md-left col-12 col-md-12 col-lg-3 font-weight-bold">Slug <i class="fas fa-link"></i></label>
                        <div class="col-md-12 col-md-12">
                            <input type="text" class="form-control @error('slug') is-invalid
                            @enderror" name="slug" id="slug" value="{{old('slug',$post->slug)}}" readonly="" placeholder="Auto generate">
                            @error('slug')
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
            </div>
            {{-- Category --}}
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-12 font-weight-bold">Category</label>
                <div class="col-sm-12">
                    <div class="form-control overflow-auto @error('category') is-invalid @enderror" style="height: 400px">
                        <!-- List category -->
                        @include('posts._category-list',[
                           'categories'=> $categories,
                           'categoryChecked'=> old('category',$post->categories->pluck('id')->toArray() )
                        ])
                        <!-- List category -->
                     </div>
                     @error('category')
                     <div class="invalid-feedback">
                        {{$message}}
                     </div>
                     @enderror
                </div>
              </div>
               {{-- Tag --}}
                <div class="form-group">
               <div class="col-sm-12">
                <label id="tag-label" class="font-weight-bold">Tags</label>
                <div class="float-right">
                  <label class="text-small">
                    *Available to search
                  </label>
                </div>
               </div>
                <div class="col-md-12">
                  <select id="select_post_tag" name="tag[]" class="form-control @error('tag') is-invalid        
                  @enderror selectric" data-placeholder="Choose tag" multiple>                          
                     @if (old('tag',$post->tags))
                        @foreach (old('tag',$post->tags) as $tag )
                           <option value="{{$tag->id}}" selected>{{$tag->title}}</option>
                        @endforeach  
                     @endif                      
                  </select>
                  @error('tag')
                     <div class="invalid-feedback">
                        {{$message}}
                     </div>
                  @enderror
                </div>
              </div>
            {{-- Status --}}
              <div class="form-group">
                <div class="section-title col-md-12">Status Post</div>
                  <div class="custom-control custom-radio">
                    <div class="col-sm-12">
                    <input type="radio" id="customRadio1" name="status" class="custom-control-input 
                    @error('status') is-invalid @enderror" @if (old('status', $post->status) == $status[1]) checked @endif value="{{$status[1]}}">
                    <label class="custom-control-label" for="customRadio1">Publish</label>
                    @error('status')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                 @enderror
                  </div>
              </div>
              <div class="custom-control custom-radio">
                  <div class="col-md-12">
                    <input type="radio" id="customRadio2" name="status" class="custom-control-input 
                    @error('status') is-invalid @enderror" @if (old('status',$post->status) == $status[0]) checked @endif value="{{$status[0]}}">
                    <label class="custom-control-label" for="customRadio2">Draft</label>
                    @error('status')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
              {{-- Button save --}}
              <div class="form-group">       
                <div class="col-md-12">
                  <button class="btn btn-primary btn-block" type="submit">Edit</button>
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
<script src="{{asset('assets/modules/select2/js/select2.min.js')}}"></script>

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
      height : "480",
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
                     //select2 tag
                     $('#select_post_tag').select2({
                                 
                        language: "{{app()->getLocale()}}",
                        allowClear: true,
                        ajax: {
                           url: "{{route('tags.select')}}",
                           dataType: 'json',
                           delay: 250,
                           processResults: function(data) {
                              return {
                                 results: $.map(data, function(item) {
                                    return {
                                       text: item.title,
                                       id: item.id
                                    }
                                 })
                              };
                           }
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

         // generate slug
         const title = document.querySelector('#title');
         const slug = document.querySelector('#slug');

         title.addEventListener('change', function(){
         fetch('{{route('posts.slug')}}?title=' + title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
            if(title.value == ""){
               slug.value ='';
             }

         });
</script>
@endpush