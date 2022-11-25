@extends('admin.messenger.template')

@section('title', trans('global.reply'))

@section('messenger-content')
<div class="row">
    <div class="col-lg-12">
        <h3>{{ trans('global.reply') }}</h3>
        <form action="{{ route("admin.messenger.reply", [$topic->id]) }}" method="POST">
            @csrf
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            {{ trans('global.recipient') }}: <em>{{ $receiver }}</em>
                        </div>
                        <div class="col-lg-12 form-group">
                            {{ trans('global.subject') }}: <em>{{ $topic->subject }}</em>
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
