<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySkillTagRequest;
use App\Http\Requests\StoreSkillTagRequest;
use App\Http\Requests\UpdateSkillTagRequest;
use App\Models\SkillTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SkillTagsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('skill_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $skillTags = SkillTag::all();

        return view('admin.skillTags.index', compact('skillTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('skill_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.skillTags.create');
    }

    public function store(StoreSkillTagRequest $request)
    {
        $skillTag = SkillTag::create($request->all());

        return redirect()->route('admin.skill-tags.index');
    }

    public function edit(SkillTag $skillTag)
    {
        abort_if(Gate::denies('skill_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.skillTags.edit', compact('skillTag'));
    }

    public function update(UpdateSkillTagRequest $request, SkillTag $skillTag)
    {
        $skillTag->update($request->all());

        return redirect()->route('admin.skill-tags.index');
    }

    public function show(SkillTag $skillTag)
    {
        abort_if(Gate::denies('skill_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $skillTag->load('skillTagsConsultants');

        return view('admin.skillTags.show', compact('skillTag'));
    }

    public function destroy(SkillTag $skillTag)
    {
        abort_if(Gate::denies('skill_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $skillTag->delete();

        return back();
    }

    public function massDestroy(MassDestroySkillTagRequest $request)
    {
        SkillTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
