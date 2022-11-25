@extends('admin.messenger.template')

@section('title', trans('global.new_message'))

@section('messenger-content')
<div class="row">
    <div class="col-md-12">
        <h3>{{ trans('global.new_message') }}</h3>
        <form action="{{ route("admin.messenger.storeTopic") }}" method="POST">
            @csrf
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="recipient" class="control-label required">{{ trans('global.recipient') }}</label>
                            <select name="recipient" class="form-control" required>
                                <option value="">- Seleccionar -</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="subject" class="control-label required">{{ trans('global.subject') }}</label>
                            <input type="text" name="subject" class="form-control" required />
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="content" class="control-label required">{{ trans('global.content') }}</label>
                            <textarea name="content" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.send') }}</button>
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
