@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.jobOffer.title') }}
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
                            {{ trans('cruds.jobOffer.fields.title') }}
                        </th>
                        <td>
                            {{ $jobOffer->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.user') }}
                        </th>
                        <td>
                            {{ $jobOffer->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.candidate') }}
                        </th>
                        <td>
                            {{ $jobOffer->candidate->full_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.program') }}
                        </th>
                        <td>
                            {{ $jobOffer->program->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $jobOffer->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.date_start') }}
                        </th>
                        <td>
                            {{ $jobOffer->date_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.date_end') }}
                        </th>
                        <td>
                            {{ $jobOffer->date_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.tag') }}
                        </th>
                        <td>
                            @foreach($jobOffer->tags as $key => $tag)
                                <span class="badge badge-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.recruiter_type') }}
                        </th>
                        <td>
                            {{ $jobOffer->recruiter_type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.company') }}
                        </th>
                        <td>
                            {{ $jobOffer->company }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.contact_name') }}
                        </th>
                        <td>
                            {{ $jobOffer->contact_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.contact_email') }}
                        </th>
                        <td>
                            {{ $jobOffer->contact_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.contact_phone') }}
                        </th>
                        <td>
                            {{ $jobOffer->contact_phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.url') }}
                        </th>
                        <td>
                            {{ $jobOffer->url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.city') }}
                        </th>
                        <td>
                            {{ $jobOffer->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.description') }}
                        </th>
                        <td>
                            {!! $jobOffer->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.educational_level') }}
                        </th>
                        <td>
                            {{ $jobOffer->educational_level->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.professional_level') }}
                        </th>
                        <td>
                            {{ $jobOffer->professional_level->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.functional_area') }}
                        </th>
                        <td>
                            {{ $jobOffer->functional_area->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.language') }}
                        </th>
                        <td>
                            @foreach($jobOffer->languages as $key => $language)
                                <span class="badge badge-info">{{ $language->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.skill') }}
                        </th>
                        <td>
                            {{ $jobOffer->skill->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.industry_sector') }}
                        </th>
                        <td>
                            {{ $jobOffer->industry_sector->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.attachments') }}
                        </th>
                        <td>
                            @foreach($jobOffer->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
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
            <a class="nav-link" href="#job_offer_job_offer_candidates" role="tab" data-toggle="tab">
                {{ trans('cruds.jobOfferCandidate.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="job_offer_job_offer_candidates">
            @includeIf('admin.jobOffers.relationships.jobOfferJobOfferCandidates', ['jobOfferCandidates' => $jobOffer->jobOfferJobOfferCandidates])
        </div>
    </div>
</div>

@endsection
