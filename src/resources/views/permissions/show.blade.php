@extends('cms.layouts.master')
@section('title', "Permission: $permission->alias")

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <span class="fa fa-universal-access"></span>
                </div>
                <h3 class="profile-username text-center">
                    {{ $permission->permission }}
                    <div class="text-center">
                        <h6>({{ $permission->alias }})</h6>
                    </div>
                </h3>
                <p class="text-muted text-center">
                    {{ $permission->description }}
                </p>   
                @if($permission->status)
                    @can('deactivate', $permission)
                        {{ CrudView::activeStatus($permission, route('permissions.disabling', [
                            'permission' => $permission->{$permission->getRouteKeyName()}
                        ])) }}
                    @else
                        <button class="btn btn-success" disabled>Active</button>
                    @endcan
                @else
                    @can('activate', $permission)
                        {{ CrudView::disabledStatus($permission, route('permissions.activating', [
                            'permission' => $permission->{$permission->getRouteKeyName()}
                        ])) }}
                    @else
                        <button class="btn btn-secondary" disabled>Disabled</button>
                    @endcan
                @endif
                @can('delete', $permission)
                    {{ CrudView::removeBtn($permission, route('permissions.destroy', [
                        'permission' => $permission->{$permission->getRouteKeyName()}
                    ])) }}
                @else
                    <button class="btn btn-danger" disabled>Remove</button>
                @endcan
                @if(count($permission->roles) > 0)
                    <button class="btn btn-primary"
                            @cannot('revoke', $permission) disabled @endcannot
                            onclick="event.preventDefault(); 
                            $('#revoke-form-{{ $permission->{$permission->getRouteKeyName()} }}').submit();">
                        Revoke
                    </buttob>
                    <form id="revoke-form-{{ $permission->{$permission->getRouteKeyName()} }}" 
                          action="{{ route('permissions.revoke',['permission' => $permission->{$permission->getRouteKeyName()}]) }}" 
                          method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <button class="btn btn-secondary" disabled>
                        Un-assigned
                    </button>
                @endif
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" 
                           href="#update-permission-metadata" 
                           data-toggle="tab">
                            Update Permission
                        </a>
                    </li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="update-permission-metadata">
                        <form action="{{ route('permissions.update', [
                            'permission' => $permission->{$permission->getRouteKeyName()}
                            ]) }}" 
                              method="POST"
                              class="form-horizontal">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" 
                                           id="permission" 
                                           name="permission"
                                           value="{{ old('permission') ?? $permission->permission }}"
                                           class="form-control @error('permission') is-invalid @enderror" 
                                           placeholder="New permission name">
                                    @error('permission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" 
                                           id="alias" 
                                           name="alias"
                                           value="{{ old('alias') ?? $permission->alias }}"
                                           class="form-control @error('alias') is-invalid @enderror" 
                                           placeholder="New permission alias">
                                    @error('alias')
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
                                              placeholder="Permission description">{{ old('description') ?? $permission->description }}</textarea>
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
                                            @cannot('update', $permission) disabled @endcannot
                                            class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection