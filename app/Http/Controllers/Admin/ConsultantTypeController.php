<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyConsultantTypeRequest;
use App\Http\Requests\StoreConsultantTypeRequest;
use App\Http\Requests\UpdateConsultantTypeRequest;
use App\Models\ConsultantType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConsultantTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('consultant_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $consultantTypes = ConsultantType::all();

        return view('admin.consultantTypes.index', compact('consultantTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('consultant_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.consultantTypes.create');
    }

    public function store(StoreConsultantTypeRequest $request)
    {
        $consultantType = ConsultantType::create($request->all());

        return redirect()->route('admin.consultant-types.index');
    }

    public function edit(ConsultantType $consultantType)
    {
        abort_if(Gate::denies('consultant_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.consultantTypes.edit', compact('consultantType'));
    }

    public function update(UpdateConsultantTypeRequest $request, ConsultantType $consultantType)
    {
        $consultantType->update($request->all());

        return redirect()->route('admin.consultant-types.index');
    }

    public function show(ConsultantType $consultantType)
    {
        abort_if(Gate::denies('consultant_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $consultantType->load('consultantTypeConsultants');

        return view('admin.consultantTypes.show', compact('consultantType'));
    }

    public function destroy(ConsultantType $consultantType)
    {
        abort_if(Gate::denies('consultant_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $consultantType->delete();

        return back();
    }

    public function massDestroy(MassDestroyConsultantTypeRequest $request)
    {
        ConsultantType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
