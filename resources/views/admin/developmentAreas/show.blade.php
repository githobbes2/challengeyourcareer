@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.developmentArea.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('development_area_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.development-areas.edit', $developmentArea->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.developmentArea.fields.name') }}</th>
                        <td>{{ $developmentArea->name }}</td>
                    </tr>
                    <tr>
                        <th width="180">{{ trans('cruds.developmentArea.fields.description') }}</th>
                        <td>{{ $developmentArea->description }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('development_area_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.development-areas.edit', $developmentArea->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
