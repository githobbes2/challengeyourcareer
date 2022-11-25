@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.poll.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.polls.update", [$poll->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.poll.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $poll->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="question_groups">{{ trans('cruds.poll.fields.question_group') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('question_groups') ? 'is-invalid' : '' }}" name="question_groups[]" id="question_groups" multiple>
                    @foreach($question_groups as $id => $question_group)
                        <option value="{{ $id }}" {{ (in_array($id, old('question_groups', [])) || $poll->question_groups->contains($id)) ? 'selected' : '' }}>{{ $question_group }}</option>
                    @endforeach
                </select>
                @if($errors->has('question_groups'))
                    <span class="text-danger">{{ $errors->first('question_groups') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.question_group_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="label_1">{{ trans('cruds.poll.fields.label_1') }}</label>
                <input class="form-control {{ $errors->has('label_1') ? 'is-invalid' : '' }}" type="text" name="label_1" id="label_1" value="{{ old('label_1', $poll->label_1) }}">
                @if($errors->has('label_1'))
                    <span class="text-danger">{{ $errors->first('label_1') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.label_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="label_2">{{ trans('cruds.poll.fields.label_2') }}</label>
                <input class="form-control {{ $errors->has('label_2') ? 'is-invalid' : '' }}" type="text" name="label_2" id="label_2" value="{{ old('label_2', $poll->label_2) }}">
                @if($errors->has('label_2'))
                    <span class="text-danger">{{ $errors->first('label_2') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.label_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="label_3">{{ trans('cruds.poll.fields.label_3') }}</label>
                <input class="form-control {{ $errors->has('label_3') ? 'is-invalid' : '' }}" type="text" name="label_3" id="label_3" value="{{ old('label_3', $poll->label_3) }}">
                @if($errors->has('label_3'))
                    <span class="text-danger">{{ $errors->first('label_3') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.label_3_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="label_4">{{ trans('cruds.poll.fields.label_4') }}</label>
                <input class="form-control {{ $errors->has('label_4') ? 'is-invalid' : '' }}" type="text" name="label_4" id="label_4" value="{{ old('label_4', $poll->label_4) }}">
                @if($errors->has('label_4'))
                    <span class="text-danger">{{ $errors->first('label_4') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.label_4_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="label_5">{{ trans('cruds.poll.fields.label_5') }}</label>
                <input class="form-control {{ $errors->has('label_5') ? 'is-invalid' : '' }}" type="text" name="label_5" id="label_5" value="{{ old('label_5', $poll->label_5) }}">
                @if($errors->has('label_5'))
                    <span class="text-danger">{{ $errors->first('label_5') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.label_5_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('use_age_score') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="use_age_score" value="0">
                    <input class="form-check-input" type="checkbox" name="use_age_score" id="use_age_score" value="1" {{ $poll->use_age_score || old('use_age_score', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="use_age_score">{{ trans('cruds.poll.fields.use_age_score') }}</label>
                </div>
                @if($errors->has('use_age_score'))
                    <span class="text-danger">{{ $errors->first('use_age_score') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.use_age_score_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('use_language_score') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="use_language_score" value="0">
                    <input class="form-check-input" type="checkbox" name="use_language_score" id="use_language_score" value="1" {{ $poll->use_language_score || old('use_language_score', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="use_language_score">{{ trans('cruds.poll.fields.use_language_score') }}</label>
                </div>
                @if($errors->has('use_language_score'))
                    <span class="text-danger">{{ $errors->first('use_language_score') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.poll.fields.use_language_score_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
