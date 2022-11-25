@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.candidateProgramTag.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.candidate-program-tags.update", [$candidateProgramTag->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.candidateProgramTag.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $candidateProgramTag->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateProgramTag.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.candidateProgramTag.fields.color') }}</label>
                @foreach(App\Models\CandidateProgramTag::COLOR_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('color') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="color_{{ $key }}" name="color" value="{{ $key }}" {{ old('color', $candidateProgramTag->color) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="color_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('color'))
                    <span class="text-danger">{{ $errors->first('color') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidateProgramTag.fields.color_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
