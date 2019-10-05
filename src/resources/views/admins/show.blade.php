@extends('layouts.master')
@section('title', "$admin->name's profile")

@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="/dist/img/user2-160x160.jpg"
                         alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $admin->name }}</h3>
                <p class="text-muted text-center">{{ $admin->username }}</p>   
                @if($admin->status)
                    {{ CrudView::activeStatus($admin, route('admins.disabling', [
                        'admin' => $admin->{$admin->getRouteKeyName()}
                    ])) }}
                @else
                    {{ CrudView::disabledStatus($admin, route('admins.activating', [
                        'admin' => $admin->{$admin->getRouteKeyName()}
                    ])) }}
                @endif
            </div><!-- /.card-body -->
        </div><!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-blue">
            <div class="card-header">
                <h3 class="card-title">About Me</h3>
            </div>
            <div class="card-body">
                <strong><i class="fa fa-phone"></i> Mobile</strong>
                <p class="text-muted">
                    {{ $admin->profile->mobile ?? '' }}
                </p>
                <hr>
                <strong><i class="fa fa-link"></i> Slack Webhook URL</strong>
                <p class="text-muted">
                    {{ $admin->profile->slack_webhook_url ?? '' }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#settings" data-toggle="tab">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#change-password" data-toggle="tab">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#update-avatar" data-toggle="tab">Change Avatar</a>
                    </li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">
                        <form action="#" 
                              method="POST"
                              class="form-horizontal">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" 
                                           class="form-control" 
                                           id="mobile" 
                                           name="mobile"
                                           value="{{ old('mobile') }}"
                                           placeholder="Mobile phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" 
                                           class="form-control" 
                                           id="slack_webhook_url" 
                                           name="slack_webhook_url"
                                           value="{{ old('slack_webhook_url') }}"
                                           placeholder="Slack URL">
                                </div>
                            </div>
                      
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" 
                                            class="btn btn-danger">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="change-password">
                        <form action="#" 
                              method="POST"
                              class="form-horizontal">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password"
                                           placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirm" 
                                           name="password_confirm"
                                           placeholder="Re-type Password">
                                </div>
                            </div>
                      
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" 
                                            class="btn btn-danger">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="update-avatar">
                        <input type="file" 
                               class="form-control" 
                               name="avatar" 
                               id="avatar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection