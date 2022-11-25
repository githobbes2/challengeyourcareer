<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDevelopmentAreaRequest;
use App\Http\Requests\StoreDevelopmentAreaRequest;
use App\Http\Requests\UpdateDevelopmentAreaRequest;
use App\Models\DevelopmentArea;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DevelopmentAreasController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('development_area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $developmentAreas = DevelopmentArea::all();

        return view('admin.developmentAreas.index', compact('developmentAreas'));
    }

    public function create()
    {
        abort_if(Gate::denies('development_area_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.developmentAreas.create');
    }

    public function store(StoreDevelopmentAreaRequest $request)
    {
        $developmentArea = DevelopmentArea::create($request->all());

        return redirect()->route('admin.development-areas.index');
    }

    public function edit(DevelopmentArea $developmentArea)
    {
        abort_if(Gate::denies('development_area_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.developmentAreas.edit', compact('developmentArea'));
    }

    public function update(UpdateDevelopmentAreaRequest $request, DevelopmentArea $developmentArea)
    {
        $developmentArea->update($request->all());

        return redirect()->route('admin.development-areas.index');
    }

    public function show(DevelopmentArea $developmentArea)
    {
        abort_if(Gate::denies('development_area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.developmentAreas.show', compact('developmentArea'));
    }

    public function destroy(DevelopmentArea $developmentArea)
    {
        abort_if(Gate::denies('development_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $developmentArea->delete();

        return back();
    }

    public function massDestroy(MassDestroyDevelopmentAreaRequest $request)
    {
        DevelopmentArea::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
