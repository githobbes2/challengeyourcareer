@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sessionTemplate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('session_template_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.session-templates.edit', $sessionTemplate->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.sessionTemplate.fields.program') }}</th>
                        <td>{{ $sessionTemplate->program->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.session_type') }}</th>
                        <td>{{ $sessionTemplate->session_type->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.quantity') }}</th>
                        <td>{{ $sessionTemplate->quantity }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.title') }}</th>
                        <td>{{ $sessionTemplate->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.duration') }}</th>
                        <td>{{ $sessionTemplate->duration }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.description') }}</th>
                        <td>
                            {!! $sessionTemplate->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.private_notes') }}</th>
                        <td>{{ $sessionTemplate->private_notes }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.attachments') }}</th>
                        <td>
                            @foreach($sessionTemplate->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('session_template_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.session-templates.edit', $sessionTemplate->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
