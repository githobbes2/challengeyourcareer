@extends('admin.messenger.template')

@section('title', $topic->subject)

@section('messenger-content')
<div class="row">
    <div class="col-12 mb-3">
        @if($topic->receiverOrCreator() !== null && !$topic->receiverOrCreator()->trashed())
            <a href="{{ route('admin.messenger.reply', [$topic->id]) }}" class="btn btn-primary float-right">{{ trans('global.reply') }}</a>
        @endif
    </div>
    <div class="col-12">
        <div class="list-group">
            @foreach($topic->messages as $message)
                <div class="row list-group-item {{ $newMessageID == $message->id ? 'list-group-item-success' : '' }}">
                    <div class="row">
                        <div class="col col-lg-10">
                            <strong>{{ $message->sender_id == \Auth::user()->id ? 'Yo' : $message->sender->name }}</strong>
                            {{ $newMessageID == $message->id ? '(nuevo mensaje)' : '' }}
                        </div>
                        <div class="col col-lg-2 small">
                            {{ $message->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col col-lg-12 font-italic ml-2">
                            {!! nl2br($message->content) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
