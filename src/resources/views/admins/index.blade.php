@extends('layouts.master')
@section('title', 'List of admins')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Admins</h3>

                <div class="card-tools">
                    <form role="form"
                          method="GET"
                          accept-charset="utf-8"
                          action="{{ route('admins.index') }}">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request()->input('search') }}" 
                                   class="form-control float-right" 
                                   placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr style="background-color: #4681AF; color: white">
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{!! $admin->getStatus() !!}</td>
                        </tr>
                        @endforeach
                  </tbody>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        {{ $admins->links() }}
    </div>
</div>
@endsection