<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIndustrySectorRequest;
use App\Http\Requests\StoreIndustrySectorRequest;
use App\Http\Requests\UpdateIndustrySectorRequest;
use App\Models\IndustrySector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IndustrySectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('industry_sector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $industrySectors = IndustrySector::all();

        return view('admin.industrySectors.index', compact('industrySectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('industry_sector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industrySectors.create');
    }

    public function store(StoreIndustrySectorRequest $request)
    {
        $industrySector = IndustrySector::create($request->all());

        return redirect()->route('admin.industry-sectors.index');
    }

    public function edit(IndustrySector $industrySector)
    {
        abort_if(Gate::denies('industry_sector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industrySectors.edit', compact('industrySector'));
    }

    public function update(UpdateIndustrySectorRequest $request, IndustrySector $industrySector)
    {
        $industrySector->update($request->all());

        return redirect()->route('admin.industry-sectors.index');
    }

    public function show(IndustrySector $industrySector)
    {
        abort_if(Gate::denies('industry_sector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $industrySector->load('industrySectorJobOffers', 'industrySectorCompanies');

        return view('admin.industrySectors.show', compact('industrySector'));
    }

    public function destroy(IndustrySector $industrySector)
    {
        abort_if(Gate::denies('industry_sector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $industrySector->delete();

        return back();
    }

    public function massDestroy(MassDestroyIndustrySectorRequest $request)
    {
        IndustrySector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
