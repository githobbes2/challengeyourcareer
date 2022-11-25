@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.programType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('program_type_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.program-types.edit', $programType->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.programType.fields.name') }}</th>
                        <td>{{ $programType->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.programType.fields.description') }}</th>
                        <td>{{ $programType->description }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.programType.fields.outplacement') }}</th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $programType->outplacement ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.programType.fields.service_groups') }}</th>
                        <td>
                            @foreach($programType->service_groups as $key => $service_groups)
                                <span class="badge badge-info">{{ $service_groups->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.programType.fields.session_types') }}</th>
                        <td>
                            @foreach($programType->session_types as $key => $session_types)
                                <span class="badge badge-info">{{ $session_types->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('program_type_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.program-types.edit', $programType->id) }}">{{ trans('global.edit') }}</a>
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
            <a class="nav-link" href="#program_type_programs" role="tab" data-toggle="tab">
                {{ trans('cruds.program.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#program_types_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="program_type_programs">
            @includeIf('admin.programTypes.relationships.programTypePrograms', ['programs' => $programType->programTypePrograms])
        </div>
        <div class="tab-pane" role="tabpanel" id="program_types_events">
            @includeIf('admin.programTypes.relationships.programTypesEvents', ['events' => $programType->programTypesEvents])
        </div>
    </div>
</div>

@endsection
