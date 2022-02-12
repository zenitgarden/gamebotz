@extends('layouts.dashboard')

@section('title')
{{$role->name}} - Gamebotz
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Role</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard.index')}}">Dashboard</a></div>
      <div class="breadcrumb-item">Role</div>
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
            <div class="form-group">
                <label for="input_role_name" class="font-weight-bold">
                 Role
                </label>
                <input id="input_role_name" value="{{old('name', $role->name)}}" name="name" type="text" class="form-control
                @error('name') is-invalid @enderror"  placeholder="Enter role name" readonly/>
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
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                value="" onclick="return false;" {{in_array($p,$rolePermission) ? "checked" : null}}>
                                <label class="form-check-label">
                                    {{ trans("permissions.{$p}") }}
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
             </div>
         </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

