@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.eventCandidate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.event-candidates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="event_id">{{ trans('cruds.eventCandidate.fields.event') }}</label>
                <select class="form-control select2 {{ $errors->has('event') ? 'is-invalid' : '' }}" name="event_id" id="event_id" required>
                    @foreach($events as $id => $entry)
                        <option value="{{ $id }}" {{ old('event_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('event'))
                    <span class="text-danger">{{ $errors->first('event') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.eventCandidate.fields.event_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="candidate_id">{{ trans('cruds.eventCandidate.fields.candidate') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate') ? 'is-invalid' : '' }}" name="candidate_id" id="candidate_id" required>
                    @foreach($candidates as $id => $entry)
                        <option value="{{ $id }}" {{ old('candidate_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate'))
                    <span class="text-danger">{{ $errors->first('candidate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.eventCandidate.fields.candidate_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('attendance') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="attendance" value="0">
                    <input class="form-check-input" type="checkbox" name="attendance" id="attendance" value="1" {{ old('attendance', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="attendance">{{ trans('cruds.eventCandidate.fields.attendance') }}</label>
                </div>
                @if($errors->has('attendance'))
                    <span class="text-danger">{{ $errors->first('attendance') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.eventCandidate.fields.attendance_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
