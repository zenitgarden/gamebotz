@extends('layouts.dashboard')

@section('title')
Add Role - Gamebotz
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Add Role</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{route('roles.index')}}">Role</a></div>
      <div class="breadcrumb-item">Add Role</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Guide !</h2>
    <p class="section-lead">
        You can manage all role, such as creating new role ,editing, deleting and more.
    </p>
    <div class="row">
      <div class="col-12">
        <div class="card ">
          <div class="card-header">
            <a href="{{route('roles.index')}}" class="btn btn-primary rounded-sm" role="button">
              <i class="fas fa-arrow-left"></i> Back 
            </a><h4></h4>
          </div>
          <div class="card-body">
            <form action="{{route('roles.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="input_role_name" class="font-weight-bold">
                 Role
                </label>
                <input id="input_role_name" value="{{old('name')}}" name="name" type="text" class="form-control
                @error('name') is-invalid @enderror"  placeholder="Enter role name"/>
                @error('name')
                <span class="invalid-feedback">
                  <strong>
                     {{$message}}
                  </strong>
                </span>
                @enderror
             </div>
             <div class="form-group">
                <label for="input_role_permission" class="font-weight-bold">
                    Choose permissions
                </label>
                <div class="form-control overflow-auto h-100 border-0  @error('permissions') is-invalid @enderror" id="input_role_permission">
                   <div class="row">
                      <!-- list manage name:start -->
                      @foreach ($authorities as $manageName => $permission)
                      <ul class="list-group mx-1 my-1" style="width: 220px;">
                         <li class="list-group-item active">
                            {{trans("permissions.{$manageName}")}}
                         </li>
                         <!-- list permission:start -->
                         
                         @foreach ($permission as $p )
                         <li class="list-group-item">
                             <div class="form-check" >
                                @if (old('permissions'))
                                <input id="{{$p}}" name="permissions[]" class="form-check-input" type="checkbox" value="{{$p}}" 
                                {{in_array($p,old('permissions')) ? "checked" : null }}>

                                @else
                               <input id="{{$p}}" name="permissions[]" class="form-check-input" type="checkbox" value="{{$p}}">
                                @endif
                                <label for="{{$p}}" class="form-check-label">
                                  {{trans("permissions.{$p}")}}
                                </label>
                             </div>
                          </li>
                          <!-- list permission:end -->
                         @endforeach
                         
                      </ul>
                      @endforeach
                      <!-- list manage name:end  -->
                   </div>
                </div>
                @error('permissions')
                <span class="invalid-feedback">
                  <strong>
                     {{$message}}
                  </strong>
                </span>
                @enderror
             </div>
             <div class="float-left mb-4">
                <button type="submit" class="btn btn-primary px-4">
                 Save
                </button>
             </div>
            </form>
         </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

