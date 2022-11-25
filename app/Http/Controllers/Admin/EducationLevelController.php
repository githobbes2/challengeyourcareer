<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEducationLevelRequest;
use App\Http\Requests\StoreEducationLevelRequest;
use App\Http\Requests\UpdateEducationLevelRequest;
use App\Models\EducationLevel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EducationLevelController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('education_level_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $educationLevels = EducationLevel::all();

        return view('admin.educationLevels.index', compact('educationLevels'));
    }

    public function create()
    {
        abort_if(Gate::denies('education_level_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.educationLevels.create');
    }

    public function store(StoreEducationLevelRequest $request)
    {
        $educationLevel = EducationLevel::create($request->all());

        return redirect()->route('admin.education-levels.index');
    }

    public function edit(EducationLevel $educationLevel)
    {
        abort_if(Gate::denies('education_level_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.educationLevels.edit', compact('educationLevel'));
    }

    public function update(UpdateEducationLevelRequest $request, EducationLevel $educationLevel)
    {
        $educationLevel->update($request->all());

        return redirect()->route('admin.education-levels.index');
    }

    public function show(EducationLevel $educationLevel)
    {
        abort_if(Gate::denies('education_level_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $educationLevel->load('educationalLevelJobOffers');

        return view('admin.educationLevels.show', compact('educationLevel'));
    }

    public function destroy(EducationLevel $educationLevel)
    {
        abort_if(Gate::denies('education_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $educationLevel->delete();

        return back();
    }

    public function massDestroy(MassDestroyEducationLevelRequest $request)
    {
        EducationLevel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
