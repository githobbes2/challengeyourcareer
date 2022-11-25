@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.jobOfferCandidate.title') }}
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
                            {{ trans('cruds.jobOfferCandidate.fields.job_offer') }}
                        </th>
                        <td>
                            {{ $jobOfferCandidate->job_offer->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.candidate') }}
                        </th>
                        <td>
                            {{ $jobOfferCandidate->candidate->full_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\JobOfferCandidate::STATUS_RADIO[$jobOfferCandidate->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.is_favorite') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $jobOfferCandidate->is_favorite ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.curriculum') }}
                        </th>
                        <td>
                            {{ $jobOfferCandidate->curriculum->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.request_mediation') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $jobOfferCandidate->request_mediation ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.mediation_status') }}
                        </th>
                        <td>
                            {{ App\Models\JobOfferCandidate::MEDIATION_STATUS_SELECT[$jobOfferCandidate->mediation_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.mediation_notes') }}
                        </th>
                        <td>
                            {{ $jobOfferCandidate->mediation_notes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferCandidate.fields.mediation_private_notes') }}
                        </th>
                        <td>
                            {{ $jobOfferCandidate->mediation_private_notes }}
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



@endsection
