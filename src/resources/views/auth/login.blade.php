@extends('cms.layouts.master')
@section('title', 'Login')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>{{ config('app.name') }}</b>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{ route('admins.login') }}" 
                   method="post">
                @csrf
                <!-- User -->
                <div class="input-group mb-3">
                    <input type="text" 
                            required
                            autofocus
                            name="user"
                            autocomplete="user"
                            value="{{ old('user') }}"
                            placeholder="Email / Username"                            
                            class="form-control @error('user') is-invalid @enderror">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('user')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- Password -->
                <div class="input-group mb-3">
                    <input type="password" 
                            required
                            name="password" 
                            placeholder="Password" 
                            autocomplete="current-password"
                            class="form-control @error('password') is-invalid @enderror">
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
                <div class="row">
                    <!-- Remember me -->
                    <div class="col-md-8">
                        <div class="icheck-primary">
                            <input type="checkbox" 
                                   id="remember"
                                   name="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- Sign in button -->
                    <div class="col-md-4">
                        <button type="submit" 
                                class="btn btn-primary btn-block btn-flat">
                            Sign In
                        </button>
                    </div>
                </div>
            </form>
            <!-- Forgot pasword link -->
            @if (Route::has('admins.password.request'))
                <p class="mb-1">
                    <a class="btn btn-link" 
                        href="{{ route('admins.password.request') }}">
                        I forgot my password
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>
@endsection