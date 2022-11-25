<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFunctionalAreaRequest;
use App\Http\Requests\StoreFunctionalAreaRequest;
use App\Http\Requests\UpdateFunctionalAreaRequest;
use App\Models\FunctionalArea;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FunctionalAreaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('functional_area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $functionalAreas = FunctionalArea::all();

        return view('admin.functionalAreas.index', compact('functionalAreas'));
    }

    public function create()
    {
        abort_if(Gate::denies('functional_area_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.functionalAreas.create');
    }

    public function store(StoreFunctionalAreaRequest $request)
    {
        $functionalArea = FunctionalArea::create($request->all());

        return redirect()->route('admin.functional-areas.index');
    }

    public function edit(FunctionalArea $functionalArea)
    {
        abort_if(Gate::denies('functional_area_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.functionalAreas.edit', compact('functionalArea'));
    }

    public function update(UpdateFunctionalAreaRequest $request, FunctionalArea $functionalArea)
    {
        $functionalArea->update($request->all());

        return redirect()->route('admin.functional-areas.index');
    }

    public function show(FunctionalArea $functionalArea)
    {
        abort_if(Gate::denies('functional_area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $functionalArea->load('functionalAreaJobOffers');

        return view('admin.functionalAreas.show', compact('functionalArea'));
    }

    public function destroy(FunctionalArea $functionalArea)
    {
        abort_if(Gate::denies('functional_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $functionalArea->delete();

        return back();
    }

    public function massDestroy(MassDestroyFunctionalAreaRequest $request)
    {
        FunctionalArea::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
