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
                        <th width="180">{{ trans('cruds.sessionTemplate.fields.title') }}</th>
                        <td>{{ $sessionTemplate->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.description') }}</th>
                        <td>{{ $sessionTemplate->description }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionTemplate.fields.items') }}</th>
                        <td>
                        @if(count($sessionTemplate->session_types))
                            <table class="table table-bordered table-striped">
                            <tbody>
                                @foreach($sessionTemplate->session_types as $key => $item)
                                <tr>
                                    <td width="200">{{ $item->name }}</td>
                                    <td>{{ $item->pivot->quantity . ' ' . ($item->pivot->quantity > 1 ? trans('global.sessions') : trans('global.session')) }}</td>
                                    <td>{{ $item->pivot->duration . ' ' . trans('global.minutes_short') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        @else
                            <div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div>
                        @endif
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
