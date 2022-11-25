@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sessionType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('session_type_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.session-types.edit', $sessionType->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.sessionType.fields.name') }}</th>
                        <td>{{ $sessionType->name }}</td>
                    </tr>
                    <tr>
                        <th width="180">{{ trans('cruds.sessionType.fields.description') }}</th>
                        <td>{{ $sessionType->description }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.sessionType.fields.score_required') }}</th>
                        <td><input type="checkbox" disabled="disabled" {{ $sessionType->score_required ? 'checked' : '' }}></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('session_type_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.session-types.edit', $sessionType->id) }}">{{ trans('global.edit') }}</a>
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
            <a class="nav-link" href="#session_types_questions" role="tab" data-toggle="tab">
                {{ trans('cruds.question.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#session_types_program_types" role="tab" data-toggle="tab">
                {{ trans('cruds.programType.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="session_types_questions">
            @includeIf('admin.sessionTypes.relationships.sessionTypesQuestions', ['questions' => $sessionType->sessionTypesQuestions])
        </div>
        <div class="tab-pane" role="tabpanel" id="session_types_program_types">
            @includeIf('admin.sessionTypes.relationships.sessionTypesProgramTypes', ['programTypes' => $sessionType->sessionTypesProgramTypes])
        </div>
    </div>
</div>

@endsection
