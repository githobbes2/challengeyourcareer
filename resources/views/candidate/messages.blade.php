@extends('layouts.app-candidate')

@section('content')
<div class="section">
    <div class="card">
        <div class="card-header">{{ __('candidate.titles.communication') }}</div>
        <div class="card-body">
            <div class="row mb-1">
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#NewMessage">{{ trans('global.buttons.new_sign') }}</button>
                </div>
            </div>
            <div class="list-group messages-list">
                @forelse($topics as $topic)
                    <div class="row list-group-item {{ $topic->hasUnreads() ? 'list-group-item-new' : '' }} d-flex">
                        <div class="col-lg-4">
                            <a href="{{ route('admin.messenger.showMessages', [$topic->id]) }}">
                                @php($receiverOrCreator = $topic->receiverOrCreator())
                                    @if($topic->hasUnreads())
                                        <strong>{{ $receiverOrCreator !== null ? $receiverOrCreator->name : '' }} (nuevo)</strong>
                                    @else
                                        {{ $receiverOrCreator !== null ? $receiverOrCreator->name : '' }}
                                    @endif
                            </a>
                        </div>
                        <div class="col-lg-5">
                            <a href="{{ route('admin.messenger.showMessages', [$topic->id]) }}" class="font-italic">
                                @if($topic->hasUnreads())
                                    <strong>{{ $topic->subject }}</strong>
                                @else
                                    {{ $topic->subject }}
                                @endif
                            </a>
                        </div>
                        <div class="col-lg-2 text-right small">{{ $topic->created_at->diffForHumans() }}</div>
                        <div class="col-lg-1 text-right">
                            <form action="{{ route('admin.messenger.destroyTopic', [$topic->id]) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                <input type="hidden" name="_method" value="DELETE">
                                @csrf
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.messenger.showMessages', [$topic->id]) }}">{{ trans('global.view') }}</a>
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="row list-group-item">
                        {{ trans('global.you_have_no_messages') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- New Message -->
<div class="modal fade modalbox" id="NewMessage" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('global.new_message') }}</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
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
                                <a href="javascript:;" data-dismiss="modal" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- * New Message -->
@endsection
