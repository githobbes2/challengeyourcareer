@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.question.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.questions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.question.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="development_area_id">{{ trans('cruds.question.fields.development_area') }}</label>
                <select class="form-control select2 {{ $errors->has('development_area') ? 'is-invalid' : '' }}" name="development_area_id" id="development_area_id">
                    @foreach($development_areas as $id => $entry)
                        <option value="{{ $id }}" {{ old('development_area_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('development_area'))
                    <span class="text-danger">{{ $errors->first('development_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.development_area_helper') }}</span>
            </div>

            @for ($i=1; $i <= 5; $i++)
            <div class="row">
                <div class="col-md-12"><h3>{{ trans('cruds.question.fields.score') }} {{ $i }}</h3></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="points_{{ $i }}">{{ trans('cruds.question.fields.points') }}</label>
                        <input class="form-control {{ $errors->has('points_' . $i) ? 'is-invalid' : '' }}" type="number" name="points_{{ $i }}" id="points_{{ $i }}" value="{{ old('points_' . $i, '0') }}" step="0.01" min="0" max="1">
                        @if($errors->has('points_' . $i))
                            <span class="text-danger">{{ $errors->first('points_' . $i) }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="session_types_{{ $i }}">{{ trans('cruds.question.fields.session_types') }}</label>
                        <select class="form-control select2 {{ $errors->has('session_types_' . $i) ? 'is-invalid' : '' }}" name="session_types_{{ $i }}[]" id="session_types_{{ $i }}" multiple>
                            @foreach($session_types as $id => $session_type)
                                <option value="{{ $id }}" {{ in_array($id, old('session_types_' . $i, [])) ? 'selected' : '' }}>{{ $session_type }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('session_types_' . $i))
                            <span class="text-danger">{{ $errors->first('session_types_' . $i) }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.session_types_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="experience_points_{{ $i }}">{{ trans('cruds.question.fields.experience_points') }}</label>
                        <input class="form-control {{ $errors->has('experience_points_' . $i) ? 'is-invalid' : '' }}" type="number" name="experience_points_{{ $i }}" id="experience_points_{{ $i }}" value="{{ old('experience_points_' . $i, '1') }}" step="1" min="0" max="100">
                        @if($errors->has('experience_points_' . $i))
                            <span class="text-danger">{{ $errors->first('experience_points_' . $i) }}</span>
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
