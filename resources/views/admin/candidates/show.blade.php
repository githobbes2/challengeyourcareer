@extends('layouts.admin')

@section('scripts')
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endsection

@section('styles')
<link href="{{ asset('css/rating-control.css') }}" rel="stylesheet">
@endsection

@section('content')
<section>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    <a href="{{ route("admin.candidates.index") }}">{{ trans('global.candidates') }}</a> / {{ $candidate->full_name }}
                    @can('candidate_edit')
                    <a class="btn btn-sm btn-info float-right ml-1" href="{{ route('admin.candidates.edit', $candidate->id) }}">{{ trans('global.edit') }}</a>
                    @endcan
                    <a href="#" onclick="window.history.back();" class="btn btn-sm btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
        <div class="card">
            <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                <li class="nav-item">
                    <a class="nav-link active show" href="#candidate_candidate_profile" role="tab" data-toggle="tab">{{ trans('global.profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_candidate_sessions" role="tab" data-toggle="tab">{{ trans('global.sessions') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_candidate_commitments" role="tab" data-toggle="tab">{{ trans('cruds.candidateCommitment.title') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_candidate_services" role="tab" data-toggle="tab">{{ trans('cruds.serviceItem.title') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_event_candidates" role="tab" data-toggle="tab">{{ trans('cruds.event.title') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_poll_candidates" role="tab" data-toggle="tab">{{ trans('cruds.poll.title') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_candidate_curriculums" role="tab" data-toggle="tab">{{ trans('cruds.candidate.fields.curriculum') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_job_offer_candidates" role="tab" data-toggle="tab">{{ trans('cruds.jobOffer.title') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#candidate_job_offers" role="tab" data-toggle="tab">{{ trans('cruds.jobOffer.title') }} (Propias)</a>
                </li>
            </ul>
        </div>
        </div>
    </div>

    <div class="row">
    <div class="col">
        <div class="tab-content">
            <div class="tab-pane active show" role="tabpanel" id="candidate_candidate_profile">
                @includeIf('admin.candidates.relationships.profile')
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_candidate_sessions">
                @includeIf('admin.candidates.relationships.sessions')
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_candidate_commitments">
                @includeIf('admin.candidates.relationships.candidateCandidateCommitments', ['candidateCommitments' => $candidate->candidateCandidateCommitments])
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_candidate_services">
                @includeIf('admin.candidates.relationships.candidateCandidateServices', ['candidateServices' => $candidate->candidateCandidateServices])
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_job_offer_candidates">
                @includeIf('admin.candidates.relationships.candidateJobOfferCandidates', ['jobOfferCandidates' => $candidate->candidateJobOfferCandidates])
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_event_candidates">
                @includeIf('admin.candidates.relationships.candidateEventCandidates', ['eventCandidates' => $candidate->candidateEventCandidates])
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_poll_candidates">
                @includeIf('admin.candidates.relationships.candidatePollCandidates', ['pollCandidates' => $candidate->candidatePollCandidates])
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_candidate_curriculums">
                @includeIf('admin.candidates.relationships.candidateCandidateCurriculums', ['candidateCurriculums' => $candidate->candidateCandidateCurriculums])
            </div>
            <div class="tab-pane" role="tabpanel" id="candidate_job_offers">
                @includeIf('admin.candidates.relationships.candidateJobOffers', ['jobOffers' => $candidate->candidateJobOffers])
            </div>
        </div>
    </div>
    </div>
</section>

@endsection
