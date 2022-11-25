<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProgramTypeRequest;
use App\Http\Requests\StoreProgramTypeRequest;
use App\Http\Requests\UpdateProgramTypeRequest;
use App\Models\ProgramType;
use App\Models\ServiceGroup;
use App\Models\SessionType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgramTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('program_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $programTypes = ProgramType::with(['service_groups', 'session_types'])->get();

        return view('admin.programTypes.index', compact('programTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('program_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_groups = ServiceGroup::pluck('name', 'id');

        $session_types = SessionType::pluck('name', 'id');

        return view('admin.programTypes.create', compact('service_groups', 'session_types'));
    }

    public function store(StoreProgramTypeRequest $request)
    {
        $programType = ProgramType::create($request->all());
        $programType->service_groups()->sync($request->input('service_groups', []));
        $programType->session_types()->sync($request->input('session_types', []));

        return redirect()->route('admin.program-types.index');
    }

    public function edit(ProgramType $programType)
    {
        abort_if(Gate::denies('program_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_groups = ServiceGroup::pluck('name', 'id');

        $session_types = SessionType::pluck('name', 'id');

        $programType->load('service_groups', 'session_types');

        return view('admin.programTypes.edit', compact('programType', 'service_groups', 'session_types'));
    }

    public function update(UpdateProgramTypeRequest $request, ProgramType $programType)
    {
        $programType->update($request->all());
        $programType->service_groups()->sync($request->input('service_groups', []));
        $programType->session_types()->sync($request->input('session_types', []));

        return redirect()->route('admin.program-types.index');
    }

    public function show(ProgramType $programType)
    {
        abort_if(Gate::denies('program_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $programType->load('service_groups', 'session_types', 'programTypePrograms', 'programTypesEvents');

        return view('admin.programTypes.show', compact('programType'));
    }

    public function destroy(ProgramType $programType)
    {
        abort_if(Gate::denies('program_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $programType->delete();

        return back();
    }

    public function massDestroy(MassDestroyProgramTypeRequest $request)
    {
        ProgramType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
