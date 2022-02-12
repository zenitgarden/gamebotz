@extends('layouts.dashboard')

@section('title')
Image Manager - Gamebotz
@endsection

@section('content')
<section class="section">
   <div class="section-header">
     <h1>Images Manager</h1>
     <div class="section-header-breadcrumb">
       <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
       <div class="breadcrumb-item">Images Manager</div>
     </div>
   </div>
 
   <div class="section-body">
     <h2 class="section-title">Guide !</h2>
     <p class="section-lead">
      You can add a new image here to use it on content, use folder image-content.
     </p>
     <div class="row">
       <div class="col-12">
         <div class="card ">
            <div class="card-body">
               <iframe src="{{route('unisharp.lfm.show')}}?type=image" style="width: 100%; height: 600px; overflow: hidden; border: none;"></iframe>
            </div>
         </div>
       </div>
     </div>
   </div>
 </section>

@endsection