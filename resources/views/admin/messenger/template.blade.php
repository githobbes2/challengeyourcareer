@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.messages') }} - @yield('title')
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-xl-2">
                <p>
                    <a class="btn btn-primary" href="{{ route('admin.messenger.createTopic') }}">{{ trans('global.new_message') }}</a>
                </p>
                <div class="list-group">
                    <a href="{{ route('admin.messenger.index') }}" class="list-group-item {{ request()->is("admin/messenger") ? "active" : "" }}">{{ trans('global.all_messages') }}</a>
                    <a href="{{ route('admin.messenger.showInbox') }}" class="list-group-item {{ request()->is("admin/messenger/inbox") ? "active" : "" }}">
                        @if($unreads['inbox'] > 0)
                            <strong>{{ trans('global.inbox') }} ({{ $unreads['inbox'] }})</strong>
                        @else
                            {{ trans('global.inbox') }}
                        @endif
                    </a>
                    <a href="{{ route('admin.messenger.showOutbox') }}" class="list-group-item {{ request()->is("admin/messenger/outbox") ? "active" : "" }}">
                        @if($unreads['outbox'] > 0)
                            <strong>{{ trans('global.outbox') }} ({{ $unreads['outbox'] }})</strong>
                        @else
                            {{ trans('global.outbox') }}
                        @endif
                    </a>
                </div>
            </div>
            <div class="col-md-9 col-xl-10 mt-3 mt-md-0">
                @yield('messenger-content')
            </div>
        </div>
    </div>
</div>
@stop
