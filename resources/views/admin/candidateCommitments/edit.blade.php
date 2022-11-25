@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.candidateCommitment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.candidate-commitments.update", [$candidateCommitment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.candidateCommitment.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $candidateCommitment->title) }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="candidate_id">{{ trans('cruds.candidateCommitment.fields.candidate') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate') ? 'is-invalid' : '' }}" name="candidate_id" id="candidate_id" required>
                    @foreach($candidates as $id => $entry)
                        <option value="{{ $id }}" {{ (old('candidate_id') ? old('candidate_id') : $candidateCommitment->candidate->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate'))
                    <span class="text-danger">{{ $errors->first('candidate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.candidate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_user_id">{{ trans('cruds.candidateCommitment.fields.session_user') }}</label>
                <select class="form-control select2 {{ $errors->has('session_user') ? 'is-invalid' : '' }}" name="session_user_id" id="session_user_id">
                    @foreach($session_users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_user_id') ? old('session_user_id') : $candidateCommitment->session_user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session_user'))
                    <span class="text-danger">{{ $errors->first('session_user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.session_user_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('complete') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="complete" value="0">
                    <input class="form-check-input" type="checkbox" name="complete" id="complete" value="1" {{ $candidateCommitment->complete || old('complete', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="complete">{{ trans('cruds.candidateCommitment.fields.complete') }}</label>
                </div>
                @if($errors->has('complete'))
                    <span class="text-danger">{{ $errors->first('complete') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.complete_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="completion_date">{{ trans('cruds.candidateCommitment.fields.completion_date') }}</label>
                <input class="form-control date {{ $errors->has('completion_date') ? 'is-invalid' : '' }}" type="text" name="completion_date" id="completion_date" value="{{ old('completion_date', $candidateCommitment->completion_date) }}">
                @if($errors->has('completion_date'))
                    <span class="text-danger">{{ $errors->first('completion_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.completion_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.candidateCommitment.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $candidateCommitment->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <span class="text-danger">{{ $errors->first('tags') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.candidateCommitment.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $candidateCommitment->note) }}</textarea>
                @if($errors->has('note'))
                    <span class="text-danger">{{ $errors->first('note') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.candidateCommitment.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments', $candidateCommitment->comments) }}</textarea>
                @if($errors->has('comments'))
                    <span class="text-danger">{{ $errors->first('comments') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.comments_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="development_area_id">{{ trans('cruds.candidateCommitment.fields.development_area') }}</label>
                <select class="form-control {{ $errors->has('development_area') ? 'is-invalid' : '' }}" name="development_area_id" id="development_area_id" required>
                    @foreach($development_areas as $id => $entry)
                        <option value="{{ $id }}" {{ (old('development_area_id') ? old('development_area_id') : $candidateCommitment->development_area->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('development_area'))
                    <span class="text-danger">{{ $errors->first('development_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateCommitment.fields.development_area_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
