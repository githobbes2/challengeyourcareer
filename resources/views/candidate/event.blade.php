@extends('layouts.app-candidate')

@section('content')
<div class="section">
<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body">
                <h3 class="mb-2 text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#EditAttendance">{{ trans('global.attendance') }}</button>
                    {{ $event->title }}
                </h3>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">Responsable</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $event->user->name ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('global.date') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $event->start_time }} ({{ $event->duration . ' ' . trans('global.minutes_short') }})</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('global.attendance') }}</p></div>
                    <div class="col-md-8">
                    @if($attendance === '1')
                        <ion-icon class="text-success h3 m-0" name="checkmark-outline"></ion-icon>
                        @else
                        <p class="text-muted mb-0"><em>- sin asistencia -</em></p>
                        @endif
                    </div>
                </div>
                @if($event->description)
                <hr>
                <div class="row">
                    <div class="col-12">{!! $event->description !!}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<!-- Edit Event Attendance -->
<div class="modal fade modalbox" id="EditAttendance" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asistencia al evento</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route("admin.events.updateAttendance", [$event->id]) }}">
                    @csrf
                    <div class="card card-default">
                        <div class="card-body">

                            <h3 class="mb-2 text-center">{{ $event->title }}</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-4"><p class="mb-0">{{ trans('global.date') }}</p></div>
                                <div class="col-md-8"><p class="text-muted mb-0">{{ $event->start_time }}</p></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4"><p class="mb-0">{{ trans('global.attendance') }}</p></div>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="attendance_1" name="attendance" value="1" {{ old('attendance', $attendance) === '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="attendance_1">Sí asistí al evento</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="attendance_0" name="attendance" value="0" {{ old('attendance', $attendance) === '0' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="attendance_0">No he asistido al evento</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                                <a href="javascript:;" data-dismiss="modal" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- * Edit Event Attendance -->
@endsection
