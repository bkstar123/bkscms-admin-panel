@extends('cms.layouts.master')
@section('title', 'List of access permissions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Access Permissions 
                </h3>
                @can('massiveDelete', Bkstar123\BksCMS\AdminPanel\Permission::class)
                    {{ CrudView::removeAllBtn(route('permissions.massiveDestroy')) }}
                @else
                    <button class="btn btn-danger" disabled>
                        Remove all
                    </button>
                @endcan
                <div class="card-tools">
                    {{ CrudView::searchInput(route('permissions.index')) }}
                </div>
            </div><!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr style="background-color: #4681AF; color: white">
                            <th>
                                {{ CrudView::checkAllBox('danger') }}
                            </th>
                            <th>Permission</th>
                            <th>Alias</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>
                                {{ CrudView::checkBox($permission, 'danger') }}
                            </td>
                            <td>
                                <a href="{{ route('permissions.show', [
                                        'permission' => $permission->{$permission->getRouteKeyName()}
                                        ]) }}">
                                    {{ $permission->permission }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('permissions.show', [
                                        'permission' => $permission->{$permission->getRouteKeyName()}
                                        ]) }}">
                                    {{ $permission->alias }}
                                </a>
                            </td>
                            <td>
                                @if($permission->status)
                                    @can('deactivate', $permission)
                                    {{ CrudView::activeStatus($permission, route('permissions.disabling', [
                                        'permission' => $permission->{$permission->getRouteKeyName()}
                                        ])) }}
                                    @else
                                    <button class="btn btn-success" disabled>
                                        Active
                                    </button>
                                    @endcan
                                @else
                                    @can('activate', $permission)
                                    {{ CrudView::disabledStatus($permission, route('permissions.activating', [
                                        'permission' => $permission->{$permission->getRouteKeyName()}
                                        ])) }}
                                    @else
                                    <button class="btn btn-secondary" disabled>
                                        Disabled
                                    </button>
                                    @endcan
                                @endif
                            </td>
                            <td>
                                @can('delete', $permission)
                                {{ CrudView::removeBtn($permission, route('permissions.destroy', [
                                    'permission' => $permission->{$permission->getRouteKeyName()}
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
        Shows {{ $permissions->count() }} result(s)
        {{ $permissions->links() }}
    </div>
</div>
@endsection