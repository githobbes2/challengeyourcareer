@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sessionTemplate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.session-templates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.sessionTemplate.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionTemplate.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.sessionTemplate.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionTemplate.fields.description_helper') }}</span>
            </div>

            <div class="row">
                <div class="col-md-12"><h3>{{ trans('cruds.sessionTemplate.fields.items') }}</h3></div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label>{{ trans('cruds.sessionTemplate.fields.session_types') }}</label>
                </div>
                <div class="col-3">
                    <label>{{ trans('cruds.sessionTemplate.fields.session_quantity') }}</label>
                </div>
                <div class="col-3">
                    <label>{{ trans('cruds.sessionTemplate.fields.duration') }}</label>
                </div>
            </div>
            @for ($i=1; $i <= 12; $i++)
            <div class="row border-bottom mb-3">
                <div class="col-6">
                    <div class="form-group">
                        <select class="form-control select2 {{ $errors->has('session_type_' . $i) ? 'is-invalid' : '' }}" name="session_type_{{ $i }}" id="session_type_{{ $i }}">
                            @foreach($session_types as $id => $session_type)
                                <option value="{{ $id }}" {{ old('session_type_' . $i) == $id ? 'selected' : '' }}>{{ $session_type }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('session_type_' . $i))
                            <span class="text-danger">{{ $errors->first('session_type_' . $i) }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <input class="form-control {{ $errors->has('session_quantity_' . $i) ? 'is-invalid' : '' }}" type="number" name="session_quantity_{{ $i }}" id="session_quantity_{{ $i }}" value="{{ old('session_quantity_' . $i, '1') }}" step="1" min="1" max="20" required>
                        @if($errors->has('session_quantity_' . $i))
                            <span class="text-danger">{{ $errors->first('session_quantity_' . $i) }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <input class="form-control {{ $errors->has('session_duration_' . $i) ? 'is-invalid' : '' }}" type="number" name="session_duration_{{ $i }}" id="session_duration_{{ $i }}" value="{{ old('session_duration_' . $i, '60') }}" step="1" min="0" max="6000" required>
                        @if($errors->has('session_duration_' . $i))
                            <span class="text-danger">{{ $errors->first('session_duration_' . $i) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endfor

            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>
@endsection
