<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyJobOfferTagRequest;
use App\Http\Requests\StoreJobOfferTagRequest;
use App\Http\Requests\UpdateJobOfferTagRequest;
use App\Models\JobOfferTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobOfferTagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('job_offer_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOfferTags = JobOfferTag::all();

        return view('admin.jobOfferTags.index', compact('jobOfferTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('job_offer_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jobOfferTags.create');
    }

    public function store(StoreJobOfferTagRequest $request)
    {
        $jobOfferTag = JobOfferTag::create($request->all());

        return redirect()->route('admin.job-offer-tags.index');
    }

    public function edit(JobOfferTag $jobOfferTag)
    {
        abort_if(Gate::denies('job_offer_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jobOfferTags.edit', compact('jobOfferTag'));
    }

    public function update(UpdateJobOfferTagRequest $request, JobOfferTag $jobOfferTag)
    {
        $jobOfferTag->update($request->all());

        return redirect()->route('admin.job-offer-tags.index');
    }

    public function show(JobOfferTag $jobOfferTag)
    {
        abort_if(Gate::denies('job_offer_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOfferTag->load('tagJobOffers');

        return view('admin.jobOfferTags.show', compact('jobOfferTag'));
    }

    public function destroy(JobOfferTag $jobOfferTag)
    {
        abort_if(Gate::denies('job_offer_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOfferTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobOfferTagRequest $request)
    {
        JobOfferTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
