<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyServiceItemRequest;
use App\Http\Requests\StoreServiceItemRequest;
use App\Http\Requests\UpdateServiceItemRequest;
use App\Models\ServiceItem;
use App\Models\ServiceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceItemController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('service_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceItems = ServiceItem::with(['service_type'])->get();

        return view('admin.serviceItems.index', compact('serviceItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_types = ServiceType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.serviceItems.create', compact('service_types'));
    }

    public function store(StoreServiceItemRequest $request)
    {
        $serviceItem = ServiceItem::create($request->all());

        return redirect()->route('admin.service-items.index');
    }

    public function edit(ServiceItem $serviceItem)
    {
        abort_if(Gate::denies('service_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_types = ServiceType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $serviceItem->load('service_type');

        return view('admin.serviceItems.edit', compact('serviceItem', 'service_types'));
    }

    public function update(UpdateServiceItemRequest $request, ServiceItem $serviceItem)
    {
        $serviceItem->update($request->all());

        return redirect()->route('admin.service-items.index');
    }

    public function show(ServiceItem $serviceItem)
    {
        abort_if(Gate::denies('service_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceItem->load('service_type', 'serviceItemsServiceGroups');

        return view('admin.serviceItems.show', compact('serviceItem'));
    }

    public function destroy(ServiceItem $serviceItem)
    {
        abort_if(Gate::denies('service_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceItemRequest $request)
    {
        ServiceItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
