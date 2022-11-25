@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.candidateProgram.title_new_record') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.candidate-programs.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="referer" value="{{ $referer }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="candidates">{{ trans('cruds.candidateProgram.fields.candidates') }}</label>
                        @if(!is_null($candidateID))
                        <input type="hidden" name="candidate_id" value="{{ $candidateID }}">
                        <select class="form-control select2" name="hold_candidate_id" id="hold_candidate_id" disabled>
                            @foreach($candidates as $id => $entry)
                                <option value="{{ $id }}" selected>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @else
                        <select class="form-control select2 {{ $errors->has('candidates') ? 'is-invalid' : '' }}" name="candidates[]" id="candidates" multiple required>
                            @foreach($candidates as $id => $entry)
                                <option value="{{ $id }}" {{ in_array($id, old('candidates', [])) ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @endif


                        @if($errors->has('candidate'))
                            <span class="text-danger">{{ $errors->first('candidate') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.candidateProgram.fields.candidates_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="program_id">{{ trans('cruds.candidateProgram.fields.program') }}</label>
                        @if ($programID>0)
                        <input type="hidden" name="program_id" value="{{ $programID }}">
                        <select class="form-control select2 {{ $errors->has('program') ? 'is-invalid' : '' }}" name="hold_program_id" id="hold_program_id" disabled>
                            @foreach($programs as $id => $entry)
                                <option value="{{ $id }}" {{ (old('program_id') ? old('program_id') : $programID ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @else
                        <select class="form-control select2 {{ $errors->has('program') ? 'is-invalid' : '' }}" name="program_id" id="program_id" required>
                            <option value disabled {{ old('program_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach($programs as $item)
                                <option value="{{ $item->id }}" {{ (old('program_id') ? old('program_id') : $programID ?? '') == $item->id ? 'selected' : '' }}>{{ $item->name }} {{ $item->internal_name ? '('. $item->internal_name .')' : '' }}</option>
                            @endforeach
                        </select>
                        @endif
                        @if($errors->has('program'))
                            <span class="text-danger">{{ $errors->first('program') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.candidateProgram.fields.program_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.candidateProgram.fields.status') }}</label>
                        @foreach(App\Models\CandidateProgram::STATUS_RADIO as $key => $label)
                            <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', '0') === (string) $key ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_start_date">{{ trans('cruds.candidateProgram.fields.program_start_date') }}</label>
                        <input class="form-control date {{ $errors->has('program_start_date') ? 'is-invalid' : '' }}" type="text" name="program_start_date" id="program_start_date" value="{{ old('program_start_date') }}">
                        @if($errors->has('program_start_date'))
                            <span class="text-danger">{{ $errors->first('program_start_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.candidateProgram.fields.program_start_date_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_end_date">{{ trans('cruds.candidateProgram.fields.program_end_date') }}</label>
                        <input class="form-control date {{ $errors->has('program_end_date') ? 'is-invalid' : '' }}" type="text" name="program_end_date" id="program_end_date" value="{{ old('program_end_date') }}">
                        @if($errors->has('program_end_date'))
                            <span class="text-danger">{{ $errors->first('program_end_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.candidateProgram.fields.program_end_date_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="card bg-light mt-3">
                <div class="card-header">
                    <h4 class="mb-0">Detalles de Recolocación</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="relocation_date">{{ trans('cruds.candidateProgram.fields.relocation_date') }}</label>
                                <input class="form-control date {{ $errors->has('relocation_date') ? 'is-invalid' : '' }}" type="text" name="relocation_date" id="relocation_date" value="{{ old('relocation_date') }}">
                                @if($errors->has('relocation_date'))
                                    <span class="text-danger">{{ $errors->first('relocation_date') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.candidateProgram.fields.relocation_date_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="relocation_company">{{ trans('cruds.candidateProgram.fields.relocation_company') }}</label>
                                <input class="form-control {{ $errors->has('relocation_company') ? 'is-invalid' : '' }}" type="text" name="relocation_company" id="relocation_company" value="{{ old('relocation_company', '') }}">
                                @if($errors->has('relocation_company'))
                                    <span class="text-danger">{{ $errors->first('relocation_company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.candidateProgram.fields.relocation_company_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="industry_sector_id">{{ trans('cruds.candidateProgram.fields.industry_sector') }}</label>
                                <select class="form-control select2 {{ $errors->has('industry_sector') ? 'is-invalid' : '' }}" name="industry_sector_id" id="industry_sector_id">
                                    @foreach($industry_sectors as $id => $entry)
                                        <option value="{{ $id }}" {{ old('industry_sector_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('industry_sector'))
                                    <span class="text-danger">{{ $errors->first('industry_sector') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.candidateProgram.fields.industry_sector_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="functional_area_id">{{ trans('cruds.candidateProgram.fields.functional_area') }}</label>
                                <select class="form-control select2 {{ $errors->has('functional_area') ? 'is-invalid' : '' }}" name="functional_area_id" id="functional_area_id">
                                    @foreach($functional_areas as $id => $entry)
                                        <option value="{{ $id }}" {{ old('functional_area_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('functional_area'))
                                    <span class="text-danger">{{ $errors->first('functional_area') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.candidateProgram.fields.functional_area_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profesional_level_id">{{ trans('cruds.candidateProgram.fields.profesional_level') }}</label>
                                <select class="form-control select2 {{ $errors->has('profesional_level') ? 'is-invalid' : '' }}" name="profesional_level_id" id="profesional_level_id">
                                    @foreach($profesional_levels as $id => $entry)
                                        <option value="{{ $id }}" {{ old('profesional_level_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('profesional_level'))
                                    <span class="text-danger">{{ $errors->first('profesional_level') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.candidateProgram.fields.profesional_level_helper') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="internal_notes">{{ trans('cruds.candidateProgram.fields.internal_notes') }}</label>
                <textarea class="form-control {{ $errors->has('internal_notes') ? 'is-invalid' : '' }}" name="internal_notes" id="internal_notes">{{ old('internal_notes') }}</textarea>
                @if($errors->has('internal_notes'))
                    <span class="text-danger">{{ $errors->first('internal_notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateProgram.fields.internal_notes_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
