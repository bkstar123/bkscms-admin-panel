@extends('cms.layouts.master')
@section('title', 'Create new authorization role')

@section('content')
<div class="card">
    <div class="card-header bg-light">
        <p class="login-box-msg">
            Create a new role
        </p>
    </div>
    <div class="card-body register-card-body">
        <form action="{{ route('roles.store') }}" 
                method="POST">
                @csrf
            <div class="input-group mb-3">
                <input type="text" 
                        name="role"
                        value="{{ old('role') }}"
                        class="form-control @error('role') is-invalid @enderror"
                        placeholder="Role name"
                        required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-user-circle"></span>
                    </div>
                </div>
                @error('role')
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
                          placeholder="Role description"></textarea>
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