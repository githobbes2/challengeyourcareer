@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.role.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('role_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.roles.edit', $role->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.role.fields.title') }}</th>
                        <td>{{ $role->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.role.fields.permissions') }}</th>
                        <td>
                            @foreach($role->permissions as $key => $permissions)
                                <span class="badge badge-info">{{ $permissions->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('role_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.roles.edit', $role->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
