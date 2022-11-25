@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.serviceItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.service-items.update", [$serviceItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.serviceItem.fields.type') }}</label>
                @foreach(App\Models\ServiceItem::TYPE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('type') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="type_{{ $key }}" name="type" value="{{ $key }}" {{ old('type', $serviceItem->type) === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="type_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceItem.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="service_type_id">{{ trans('cruds.serviceItem.fields.service_type') }}</label>
                <select class="form-control select2 {{ $errors->has('service_type') ? 'is-invalid' : '' }}" name="service_type_id" id="service_type_id" required>
                    @foreach($service_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('service_type_id') ? old('service_type_id') : $serviceItem->service_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_type'))
                    <span class="text-danger">{{ $errors->first('service_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceItem.fields.service_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.serviceItem.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $serviceItem->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceItem.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.serviceItem.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $serviceItem->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceItem.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="objective">{{ trans('cruds.serviceItem.fields.objective') }}</label>
                <input class="form-control {{ $errors->has('objective') ? 'is-invalid' : '' }}" type="text" name="objective" id="objective" value="{{ old('objective', $serviceItem->objective) }}">
                @if($errors->has('objective'))
                    <span class="text-danger">{{ $errors->first('objective') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceItem.fields.objective_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phase">{{ trans('cruds.serviceItem.fields.phase') }}</label>
                <input class="form-control {{ $errors->has('phase') ? 'is-invalid' : '' }}" type="text" name="phase" id="phase" value="{{ old('phase', $serviceItem->phase) }}">
                @if($errors->has('phase'))
                    <span class="text-danger">{{ $errors->first('phase') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceItem.fields.phase_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
