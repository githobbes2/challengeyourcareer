@extends('layouts.app-candidate')

@section('content')
<div class="section">
<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body">
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css'/>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body">
                <h2 class="mb-2">Eventos</h2>
                <div class="row">
                    @forelse($eventsList as $key => $event)
                    <div class="col-md-6">
                    <div class="card mb-1">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        @if($event->user_id)
                        <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="person-outline"></ion-icon> {{ $event->name ?? '' }}</h6>
                        @endif
                        <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="calendar-outline"></ion-icon> {{ $event->start_time ?? '' }}</h6>

                        @can('event_show')
                        <a class="btn btn-xs btn-primary float-right" href="{{ route('admin.candidate.event.show', $event->id) }}">{{ trans('global.details') }}</a>
                        @endcan
                    </div>
                    </div>
                    </div>
                    @empty
                    <div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
@parent
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.min.js'></script>
<script>
    $(document).ready(function () {
        events={!! json_encode($events) !!};

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: '{{ Config::get('app.locale') }}',
            initialView: 'dayGridMonth',
            headerToolbar: {
                right: '',
                center: 'title',
                left: 'prev,next dayGridMonth,timeGridWeek,timeGridDay today'
            },
            events: events,
        });
        calendar.render();

        $('.fc-toolbar.fc-header-toolbar').addClass('row col-lg-12');
        $('.fc-header-toolbar').css("width", "inherit");
        $('.fc-toolbar-chunk').css("margin", "auto");
        $('.fc-toolbar-chunk').css("width", "100%");
        $('.fc-toolbar-chunk').css("text-align", "center");
    });
</script>
@endsection
