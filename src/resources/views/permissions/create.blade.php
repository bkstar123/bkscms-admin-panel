@extends('cms.layouts.master')
@section('title', 'New Permission')

@section('content')
<div class="card">
    <div class="card-header bg-light">
        <p class="login-box-msg">
            Define a new permission
        </p>
    </div>
    <div class="card-body register-card-body">
        <form action="{{ route('permissions.store') }}" 
                method="POST">
                @csrf
            <div class="input-group mb-3">
                <input type="text" 
                        name="permission"
                        value="{{ old('permission') }}"
                        class="form-control @error('permission') is-invalid @enderror"
                        placeholder="Permission name"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-universal-access"></span>
                    </div>
                </div>
                @error('permission')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="text" 
                        name="alias"
                        value="{{ old('alias') }}"
                        class="form-control @error('alias') is-invalid @enderror"
                        placeholder="Permission alias (e.g: resource_name.action)"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-universal-access"></span>
                    </div>
                </div>
                @error('alias')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <textarea name="description" 
                          rows="5" 
                          cols="30" 
                          required 
                          class="form-control @error('description') is-invalid @enderror" 
                          placeholder="Permission description"></textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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