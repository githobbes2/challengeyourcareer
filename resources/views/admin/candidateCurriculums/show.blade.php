@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.candidateCurriculum.title') }}
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
                            {{ trans('cruds.candidateCurriculum.fields.candidate') }}
                        </th>
                        <td>
                            {{ $candidateCurriculum->candidate->full_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidateCurriculum.fields.name') }}
                        </th>
                        <td>
                            {{ $candidateCurriculum->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidateCurriculum.fields.file') }}
                        </th>
                        <td>
                            @if($candidateCurriculum->file)
                                <a href="{{ $candidateCurriculum->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
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

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#curriculum_job_offer_candidates" role="tab" data-toggle="tab">
                {{ trans('cruds.jobOfferCandidate.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="curriculum_job_offer_candidates">
            @includeIf('admin.candidateCurriculums.relationships.curriculumJobOfferCandidates', ['jobOfferCandidates' => $candidateCurriculum->curriculumJobOfferCandidates])
        </div>
    </div>
</div>

@endsection
