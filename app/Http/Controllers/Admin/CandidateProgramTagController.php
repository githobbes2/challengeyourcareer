<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCandidateProgramTagRequest;
use App\Http\Requests\StoreCandidateProgramTagRequest;
use App\Http\Requests\UpdateCandidateProgramTagRequest;
use App\Models\CandidateProgramTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CandidateProgramTagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('candidate_program_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateProgramTags = CandidateProgramTag::all();

        return view('admin.candidateProgramTags.index', compact('candidateProgramTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('candidate_program_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidateProgramTags.create');
    }

    public function store(StoreCandidateProgramTagRequest $request)
    {
        $candidateProgramTag = CandidateProgramTag::create($request->all());

        return redirect()->route('admin.candidate-program-tags.index');
    }

    public function edit(CandidateProgramTag $candidateProgramTag)
    {
        abort_if(Gate::denies('candidate_program_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidateProgramTags.edit', compact('candidateProgramTag'));
    }

    public function update(UpdateCandidateProgramTagRequest $request, CandidateProgramTag $candidateProgramTag)
    {
        $candidateProgramTag->update($request->all());

        return redirect()->route('admin.candidate-program-tags.index');
    }

    public function show(CandidateProgramTag $candidateProgramTag)
    {
        abort_if(Gate::denies('candidate_program_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidateProgramTags.show', compact('candidateProgramTag'));
    }

    public function destroy(CandidateProgramTag $candidateProgramTag)
    {
        abort_if(Gate::denies('candidate_program_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateProgramTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyCandidateProgramTagRequest $request)
    {
        CandidateProgramTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
