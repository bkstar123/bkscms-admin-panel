@extends('cms.layouts.master')
@section('title', 'List of admins')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Admins 
                </h3>
                @can('massiveDelete', Bkstar123\BksCMS\AdminPanel\Admin::class)
                    {{ CrudView::removeAllBtn(route('admins.massiveDestroy')) }}
                @else
                    <button class="btn btn-danger" disabled>
                        Remove all
                    </button>
                @endcan
                <div class="card-tools">
                    {{ CrudView::searchInput(route('admins.index')) }}
                </div>
            </div><!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr style="background-color: #4681AF; color: white">
                            <th>
                                {{ CrudView::checkAllBox('danger') }}
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
                                {{ CrudView::checkBox($admin, 'danger') }}
                            </td>
                            <td>
                                <a href="{{ route('admins.show', [
                                        'admin' => $admin->{$admin->getRouteKeyName()}
                                        ]) }}">
                                    {{ $admin->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admins.show', [
                                        'admin' => $admin->{$admin->getRouteKeyName()}
                                        ]) }}">
                                    {{ $admin->username }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admins.show', [
                                        'admin' => $admin->{$admin->getRouteKeyName()}
                                        ]) }}">
                                    {{ $admin->email }}
                                </a>
                            </td>
                            <td>
                                @if($admin->status)
                                    @can('deactivate', $admin)
                                    {{ CrudView::activeStatus($admin, route('admins.disabling', [
                                        'admin' => $admin->{$admin->getRouteKeyName()}
                                        ])) }}
                                    @else
                                    <button class="btn btn-success" disabled>
                                        Active
                                    </button>
                                    @endcan
                                @else
                                    @can('activate', $admin)
                                    {{ CrudView::disabledStatus($admin, route('admins.activating', [
                                        'admin' => $admin->{$admin->getRouteKeyName()}
                                        ])) }}
                                    @else
                                    <button class="btn btn-secondary" disabled>
                                        Disabled
                                    </button>
                                    @endcan
                                @endif
                            </td>
                            <td>
                                @can('delete', $admin)
                                {{ CrudView::removeBtn($admin, route('admins.destroy', [
                                    'admin' => $admin->{$admin->getRouteKeyName()}
                                    ])) }}
                                @else
                                <button class="btn btn-danger" disabled>
                                    Remove
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        Shows {{ $admins->count() }} result(s)
        {{ $admins->links() }}
    </div>
</div>
@endsection