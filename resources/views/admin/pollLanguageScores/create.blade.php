@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pollLanguageScore.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.poll-language-scores.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="language_id">{{ trans('cruds.pollLanguageScore.fields.language') }}</label>
                <select class="form-control select2 {{ $errors->has('language') ? 'is-invalid' : '' }}" name="language_id" id="language_id" required>
                    @foreach($languages as $id => $entry)
                        <option value="{{ $id }}" {{ old('language_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('language'))
                    <span class="text-danger">{{ $errors->first('language') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollLanguageScore.fields.language_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="education_level_id">{{ trans('cruds.pollLanguageScore.fields.education_level') }}</label>
                <select class="form-control select2 {{ $errors->has('education_level') ? 'is-invalid' : '' }}" name="education_level_id" id="education_level_id" required>
                    @foreach($education_levels as $id => $entry)
                        <option value="{{ $id }}" {{ old('education_level_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('education_level'))
                    <span class="text-danger">{{ $errors->first('education_level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollLanguageScore.fields.education_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="points">{{ trans('cruds.pollLanguageScore.fields.points') }}</label>
                <input class="form-control {{ $errors->has('points') ? 'is-invalid' : '' }}" type="number" name="points" id="points" value="{{ old('points', '0') }}" step="0.01" required max="1">
                @if($errors->has('points'))
                    <span class="text-danger">{{ $errors->first('points') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollLanguageScore.fields.points_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
