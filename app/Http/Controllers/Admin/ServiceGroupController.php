<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceGroupRequest;
use App\Http\Requests\StoreServiceGroupRequest;
use App\Http\Requests\UpdateServiceGroupRequest;
use App\Models\ServiceGroup;
use App\Models\ServiceItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceGroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceGroups = ServiceGroup::with(['service_items'])->get();

        return view('admin.serviceGroups.index', compact('serviceGroups'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_items = ServiceItem::pluck('name', 'id');

        return view('admin.serviceGroups.create', compact('service_items'));
    }

    public function store(StoreServiceGroupRequest $request)
    {
        $serviceGroup = ServiceGroup::create($request->all());
        $serviceGroup->service_items()->sync($request->input('service_items', []));

        return redirect()->route('admin.service-groups.index');
    }

    public function edit(ServiceGroup $serviceGroup)
    {
        abort_if(Gate::denies('service_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_items = ServiceItem::pluck('name', 'id');

        $serviceGroup->load('service_items');

        return view('admin.serviceGroups.edit', compact('serviceGroup', 'service_items'));
    }

    public function update(UpdateServiceGroupRequest $request, ServiceGroup $serviceGroup)
    {
        $serviceGroup->update($request->all());
        $serviceGroup->service_items()->sync($request->input('service_items', []));

        return redirect()->route('admin.service-groups.index');
    }

    public function show(ServiceGroup $serviceGroup)
    {
        abort_if(Gate::denies('service_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceGroup->load('service_items', 'serviceGroupsProgramTypes');

        return view('admin.serviceGroups.show', compact('serviceGroup'));
    }

    public function destroy(ServiceGroup $serviceGroup)
    {
        abort_if(Gate::denies('service_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceGroup->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceGroupRequest $request)
    {
        ServiceGroup::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
