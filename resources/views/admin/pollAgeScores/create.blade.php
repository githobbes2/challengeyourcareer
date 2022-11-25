@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pollAgeScore.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.poll-age-scores.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.pollAgeScore.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollAgeScore.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="order">{{ trans('cruds.pollAgeScore.fields.order') }}</label>
                <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" name="order" id="order" value="{{ old('order', '') }}" step="1">
                @if($errors->has('order'))
                    <span class="text-danger">{{ $errors->first('order') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollAgeScore.fields.order_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="age_start">{{ trans('cruds.pollAgeScore.fields.age_start') }}</label>
                <input class="form-control {{ $errors->has('age_start') ? 'is-invalid' : '' }}" type="number" name="age_start" id="age_start" value="{{ old('age_start', '') }}" step="1">
                @if($errors->has('age_start'))
                    <span class="text-danger">{{ $errors->first('age_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollAgeScore.fields.age_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_range">{{ trans('cruds.pollAgeScore.fields.end_range') }}</label>
                <input class="form-control {{ $errors->has('end_range') ? 'is-invalid' : '' }}" type="number" name="end_range" id="end_range" value="{{ old('end_range', '') }}" step="1">
                @if($errors->has('end_range'))
                    <span class="text-danger">{{ $errors->first('end_range') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollAgeScore.fields.end_range_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="professional_levels">{{ trans('cruds.pollAgeScore.fields.professional_levels') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('professional_levels') ? 'is-invalid' : '' }}" name="professional_levels[]" id="professional_levels" multiple>
                    @foreach($professional_levels as $id => $professional_level)
                        <option value="{{ $id }}" {{ in_array($id, old('professional_levels', [])) ? 'selected' : '' }}>{{ $professional_level }}</option>
                    @endforeach
                </select>
                @if($errors->has('professional_levels'))
                    <span class="text-danger">{{ $errors->first('professional_levels') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollAgeScore.fields.professional_levels_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
