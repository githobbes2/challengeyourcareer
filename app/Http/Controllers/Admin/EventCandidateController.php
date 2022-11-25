<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventCandidateRequest;
use App\Http\Requests\StoreEventCandidateRequest;
use App\Http\Requests\UpdateEventCandidateRequest;
use App\Models\Candidate;
use App\Models\Event;
use App\Models\EventCandidate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventCandidateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_candidate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventCandidates = EventCandidate::with(['event', 'candidate'])->get();

        return view('admin.eventCandidates.index', compact('eventCandidates'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_candidate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('admin.eventCandidates.create', compact('candidates', 'events'));
    }

    public function store(StoreEventCandidateRequest $request)
    {
        $eventCandidate = EventCandidate::create($request->all());

        return redirect()->route('admin.event-candidates.index');
    }

    public function edit(EventCandidate $eventCandidate)
    {
        abort_if(Gate::denies('event_candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $eventCandidate->load('event', 'candidate');

        return view('admin.eventCandidates.edit', compact('candidates', 'eventCandidate', 'events'));
    }

    public function update(UpdateEventCandidateRequest $request, EventCandidate $eventCandidate)
    {
        $eventCandidate->update($request->all());

        return redirect()->route('admin.event-candidates.index');
    }

    public function show(EventCandidate $eventCandidate)
    {
        abort_if(Gate::denies('event_candidate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventCandidate->load('event', 'candidate');

        return view('admin.eventCandidates.show', compact('eventCandidate'));
    }

    public function destroy(EventCandidate $eventCandidate)
    {
        abort_if(Gate::denies('event_candidate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventCandidate->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventCandidateRequest $request)
    {
        EventCandidate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
