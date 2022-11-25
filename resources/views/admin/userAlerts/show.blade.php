@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userAlert.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">
                            {{ trans('cruds.userAlert.fields.alert_text') }}
                        </th>
                        <td>
                            {{ $userAlert->alert_text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.alert_link') }}
                        </th>
                        <td>
                            {{ $userAlert->alert_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.user') }}
                        </th>
                        <td>
                            @foreach($userAlert->users as $key => $user)
                                <span class="badge badge-info">{{ $user->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.created_at') }}
                        </th>
                        <td>
                            {{ $userAlert->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
