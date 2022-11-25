@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.office.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('office_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.offices.edit', $office->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.office.fields.name') }}</th>
                        <td>{{ $office->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.office.fields.city') }}</th>
                        <td>{{ $office->city->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.office.fields.notes') }}</th>
                        <td>{{ $office->notes }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('office_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.offices.edit', $office->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#office_consultants" role="tab" data-toggle="tab">
                {{ trans('cruds.consultant.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="office_consultants">
            @includeIf('admin.offices.relationships.officeConsultants', ['consultants' => $office->officeConsultants])
        </div>
    </div>
</div>

@endsection
