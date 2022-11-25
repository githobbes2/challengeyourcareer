@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.candidateService.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.candidate-services.update", [$candidateService->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="candidate_id">{{ trans('cruds.candidateService.fields.candidate') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate') ? 'is-invalid' : '' }}" name="candidate_id" id="candidate_id" required>
                    @foreach($candidates as $id => $entry)
                        <option value="{{ $id }}" {{ (old('candidate_id') ? old('candidate_id') : $candidateService->candidate->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate'))
                    <span class="text-danger">{{ $errors->first('candidate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.candidate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="service_item_id">{{ trans('cruds.candidateService.fields.service_item') }}</label>
                <select class="form-control select2 {{ $errors->has('service_item') ? 'is-invalid' : '' }}" name="service_item_id" id="service_item_id" required>
                    @foreach($service_items as $id => $entry)
                        <option value="{{ $id }}" {{ (old('service_item_id') ? old('service_item_id') : $candidateService->service_item->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_item'))
                    <span class="text-danger">{{ $errors->first('service_item') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.service_item_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_service">{{ trans('cruds.candidateService.fields.date_service') }}</label>
                <input class="form-control date {{ $errors->has('date_service') ? 'is-invalid' : '' }}" type="text" name="date_service" id="date_service" value="{{ old('date_service', $candidateService->date_service) }}">
                @if($errors->has('date_service'))
                    <span class="text-danger">{{ $errors->first('date_service') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.date_service_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.candidateService.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $candidateService->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('attendance') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="attendance" value="0">
                    <input class="form-check-input" type="checkbox" name="attendance" id="attendance" value="1" {{ $candidateService->attendance || old('attendance', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="attendance">{{ trans('cruds.candidateService.fields.attendance') }}</label>
                </div>
                @if($errors->has('attendance'))
                    <span class="text-danger">{{ $errors->first('attendance') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.attendance_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.candidateService.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes', $candidateService->notes) }}</textarea>
                @if($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="candidate_program_id">{{ trans('cruds.candidateService.fields.candidate_program') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate_program') ? 'is-invalid' : '' }}" name="candidate_program_id" id="candidate_program_id">
                    @foreach($candidate_programs as $id => $entry)
                        <option value="{{ $id }}" {{ (old('candidate_program_id') ? old('candidate_program_id') : $candidateService->candidate_program->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate_program'))
                    <span class="text-danger">{{ $errors->first('candidate_program') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.candidate_program_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_user_id">{{ trans('cruds.candidateService.fields.session_user') }}</label>
                <select class="form-control select2 {{ $errors->has('session_user') ? 'is-invalid' : '' }}" name="session_user_id" id="session_user_id">
                    @foreach($session_users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_user_id') ? old('session_user_id') : $candidateService->session_user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session_user'))
                    <span class="text-danger">{{ $errors->first('session_user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateService.fields.session_user_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
