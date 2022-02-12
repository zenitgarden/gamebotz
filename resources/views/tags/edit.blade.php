@extends('layouts.dashboard')

@section('title')
Edit : {{$tag->title}} - Gamebotz
@endsection

@section('content')
    <section class="section">
      <div class="section-header">
        <h1>Edit Tag</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="{{route('categories.index')}}">Tag</a></div>
          <div class="breadcrumb-item">Edit Tag</div>
          <div class="breadcrumb-item">{{$tag->title}}</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Guide !</h2>
            <p class="section-lead">You can do it boyoooo...!</p>
                <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                      <a href="{{route('tags.index')}}" class="btn btn-primary rounded-sm" role="button">
                        <i class="fas fa-arrow-left"></i> Go back
                      </a>
                    </div>
                  <form action="{{route('tags.update',['tag'=>$tag])}}" method="POST">
                    @method('PUT')
                    @csrf         
                    <div class="card-body">
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tag</label>
                        {{-- TAG TITLE --}}
                        <div class="col-sm-12 col-md-7">
                            <input type="text" id="input_title" name="title" value="{{old('title',$tag->title)}}" 
                            class="form-control @error('title') is-invalid @enderror" placeholder="Enter tag" >
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Slug <i class="fas fa-link"></i></label>
                        {{-- TAG SLUG --}}
                        <div class="col-sm-12 col-md-7">
                            <input type="text" id="input_slug" name="slug" value="{{old('slug', $tag->slug)}}"
                             class="form-control @error('slug') is-invalid @enderror" placeholder="Auto generate" readonly>
                            @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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


@push('javascript-internal')
   <script>
    $(document).ready(function(){
    const generateSlug = (value) => {
    return value.trim()
      .toLowerCase()
      .replace(/[^a-z\d-]/gi, '-')
      .replace(/-+/g, '-').replace(/^-|-$/g, "")
    }
    // Event : slug
    $("#input_title").change(function (event) {
        $('#input_slug').val(generateSlug(event.target.value))
    })

    });
</script>
@endpush