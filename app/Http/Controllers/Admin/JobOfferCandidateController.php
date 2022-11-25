<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyJobOfferCandidateRequest;
use App\Http\Requests\StoreJobOfferCandidateRequest;
use App\Http\Requests\UpdateJobOfferCandidateRequest;
use App\Models\Candidate;
use App\Models\CandidateCurriculum;
use App\Models\JobOffer;
use App\Models\JobOfferCandidate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobOfferCandidateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('job_offer_candidate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOfferCandidates = JobOfferCandidate::with(['job_offer', 'candidate', 'curriculum'])->get();

        return view('admin.jobOfferCandidates.index', compact('jobOfferCandidates'));
    }

    public function create()
    {
        abort_if(Gate::denies('job_offer_candidate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job_offers = JobOffer::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $curricula = CandidateCurriculum::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.jobOfferCandidates.create', compact('candidates', 'curricula', 'job_offers'));
    }

    public function store(StoreJobOfferCandidateRequest $request)
    {
        $jobOfferCandidate = JobOfferCandidate::create($request->all());

        return redirect()->route('admin.job-offer-candidates.index');
    }

    public function edit(JobOfferCandidate $jobOfferCandidate)
    {
        abort_if(Gate::denies('job_offer_candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job_offers = JobOffer::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $curricula = CandidateCurriculum::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $jobOfferCandidate->load('job_offer', 'candidate', 'curriculum');

        return view('admin.jobOfferCandidates.edit', compact('candidates', 'curricula', 'jobOfferCandidate', 'job_offers'));
    }

    public function update(UpdateJobOfferCandidateRequest $request, JobOfferCandidate $jobOfferCandidate)
    {
        $jobOfferCandidate->update($request->all());

        return redirect()->route('admin.job-offer-candidates.index');
    }

    public function show(JobOfferCandidate $jobOfferCandidate)
    {
        abort_if(Gate::denies('job_offer_candidate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOfferCandidate->load('job_offer', 'candidate', 'curriculum');

        return view('admin.jobOfferCandidates.show', compact('jobOfferCandidate'));
    }

    public function destroy(JobOfferCandidate $jobOfferCandidate)
    {
        abort_if(Gate::denies('job_offer_candidate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOfferCandidate->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobOfferCandidateRequest $request)
    {
        JobOfferCandidate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
