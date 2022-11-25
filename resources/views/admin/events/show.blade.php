@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.event.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('event_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.events.edit', $event->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.event.fields.title') }}</th>
                        <td>{{ $event->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.user') }}</th>
                        <td>{{ $event->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.start_time') }}</th>
                        <td>{{ $event->start_time }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.duration') }}</th>
                        <td>{{ $event->duration }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.description') }}</th>
                        <td>
                            {!! $event->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.program_types') }}</th>
                        <td>
                            @foreach($event->program_types as $key => $program_types)
                                <span class="badge badge-info">{{ $program_types->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.companies') }}</th>
                        <td>
                            @foreach($event->companies as $key => $companies)
                                <span class="badge badge-info">{{ $companies->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.programs') }}</th>
                        <td>
                            @foreach($event->programs as $key => $programs)
                                <span class="badge badge-info">{{ $programs->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.development_area') }}</th>
                        <td>{{ $event->development_area->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.event.fields.experience_points') }}</th>
                        <td>{{ $event->experience_points }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('event_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.events.edit', $event->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#event_event_candidates" role="tab" data-toggle="tab">
                {{ trans('cruds.eventCandidate.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="event_event_candidates">
            @includeIf('admin.events.relationships.eventEventCandidates', ['eventCandidates' => $event->candidates])
        </div>
    </div>
</div>

@endsection
