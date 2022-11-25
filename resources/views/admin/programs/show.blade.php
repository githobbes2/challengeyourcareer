@extends('layouts.admin')
@section('content')

<div class="card">
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#program_sessions" role="tab" data-toggle="tab">
                {{ trans('cruds.session.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#program_candidate_programs" role="tab" data-toggle="tab">
                {{ trans('cruds.candidate.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#program_job_offers" role="tab" data-toggle="tab">
                {{ trans('cruds.jobOffer.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#programs_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="program_sessions">
            @includeIf('admin.programs.relationships.programSessions', ['sessions' => $program->sessions])
        </div>
        <div class="tab-pane" role="tabpanel" id="program_candidate_programs">
            @includeIf('admin.programs.relationships.programCandidatePrograms', ['candidatePrograms' => $program->programCandidatePrograms])
        </div>
        <div class="tab-pane" role="tabpanel" id="program_job_offers">
            @includeIf('admin.programs.relationships.programJobOffers', ['jobOffers' => $program->programJobOffers])
        </div>
        <div class="tab-pane" role="tabpanel" id="programs_events">
            @includeIf('admin.programs.relationships.programsEvents', ['events' => $program->programsEvents])
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.program.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('program_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.programs.edit', $program->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="{{ route('admin.programs.dossier', [$program]) }}" class="btn btn-outline-primary ms-1 ml-2 float-right">{{ trans('global.dossier') }}</a>
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.program.fields.name') }}</th>
                        <td>{{ $program->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.internal_name') }}</th>
                        <td>{{ $program->internal_name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.program_type') }}</th>
                        <td>{{ $program->program_type->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.session_template') }}</th>
                        <td>{{ $program->session_template->title ?? '' }}
                            @if($program->session_template)
                            @if(count($program->session_template->session_types))
                                <table class="table table-bordered table-striped mt-3">
                                <tbody>
                                    @foreach($program->session_template->session_types as $key => $item)
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
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.user') }}</th>
                        <td>{{ $program->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.individual') }}</th>
                        <td>{{ App\Models\Program::INDIVIDUAL_RADIO[$program->individual] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.service_group') }}</th>
                        <td>{{ $program->serviceGroup->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.company') }}</th>
                        <td>{{ $program->company->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.invoice') }}</th>
                        <td>{{ $program->invoice }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.reference') }}</th>
                        <td>{{ $program->reference }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.internal_notes') }}</th>
                        <td>{{ $program->internal_notes }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.program.fields.attachments') }}</th>
                        <td>
                            @foreach($program->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('program_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.programs.edit', $program->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
