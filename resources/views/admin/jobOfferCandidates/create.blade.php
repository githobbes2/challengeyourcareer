@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.jobOfferCandidate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.job-offer-candidates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="job_offer_id">{{ trans('cruds.jobOfferCandidate.fields.job_offer') }}</label>
                <select class="form-control select2 {{ $errors->has('job_offer') ? 'is-invalid' : '' }}" name="job_offer_id" id="job_offer_id" required>
                    @foreach($job_offers as $id => $entry)
                        <option value="{{ $id }}" {{ old('job_offer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('job_offer'))
                    <span class="text-danger">{{ $errors->first('job_offer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.job_offer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="candidate_id">{{ trans('cruds.jobOfferCandidate.fields.candidate') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate') ? 'is-invalid' : '' }}" name="candidate_id" id="candidate_id">
                    @foreach($candidates as $id => $entry)
                        <option value="{{ $id }}" {{ old('candidate_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate'))
                    <span class="text-danger">{{ $errors->first('candidate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.candidate_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.jobOfferCandidate.fields.status') }}</label>
                @foreach(App\Models\JobOfferCandidate::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', '') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_favorite') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_favorite" value="0">
                    <input class="form-check-input" type="checkbox" name="is_favorite" id="is_favorite" value="1" {{ old('is_favorite', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_favorite">{{ trans('cruds.jobOfferCandidate.fields.is_favorite') }}</label>
                </div>
                @if($errors->has('is_favorite'))
                    <span class="text-danger">{{ $errors->first('is_favorite') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.is_favorite_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="curriculum_id">{{ trans('cruds.jobOfferCandidate.fields.curriculum') }}</label>
                <select class="form-control select2 {{ $errors->has('curriculum') ? 'is-invalid' : '' }}" name="curriculum_id" id="curriculum_id">
                    @foreach($curricula as $id => $entry)
                        <option value="{{ $id }}" {{ old('curriculum_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('curriculum'))
                    <span class="text-danger">{{ $errors->first('curriculum') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.curriculum_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('request_mediation') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="request_mediation" value="0">
                    <input class="form-check-input" type="checkbox" name="request_mediation" id="request_mediation" value="1" {{ old('request_mediation', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="request_mediation">{{ trans('cruds.jobOfferCandidate.fields.request_mediation') }}</label>
                </div>
                @if($errors->has('request_mediation'))
                    <span class="text-danger">{{ $errors->first('request_mediation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.request_mediation_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.jobOfferCandidate.fields.mediation_status') }}</label>
                <select class="form-control {{ $errors->has('mediation_status') ? 'is-invalid' : '' }}" name="mediation_status" id="mediation_status">
                    <option value disabled {{ old('mediation_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\JobOfferCandidate::MEDIATION_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('mediation_status', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('mediation_status'))
                    <span class="text-danger">{{ $errors->first('mediation_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.mediation_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mediation_notes">{{ trans('cruds.jobOfferCandidate.fields.mediation_notes') }}</label>
                <textarea class="form-control {{ $errors->has('mediation_notes') ? 'is-invalid' : '' }}" name="mediation_notes" id="mediation_notes">{{ old('mediation_notes') }}</textarea>
                @if($errors->has('mediation_notes'))
                    <span class="text-danger">{{ $errors->first('mediation_notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.mediation_notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mediation_private_notes">{{ trans('cruds.jobOfferCandidate.fields.mediation_private_notes') }}</label>
                <textarea class="form-control {{ $errors->has('mediation_private_notes') ? 'is-invalid' : '' }}" name="mediation_private_notes" id="mediation_private_notes">{{ old('mediation_private_notes') }}</textarea>
                @if($errors->has('mediation_private_notes'))
                    <span class="text-danger">{{ $errors->first('mediation_private_notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOfferCandidate.fields.mediation_private_notes_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
