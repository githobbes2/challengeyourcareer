<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProfessionalLevelRequest;
use App\Http\Requests\StoreProfessionalLevelRequest;
use App\Http\Requests\UpdateProfessionalLevelRequest;
use App\Models\ProfessionalLevel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfessionalLevelController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('professional_level_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $professionalLevels = ProfessionalLevel::all();

        return view('admin.professionalLevels.index', compact('professionalLevels'));
    }

    public function create()
    {
        abort_if(Gate::denies('professional_level_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.professionalLevels.create');
    }

    public function store(StoreProfessionalLevelRequest $request)
    {
        $professionalLevel = ProfessionalLevel::create($request->all());

        return redirect()->route('admin.professional-levels.index');
    }

    public function edit(ProfessionalLevel $professionalLevel)
    {
        abort_if(Gate::denies('professional_level_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.professionalLevels.edit', compact('professionalLevel'));
    }

    public function update(UpdateProfessionalLevelRequest $request, ProfessionalLevel $professionalLevel)
    {
        $professionalLevel->update($request->all());

        return redirect()->route('admin.professional-levels.index');
    }

    public function show(ProfessionalLevel $professionalLevel)
    {
        abort_if(Gate::denies('professional_level_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $professionalLevel->load('professionalLevelJobOffers');

        return view('admin.professionalLevels.show', compact('professionalLevel'));
    }

    public function destroy(ProfessionalLevel $professionalLevel)
    {
        abort_if(Gate::denies('professional_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $professionalLevel->delete();

        return back();
    }

    public function massDestroy(MassDestroyProfessionalLevelRequest $request)
    {
        ProfessionalLevel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
