@extends('layouts.dashboard')

@section('title')
Add Category - Gamebotz
@endsection

@section('content')
    <section class="section">
      <div class="section-header">
        <h1>Add Category</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="{{route('categories.index')}}">Category</a></div>
          <div class="breadcrumb-item">Add Category</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Guide !</h2>
            <p class="section-lead">Parent category is optional , You can make sub-category by choosing Parent category.</p>
                <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                      <a href="{{route('categories.index')}}" class="btn btn-primary rounded-sm" role="button">
                        <i class="fas fa-arrow-left"></i> Go back
                      </a>
                    </div>
                  <form action="{{route('categories.store')}}" method="POST">
                    @csrf         
                    <div class="card-body">
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                        {{-- CATEGORY TITLE --}}
                        <div class="col-sm-12 col-md-7">
                            <input type="text" id="input_title" name="title" value="{{old('title')}}" 
                            class="form-control @error('title') is-invalid @enderror" placeholder="Enter category" autofocus>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group row mb-4">
                          {{-- CATEGORY SLUG --}}
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Slug <i class="fas fa-link"></i></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" id="input_slug" name="slug" value="{{old('slug')}}"
                             class="form-control @error('slug') is-invalid @enderror" placeholder="Auto generate" readonly>
                            @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group row mb-4">
                          {{-- PARENT CATEGORY --}}
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Parent Category</label>  
                        <div class="col-sm-12 col-md-7">         
                            <select id="select-2" name="parent_category" style="clear:both;" class="form-control select2" data-placeholder="Choose parent category">
                              
                            </select>
                            
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
</style>
@endpush

@push('javascript-external')
<script src="{{asset('assets/modules/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/modules/select2/js/i18n/en.js')}}"></script>
@endpush

@push('javascript-internal')
   <script>
      $(function() {

        // auto generate slug
        function generateSlug(value){
            return value.trim()
               .toLowerCase()
               .replace(/[^a-z\d-]/gi, '-')
               .replace(/-+/g, '-').replace(/^-|-$/g, "");
            } 


        //select parent_category
        $('#select-2').select2({
            
            language: "{{ app()->getLocale() }}",
            allowClear: true,
            ajax: {
               url: "{{route('categories.select')}}",
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

         // event:input title
         $('#input_title').change(function() {
            let title = $(this).val();
            $('#input_slug').val(generateSlug(title));
            });
      
         
      });
   </script>
@endpush