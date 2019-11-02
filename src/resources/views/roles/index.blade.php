@extends('cms.layouts.master')
@section('title', 'List of authorization roles')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Authorization Roles 
                </h3>
                @can('massiveDelete', Bkstar123\BksCMS\AdminPanel\Role::class)
                    {{ CrudView::removeAllBtn(route('roles.massiveDestroy')) }}
                @else
                    <button class="btn btn-danger" disabled>
                        Remove all
                    </button>
                @endcan
                <div class="card-tools">
                    {{ CrudView::searchInput(route('roles.index')) }}
                </div>
            </div><!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr style="background-color: #4681AF; color: white">
                            <th>
                                {{ CrudView::checkAllBox('danger') }}
                            </th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>
                                @if(!in_array($role->id, [
                                    (Bkstar123\BksCMS\AdminPanel\Role::class)::SUPERADMINS, 
                                    (Bkstar123\BksCMS\AdminPanel\Role::class)::ADMINISTRATORS
                                ]))
                                {{ CrudView::checkBox($role, 'danger') }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('roles.show', [
                                        'role' => $role->{$role->getRouteKeyName()}
                                        ]) }}">
                                    {{ $role->role }}
                                </a>
                            </td>
                            <td>
                                @if($role->status)
                                    @can('deactivate', $role)
                                    {{ CrudView::activeStatus($role, route('roles.disabling', [
                                        'role' => $role->{$role->getRouteKeyName()}
                                        ])) }}
                                    @else
                                    <button class="btn btn-success" disabled>
                                        Active
                                    </button>
                                    @endcan
                                @else
                                    @can('activate', $role)
                                    {{ CrudView::disabledStatus($role, route('roles.activating', [
                                        'role' => $role->{$role->getRouteKeyName()}
                                        ])) }}
                                    @else
                                    <button class="btn btn-secondary" disabled>
                                        Disabled
                                    </button>
                                    @endcan
                                @endif
                            </td>
                            <td>
                                @can('delete', $role)
                                {{ CrudView::removeBtn($role, route('roles.destroy', [
                                    'role' => $role->{$role->getRouteKeyName()}
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
        Shows {{ $roles->count() }} result(s)
        {{ $roles->links() }}
    </div>
</div>
@endsection