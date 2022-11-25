@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pollCandidate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.poll-candidates.update", [$pollCandidate->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="poll_id">{{ trans('cruds.pollCandidate.fields.poll') }}</label>
                <select class="form-control select2 {{ $errors->has('poll') ? 'is-invalid' : '' }}" name="poll_id" id="poll_id" required>
                    @foreach($polls as $id => $entry)
                        <option value="{{ $id }}" {{ (old('poll_id') ? old('poll_id') : $pollCandidate->poll->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('poll'))
                    <span class="text-danger">{{ $errors->first('poll') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.poll_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="candidate_id">{{ trans('cruds.pollCandidate.fields.candidate') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate') ? 'is-invalid' : '' }}" name="candidate_id" id="candidate_id" required>
                    @foreach($candidates as $id => $entry)
                        <option value="{{ $id }}" {{ (old('candidate_id') ? old('candidate_id') : $pollCandidate->candidate->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate'))
                    <span class="text-danger">{{ $errors->first('candidate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.candidate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="score">{{ trans('cruds.pollCandidate.fields.score') }}</label>
                <input class="form-control {{ $errors->has('score') ? 'is-invalid' : '' }}" type="number" name="score" id="score" value="{{ old('score', $pollCandidate->score) }}" step="0.01">
                @if($errors->has('score'))
                    <span class="text-danger">{{ $errors->first('score') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.score_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experience_points">{{ trans('cruds.pollCandidate.fields.experience_points') }}</label>
                <input class="form-control {{ $errors->has('experience_points') ? 'is-invalid' : '' }}" type="number" name="experience_points" id="experience_points" value="{{ old('experience_points', $pollCandidate->experience_points) }}" step="1">
                @if($errors->has('experience_points'))
                    <span class="text-danger">{{ $errors->first('experience_points') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.experience_points_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="age">{{ trans('cruds.pollCandidate.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', $pollCandidate->age) }}" step="1">
                @if($errors->has('age'))
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company">{{ trans('cruds.pollCandidate.fields.company') }}</label>
                <input class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" type="text" name="company" id="company" value="{{ old('company', $pollCandidate->company) }}">
                @if($errors->has('company'))
                    <span class="text-danger">{{ $errors->first('company') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.pollCandidate.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $entry)
                        <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $pollCandidate->city->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="professional_level_id">{{ trans('cruds.pollCandidate.fields.professional_level') }}</label>
                <select class="form-control select2 {{ $errors->has('professional_level') ? 'is-invalid' : '' }}" name="professional_level_id" id="professional_level_id">
                    @foreach($professional_levels as $id => $entry)
                        <option value="{{ $id }}" {{ (old('professional_level_id') ? old('professional_level_id') : $pollCandidate->professional_level->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('professional_level'))
                    <span class="text-danger">{{ $errors->first('professional_level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.professional_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="languages">{{ trans('cruds.pollCandidate.fields.languages') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('languages') ? 'is-invalid' : '' }}" name="languages[]" id="languages" multiple>
                    @foreach($languages as $id => $language)
                        <option value="{{ $id }}" {{ (in_array($id, old('languages', [])) || $pollCandidate->languages->contains($id)) ? 'selected' : '' }}>{{ $language }}</option>
                    @endforeach
                </select>
                @if($errors->has('languages'))
                    <span class="text-danger">{{ $errors->first('languages') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.languages_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="educational_level_id">{{ trans('cruds.pollCandidate.fields.educational_level') }}</label>
                <select class="form-control select2 {{ $errors->has('educational_level') ? 'is-invalid' : '' }}" name="educational_level_id" id="educational_level_id">
                    @foreach($educational_levels as $id => $entry)
                        <option value="{{ $id }}" {{ (old('educational_level_id') ? old('educational_level_id') : $pollCandidate->educational_level->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('educational_level'))
                    <span class="text-danger">{{ $errors->first('educational_level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.educational_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="functional_area_id">{{ trans('cruds.pollCandidate.fields.functional_area') }}</label>
                <select class="form-control select2 {{ $errors->has('functional_area') ? 'is-invalid' : '' }}" name="functional_area_id" id="functional_area_id">
                    @foreach($functional_areas as $id => $entry)
                        <option value="{{ $id }}" {{ (old('functional_area_id') ? old('functional_area_id') : $pollCandidate->functional_area->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('functional_area'))
                    <span class="text-danger">{{ $errors->first('functional_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.functional_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.pollCandidate.fields.company_size') }}</label>
                @foreach(App\Models\PollCandidate::COMPANY_SIZE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('company_size') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="company_size_{{ $key }}" name="company_size" value="{{ $key }}" {{ old('company_size', $pollCandidate->company_size) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="company_size_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('company_size'))
                    <span class="text-danger">{{ $errors->first('company_size') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.company_size_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="candidate_program_id">{{ trans('cruds.pollCandidate.fields.candidate_program') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate_program') ? 'is-invalid' : '' }}" name="candidate_program_id" id="candidate_program_id">
                    @foreach($candidate_programs as $id => $entry)
                        <option value="{{ $id }}" {{ (old('candidate_program_id') ? old('candidate_program_id') : $pollCandidate->candidate_program->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate_program'))
                    <span class="text-danger">{{ $errors->first('candidate_program') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.candidate_program_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_initial') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_initial" value="0">
                    <input class="form-check-input" type="checkbox" name="is_initial" id="is_initial" value="1" {{ $pollCandidate->is_initial || old('is_initial', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_initial">{{ trans('cruds.pollCandidate.fields.is_initial') }}</label>
                </div>
                @if($errors->has('is_initial'))
                    <span class="text-danger">{{ $errors->first('is_initial') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.is_initial_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_final') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_final" value="0">
                    <input class="form-check-input" type="checkbox" name="is_final" id="is_final" value="1" {{ $pollCandidate->is_final || old('is_final', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_final">{{ trans('cruds.pollCandidate.fields.is_final') }}</label>
                </div>
                @if($errors->has('is_final'))
                    <span class="text-danger">{{ $errors->first('is_final') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollCandidate.fields.is_final_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
