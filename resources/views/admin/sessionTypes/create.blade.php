@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sessionType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.session-types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.sessionType.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionType.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.sessionType.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionType.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('score_required') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="score_required" id="score_required" value="1" required {{ old('score_required', 0) == 1 || old('score_required') === null ? 'checked' : '' }}>
                    <label class="required form-check-label" for="score_required">{{ trans('cruds.sessionType.fields.score_required') }}</label>
                </div>
                @if($errors->has('score_required'))
                    <span class="text-danger">{{ $errors->first('score_required') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionType.fields.score_required_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
