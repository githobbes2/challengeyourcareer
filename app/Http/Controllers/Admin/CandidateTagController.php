<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCandidateTagRequest;
use App\Http\Requests\StoreCandidateTagRequest;
use App\Http\Requests\UpdateCandidateTagRequest;
use App\Models\CandidateTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CandidateTagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('candidate_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateTags = CandidateTag::all();

        return view('admin.candidateTags.index', compact('candidateTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('candidate_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidateTags.create');
    }

    public function store(StoreCandidateTagRequest $request)
    {
        $candidateTag = CandidateTag::create($request->all());

        return redirect()->route('admin.candidate-tags.index');
    }

    public function edit(CandidateTag $candidateTag)
    {
        abort_if(Gate::denies('candidate_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidateTags.edit', compact('candidateTag'));
    }

    public function update(UpdateCandidateTagRequest $request, CandidateTag $candidateTag)
    {
        $candidateTag->update($request->all());

        return redirect()->route('admin.candidate-tags.index');
    }

    public function show(CandidateTag $candidateTag)
    {
        abort_if(Gate::denies('candidate_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateTag->load('tagCandidates');

        return view('admin.candidateTags.show', compact('candidateTag'));
    }

    public function destroy(CandidateTag $candidateTag)
    {
        abort_if(Gate::denies('candidate_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyCandidateTagRequest $request)
    {
        CandidateTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
