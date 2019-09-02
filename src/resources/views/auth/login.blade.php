@extends('layouts.master')
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
                            name="user"
                            class="form-control" 
                            placeholder="Email / Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <!-- Password -->
                <div class="input-group mb-3">
                    <input type="password" 
                            name="password"
                            class="form-control" 
                            placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Remember me -->
                    <div class="col-8">
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
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            </form>
            <!-- Forgot pasword link -->
            <p class="mb-1">
                <a href="#">I forgot my password</a>
            </p>
        </div>
    </div>
</div>
@endsection