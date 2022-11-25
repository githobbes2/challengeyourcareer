@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.programType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.program-types.update", [$programType->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.programType.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $programType->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.programType.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.programType.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $programType->description) }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.programType.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('outplacement') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="outplacement" value="0">
                    <input class="form-check-input" type="checkbox" name="outplacement" id="outplacement" value="1" {{ $programType->outplacement || old('outplacement', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="outplacement">{{ trans('cruds.programType.fields.outplacement') }}</label>
                </div>
                @if($errors->has('outplacement'))
                    <span class="text-danger">{{ $errors->first('outplacement') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.programType.fields.outplacement_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="service_groups">{{ trans('cruds.programType.fields.service_groups') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('service_groups') ? 'is-invalid' : '' }}" name="service_groups[]" id="service_groups" multiple>
                    @foreach($service_groups as $id => $service_group)
                        <option value="{{ $id }}" {{ (in_array($id, old('service_groups', [])) || $programType->service_groups->contains($id)) ? 'selected' : '' }}>{{ $service_group }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_groups'))
                    <span class="text-danger">{{ $errors->first('service_groups') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.programType.fields.service_groups_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_types">{{ trans('cruds.programType.fields.session_types') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('session_types') ? 'is-invalid' : '' }}" name="session_types[]" id="session_types" multiple>
                    @foreach($session_types as $id => $session_type)
                        <option value="{{ $id }}" {{ (in_array($id, old('session_types', [])) || $programType->session_types->contains($id)) ? 'selected' : '' }}>{{ $session_type }}</option>
                    @endforeach
                </select>
                @if($errors->has('session_types'))
                    <span class="text-danger">{{ $errors->first('session_types') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.programType.fields.session_types_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
