<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPollCandidateRequest;
use App\Http\Requests\StorePollCandidateRequest;
use App\Http\Requests\UpdatePollCandidateRequest;
use App\Models\Candidate;
use App\Models\CandidateProgram;
use App\Models\City;
use App\Models\EducationLevel;
use App\Models\FunctionalArea;
use App\Models\Language;
use App\Models\Poll;
use App\Models\PollCandidate;
use App\Models\ProfessionalLevel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PollCandidateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('poll_candidate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollCandidates = PollCandidate::with(['poll', 'candidate', 'city', 'professional_level', 'languages', 'educational_level', 'functional_area', 'candidate_program'])->get();

        return view('admin.pollCandidates.index', compact('pollCandidates'));
    }

    public function create()
    {
        abort_if(Gate::denies('poll_candidate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $polls = Poll::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::pluck('name', 'id');

        $educational_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidate_programs = CandidateProgram::pluck('program_end_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.pollCandidates.create', compact('candidate_programs', 'candidates', 'cities', 'educational_levels', 'functional_areas', 'languages', 'polls', 'professional_levels'));
    }

    public function store(StorePollCandidateRequest $request)
    {
        $pollCandidate = PollCandidate::create($request->all());
        $pollCandidate->languages()->sync($request->input('languages', []));

        return redirect()->route('admin.poll-candidates.index');
    }

    public function edit(PollCandidate $pollCandidate)
    {
        abort_if(Gate::denies('poll_candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $polls = Poll::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::pluck('name', 'id');

        $educational_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidate_programs = CandidateProgram::pluck('program_end_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pollCandidate->load('poll', 'candidate', 'city', 'professional_level', 'languages', 'educational_level', 'functional_area', 'candidate_program');

        return view('admin.pollCandidates.edit', compact('candidate_programs', 'candidates', 'cities', 'educational_levels', 'functional_areas', 'languages', 'pollCandidate', 'polls', 'professional_levels'));
    }

    public function update(UpdatePollCandidateRequest $request, PollCandidate $pollCandidate)
    {
        $pollCandidate->update($request->all());
        $pollCandidate->languages()->sync($request->input('languages', []));

        return redirect()->route('admin.poll-candidates.index');
    }

    public function show(PollCandidate $pollCandidate)
    {
        abort_if(Gate::denies('poll_candidate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollCandidate->load('poll', 'candidate', 'city', 'professional_level', 'languages', 'educational_level', 'functional_area', 'candidate_program');

        return view('admin.pollCandidates.show', compact('pollCandidate'));
    }

    public function destroy(PollCandidate $pollCandidate)
    {
        abort_if(Gate::denies('poll_candidate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollCandidate->delete();

        return back();
    }

    public function massDestroy(MassDestroyPollCandidateRequest $request)
    {
        PollCandidate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
