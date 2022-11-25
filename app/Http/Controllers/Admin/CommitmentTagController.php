<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCommitmentTagRequest;
use App\Http\Requests\StoreCommitmentTagRequest;
use App\Http\Requests\UpdateCommitmentTagRequest;
use App\Models\CommitmentTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommitmentTagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('commitment_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commitmentTags = CommitmentTag::all();

        return view('admin.commitmentTags.index', compact('commitmentTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('commitment_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commitmentTags.create');
    }

    public function store(StoreCommitmentTagRequest $request)
    {
        $commitmentTag = CommitmentTag::create($request->all());

        return redirect()->route('admin.commitment-tags.index');
    }

    public function edit(CommitmentTag $commitmentTag)
    {
        abort_if(Gate::denies('commitment_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commitmentTags.edit', compact('commitmentTag'));
    }

    public function update(UpdateCommitmentTagRequest $request, CommitmentTag $commitmentTag)
    {
        $commitmentTag->update($request->all());

        return redirect()->route('admin.commitment-tags.index');
    }

    public function show(CommitmentTag $commitmentTag)
    {
        abort_if(Gate::denies('commitment_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commitmentTags.show', compact('commitmentTag'));
    }

    public function destroy(CommitmentTag $commitmentTag)
    {
        abort_if(Gate::denies('commitment_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commitmentTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommitmentTagRequest $request)
    {
        CommitmentTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
