@extends('cms.layouts.master')
@section('title', 'New Admin')

@section('content')
<div class="card">
    <div class="card-header bg-light">
        <p class="login-box-msg">
            Create a new admin account
        </p>
    </div>
    <div class="card-body register-card-body">
        <form action="{{ route('admins.store') }}" 
                method="POST">
                @csrf
            <div class="input-group mb-3">
                <input type="text" 
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Full name"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="text" 
                        name="username"
                        value="{{ old('username') }}"
                        class="form-control @error('username') is-invalid @enderror"
                        placeholder="Username"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="email" 
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" 
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" 
                        class="form-control" 
                        name="password_confirmation"
                        placeholder="Retype password"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <button type="submit" 
                            class="btn btn-success btn-block btn-flat">
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection