@extends('cms.layouts.master')
@section('title', "Role: $role->role")

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <span class="fa fa-user-circle"></span>
                </div>
                <h3 class="profile-username text-center">
                    {{ $role->role }}
                </h3>
                <p class="text-muted text-center">
                    {{ $role->description }}
                </p>   
                @if($role->status)
                    {{ CrudView::activeStatus($role, route('roles.disabling', [
                        'role' => $role->{$role->getRouteKeyName()}
                    ])) }}
                @else
                    {{ CrudView::disabledStatus($role, route('roles.activating', [
                        'role' => $role->{$role->getRouteKeyName()}
                    ])) }}
                @endif
                {{ CrudView::removeBtn($role, route('roles.destroy', [
                    'role' => $role->{$role->getRouteKeyName()}
                ])) }}
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" 
                           href="#update-role-metadata" 
                           data-toggle="tab">
                            Update Role's Metadata
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#update-role-permissions" 
                           data-toggle="tab">
                            Update Role's Permissions 
                        </a>
                    </li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="update-role-metadata">
                        <form action="{{ route('roles.update', [
                            'role' => $role->{$role->getRouteKeyName()}
                            ]) }}" 
                              method="POST"
                              class="form-horizontal">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" 
                                           id="role" 
                                           name="role"
                                           value="{{ old('role') ?? $role->role }}"
                                           class="form-control @error('role') is-invalid @enderror" 
                                           placeholder="New Role Name">
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea name="description" 
                                              rows="5" 
                                              cols="30" 
                                              required 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              placeholder="Role description">{{ old('description') ?? $role->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                      
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" 
                                            class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="update-role-permissions">
                        <!-- TODO -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection