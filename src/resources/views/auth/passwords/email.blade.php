@extends('cms.layouts.master')
@section('title', 'Reset password')

@section('content')
<div class="container" style="margin-top: 7%">
    <div class="login-logo">
        <b>{{ config('app.name') }}</b>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Reset Password
                    <a class="float-right"
                        href="{{ route('admins.login') }}">
                        Login
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" 
                           action="{{ route('admins.password.email') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" 
                                   class="col-md-4 col-form-label text-md-right">
                                E-Mail Address
                            </label>
                            <div class="col-md-6">
                                <input id="email" 
                                       type="email" 
                                       name="email" 
                                       required 
                                       autofocus
                                       autocomplete="email" 
                                       value="{{ old('email') }}" 
                                       class="form-control @error('email') is-invalid @enderror" >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div><br>
                        {{ Recaptcha::addClient() }}
                        @error('g-recaptcha-response')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror           
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection