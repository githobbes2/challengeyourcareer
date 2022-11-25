@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.consultantType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('consultant_type_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.consultant-types.edit', $consultantType->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">
                            {{ trans('cruds.consultantType.fields.name') }}
                        </th>
                        <td>
                            {{ $consultantType->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('consultant_type_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.consultant-types.edit', $consultantType->id) }}">{{ trans('global.edit') }}</a>
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
            <a class="nav-link" href="#consultant_type_consultants" role="tab" data-toggle="tab">
                {{ trans('cruds.consultant.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="consultant_type_consultants">
            @includeIf('admin.consultantTypes.relationships.consultantTypeConsultants', ['consultants' => $consultantType->consultantTypeConsultants])
        </div>
    </div>
</div>

@endsection
