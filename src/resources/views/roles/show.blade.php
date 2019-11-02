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
                    @can('deactivate', $role)
                        {{ CrudView::activeStatus($role, route('roles.disabling', [
                            'role' => $role->{$role->getRouteKeyName()}
                        ])) }}
                    @else
                        <button class="btn btn-success" disabled>Active</button>
                    @endcan
                @else
                    @can('activate', $role)
                        {{ CrudView::disabledStatus($role, route('roles.activating', [
                            'role' => $role->{$role->getRouteKeyName()}
                        ])) }}
                    @else
                        <button class="btn btn-secondary" disabled>Disabled</button>
                    @endcan
                @endif
                @can('delete', $role)
                    {{ CrudView::removeBtn($role, route('roles.destroy', [
                        'role' => $role->{$role->getRouteKeyName()}
                    ])) }}
                @else
                    <button class="btn btn-danger" disabled>Remove</button>
                @endcan
                @if(count($role->admins) > 0)
                    <button class="btn btn-primary"
                            @cannot('revoke', $role) disabled @endcannot
                            onclick="event.preventDefault(); 
                            $('#revoke-form-{{ $role->{$role->getRouteKeyName()} }}').submit();">
                        Revoke
                    </buttob>
                    <form id="revoke-form-{{ $role->{$role->getRouteKeyName()} }}" 
                          action="{{ route('roles.revoke',['role' => $role->{$role->getRouteKeyName()}]) }}" 
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
                           href="#update-role-metadata" 
                           data-toggle="tab">
                            Update Role's Metadata
                        </a>
                    </li>
                    @if(!$role->isReserved())
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#update-role-permissions" 
                           data-toggle="tab">
                            Update Role's Permissions 
                        </a>
                    </li>
                    @endif
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
                                            @cannot('update', $role) disabled @endcannot
                                            class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(!$role->isReserved())
                    <div class="tab-pane" id="update-role-permissions">
                        @component('bkstar123_bkscms_adminpanel::components.multiselect', [
                            'route' => route('roles.permissions.assign', [
                                'role' => $role->{$role->getRouteKeyName()}
                            ]),
                            'leftItems' => $role->getPermissions()['available'],
                            'rightItems' => $role->getPermissions()['assigned']
                        ])
                            @slot('left_label')
                                Available Permissions
                            @endslot

                            @slot('right_label')
                                Assigned Permission
                            @endslot
                        @endcomponent
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scriptBottom')
<script type="text/javascript">
$(document).ready(function () {
    $('#multiselect').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
        }
    });
});
</script>
@endpush