@extends('layouts.master')
@section('title', "$admin->name's profile")

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         id="profile-user-image"
                         src="{{ $admin->getAvatar()['avatar_url'] }}"
                         alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">
                    {{ $admin->name }}
                </h3>
                <p class="text-muted text-center">
                    {{ $admin->username }}
                </p>   
                @if($admin->status)
                    {{ CrudView::activeStatus($admin, route('admins.disabling', [
                        'admin' => $admin->{$admin->getRouteKeyName()}
                    ])) }}
                @else
                    {{ CrudView::disabledStatus($admin, route('admins.activating', [
                        'admin' => $admin->{$admin->getRouteKeyName()}
                    ])) }}
                @endif

                {{ CrudView::removeBtn($admin, route('admins.destroy', [
                    'admin' => $admin->{$admin->getRouteKeyName()}
                ])) }}
            </div><!-- /.card-body -->
        </div><!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title">
                    Profile
                </h3>
            </div>
            <div class="card-body">
                <strong><i class="fa fa-phone"></i> Mobile</strong>
                <p class="text-muted">
                    {{ $admin->profile->mobile ?? 'Not updated yet' }}
                </p>
                <hr>
                <strong><i class="fa fa-link"></i> Slack Webhook URL</strong>
                <p class="text-muted">
                    {{ $admin->profile->slack_webhook_url ?? 'Not updated yet' }}
                </p>
                <hr>
                <strong><i class="fa fa-envelope"></i> Email</strong>
                <p class="text-muted">
                    {{ $admin->email }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" 
                           href="#update-profile" 
                           data-toggle="tab">
                            Update Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#change-password" 
                           data-toggle="tab">
                            Change Password 
                            @error('password')
                                <span class="right badge badge-danger">
                                    Error
                                </span>
                            @enderror
                        </a>
                    </li>
                    @if(auth()->guard('admins')->user()->id === $admin->id)
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#update-avatar" 
                           data-toggle="tab">
                            Change Avatar
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#role-assignment" 
                           data-toggle="tab">
                            Authorization Roles 
                        </a>
                    </li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="update-profile">
                        <form action="{{ route('admins.profile.update', [
                            'admin' => $admin->{$admin->getRouteKeyName()}
                            ]) }}" 
                              method="POST"
                              class="form-horizontal">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" 
                                           class="form-control" 
                                           id="mobile" 
                                           name="mobile"
                                           value="{{ $admin->profile->mobile ?? '' }}"
                                           placeholder="Mobile phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" 
                                           class="form-control" 
                                           id="slack_webhook_url" 
                                           name="slack_webhook_url"
                                           value="{{ $admin->profile->slack_webhook_url ?? '' }}"
                                           placeholder="Slack URL">
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
                    <div class="tab-pane" id="change-password">
                        <form action="{{ route('admins.password.change', [
                                'admin' => $admin->{$admin->getRouteKeyName()}
                            ]) }}" 
                              method="POST"
                              class="form-horizontal">
                               @csrf
                               @method('PATCH')
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" 
                                           name="password"
                                           placeholder="New Password"
                                           required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           placeholder="Re-type Password"
                                           required>
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
                    @if(auth()->guard('admins')->user()->id === $admin->id)
                    <div class="tab-pane" id="update-avatar">
                        <input type="file" 
                               class="form-control" 
                               name="avatar" 
                               id="avatar">
                    </div>
                    @endif
                    <div class="tab-pane" id="role-assignment">
                        <form id="multiselect-form" 
                              method="POST" 
                              action="{{ route('admins.roles.assign', [
                                'admin' => $admin->{$admin->getRouteKeyName()}
                                ]) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="multiselect">
                                        Available Roles
                                    </label>
                                    <select name="from[]" 
                                            id="multiselect" 
                                            class="form-control" 
                                            size="8" 
                                            multiple="multiple">
                                        @foreach($admin->getRoles()['available'] as $roleId => $roleName)
                                            <option value="{{ $roleId }}">
                                                {{ $roleName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" 
                                            id="multiselect_rightAll" 
                                            class="btn btn-sm btn-primary btn-block">
                                        <i class="fa fa-forward" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" 
                                            id="multiselect_rightSelected" 
                                            class="btn btn-sm btn-primary btn-block">
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" 
                                            id="multiselect_leftSelected" 
                                            class="btn btn-sm btn-primary btn-block">
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" 
                                            id="multiselect_leftAll" 
                                            class="btn btn-sm btn-primary btn-block">
                                        <i class="fa fa-backward" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" 
                                            class="btn btn-sm btn-block btn-success"
                                            onclick="event.preventDefault();
                                            $('#multiselect-form').submit();">
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="col-md-5">
                                    <label for="multiselect_to">
                                        Assigned Roles
                                    </label>
                                    <select name="to[]" 
                                            id="multiselect_to" 
                                            class="form-control" 
                                            size="8" 
                                            multiple="multiple">
                                        @foreach($admin->getRoles()['assigned'] as $roleId => $roleName)
                                            <option value="{{ $roleId }}">
                                                {{ $roleName }}
                                            </option>
                                        @endforeach
                                    </select>
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

@push('scriptBottom')
<script type="text/javascript">
$(document).ready(function () {
    $('#multiselect').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
        }
    });
    
    @if(auth()->guard('admins')->user()->id === $admin->id)
        $('#avatar').bkstar123_ajaxuploader({
        size: {{ config('bkstar123_bkscms_adminpanel.avatarMaxSize') }},
        allowedExtensions: {!! json_encode(config('bkstar123_bkscms_adminpanel.avatarAllowedExtensions')) !!},
        batchSize: 1,
        outerClass: 'col-md-12',
        uploadUrl: '{{ route('admins.avatar.upload') }}',
        onResponse: (response) => {
            let res = JSON.parse(response)
            if (res.data) {
                $('#sidebar-user-image').attr('src', res.data.url);
                $('#profile-user-image').attr('src', res.data.url);
            }
        }
    });
    @endif
});
</script>
@endpush