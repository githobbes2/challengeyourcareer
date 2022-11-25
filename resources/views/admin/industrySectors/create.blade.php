@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.industrySector.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.industry-sectors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.industrySector.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.industrySector.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>



@endsection
