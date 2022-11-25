@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.candidateProgram.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.candidateProgram.fields.candidate') }}</th>
                        <td>{{ $candidateProgram->candidate->full_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.program') }}</th>
                        <td>{{ $candidateProgram->program->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.status') }}</th>
                        <td>{{ App\Models\CandidateProgram::STATUS_RADIO[$candidateProgram->status] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.tag') }}</th>
                        <td>
                            @foreach($candidateProgram->tags as $key => $tag)
                                <span class="badge badge-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.program_start_date') }}</th>
                        <td>{{ $candidateProgram->program_start_date }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.program_end_date') }}</th>
                        <td>{{ $candidateProgram->program_end_date }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.relocation_date') }}</th>
                        <td>{{ $candidateProgram->relocation_date }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.relocation_company') }}</th>
                        <td>{{ $candidateProgram->relocation_company ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.functional_area') }}</th>
                        <td>{{ $candidateProgram->functional_area->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.profesional_level') }}</th>
                        <td>{{ $candidateProgram->profesional_level->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.industry_sector') }}</th>
                        <td>{{ $candidateProgram->industry_sector->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateProgram.fields.internal_notes') }}</th>
                        <td>{{ $candidateProgram->internal_notes }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
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
            <a class="nav-link" href="#candidate_program_candidate_services" role="tab" data-toggle="tab">
                {{ trans('cruds.candidateService.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#candidate_program_poll_candidates" role="tab" data-toggle="tab">
                {{ trans('cruds.pollCandidate.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="candidate_program_candidate_services">
            @includeIf('admin.candidatePrograms.relationships.candidateProgramCandidateServices', ['candidateServices' => $candidateProgram->candidateProgramCandidateServices])
        </div>
        <div class="tab-pane" role="tabpanel" id="candidate_program_poll_candidates">
            @includeIf('admin.candidatePrograms.relationships.candidateProgramPollCandidates', ['pollCandidates' => $candidateProgram->candidateProgramPollCandidates])
        </div>
    </div>
</div>

@endsection
