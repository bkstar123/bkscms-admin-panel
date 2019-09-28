@extends('layouts.master')
@section('title', 'List of admins')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Admins 
                </h3>
                <button class="btn btn-danger"
                    onclick="event.preventDefault();
                        $('#massive-removing-modal').modal('show')">
                    Remove all
                </button>
                <form id="massive-destroy-form"
                    method="POST"
                    style="display: none;"
                    action="{{ route('admins.massiveDestroy') }}">
                    <input id="massive-destroy-list" type="hidden" name="Ids" value="">
                    @csrf
                    @method('DELETE')      
                </form>
                <div class="modal fade" 
                    id="massive-removing-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title">
                                    Confirmation - multiple destroy
                                </h4>
                                <button type="button" 
                                    class="close" 
                                    data-dismiss="modal" 
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure to perform this action?</p>
                                <i>All related data will irreversibly be removed</i>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" 
                                    class="btn btn-secondary" 
                                    data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" 
                                    class="btn btn-outline-light btn-danger"
                                    onclick="event.preventDefault();
                                    let checkedItems = $('.item-check:checked');
                                    let Ids = [];
                                    $.each(checkedItems, function () {
                                        Ids.push($(this).val());
                                    });

                                    if (Ids.length === 0) {
                                        alert('No data was selected');
                                        $('#massive-removing-modal').modal('hide');
                                        return;
                                    } else {
                                        $('#massive-destroy-list').val(Ids);
                                        $('#massive-removing-modal').modal('hide');
                                        $('#massive-destroy-form').submit();
                                    }
                                    ">
                                    Okay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <th>
                                <div class="icheck-danger">
                                    <input type="checkbox" id="check-all">
                                    <label for="check-all"></label>
                                </div>
                                <script>
                                    $("#check-all").change(() => {
                                        $("#check-all").prop('checked') ? 
                                        $('.item-check').prop('checked', true) : 
                                        $('.item-check').prop('checked', false);
                                    });
                                </script>
                            </th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>
                                <div class="icheck-danger">
                                    <input type="checkbox" 
                                        class="item-check"
                                        value = "{{ $admin->{$admin->getRouteKeyName()} }}"
                                        id="item-check-{{ $admin->{$admin->getRouteKeyName()} }}">
                                    <label for="item-check-{{ $admin->{$admin->getRouteKeyName()} }}"></label>
                                </div>
                            </td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @if($admin->status)
                                    <span class="badge bg-green">
                                        <a href="#" 
                                           class="btn btn-link"
                                           onclick="event.preventDefault();
                                           $('#disabling-form-{{ $admin->{$admin->getRouteKeyName()} }}').submit()">
                                            Active
                                        </a>
                                    </span>
                                    <form id="disabling-form-{{ $admin->{$admin->getRouteKeyName()} }}"
                                          action="{{ route('admins.disabling', [
                                                'admin' => $admin->{$admin->getRouteKeyName()}
                                            ]) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @else
                                    <span class="badge bg-gray">
                                        <a href="#" 
                                           class="btn btn-link"
                                           onclick="event.preventDefault();
                                           $('#activating-form-{{ $admin->{$admin->getRouteKeyName()} }}').submit()">
                                            Disabled
                                        </a>
                                    </span>
                                    <form id="activating-form-{{ $admin->{$admin->getRouteKeyName()} }}"
                                          action="{{ route('admins.activating', [
                                                'admin' => $admin->{$admin->getRouteKeyName()}
                                            ]) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-red">
                                    <a href="#" 
                                        class="btn btn-link"
                                        onclick="event.preventDefault();
                                        $('#removing-modal-{{ $admin->{$admin->getRouteKeyName()} }}').modal('show')">
                                        Delete
                                    </a>
                                </span>
                                <div class="modal fade" 
                                    id="removing-modal-{{ $admin->{$admin->getRouteKeyName()} }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h4 class="modal-title">
                                                    Confirmation - destroy
                                                </h4>
                                                <button type="button" 
                                                    class="close" 
                                                    data-dismiss="modal" 
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure to perform this action?</p>
                                                <i>All related data will irreversibly be removed</i>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" 
                                                    class="btn btn-secondary" 
                                                    data-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-outline-light btn-danger"
                                                        onclick="event.preventDefault();
                                                        $('#deleting-form-{{ $admin->{$admin->getRouteKeyName()} }}').submit()">
                                                    Okay
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form id="deleting-form-{{ $admin->{$admin->getRouteKeyName()} }}"
                                        action="{{ route('admins.destroy', [
                                            'admin' => $admin->{$admin->getRouteKeyName()}
                                        ]) }}"
                                        method="POST"
                                        style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
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