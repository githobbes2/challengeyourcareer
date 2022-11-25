@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.serviceItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('service_item_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.service-items.edit', $serviceItem->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.serviceItem.fields.type') }}</th>
                        <td>{{ App\Models\ServiceItem::TYPE_RADIO[$serviceItem->type] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.serviceItem.fields.service_type') }}</th>
                        <td>{{ $serviceItem->service_type->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.serviceItem.fields.name') }}</th>
                        <td>{{ $serviceItem->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.serviceItem.fields.description') }}</th>
                        <td>{{ $serviceItem->description }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.serviceItem.fields.objective') }}</th>
                        <td>{{ $serviceItem->objective }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.serviceItem.fields.phase') }}</th>
                        <td>{{ $serviceItem->phase }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('service_item_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.service-items.edit', $serviceItem->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#service_items_service_groups" role="tab" data-toggle="tab">
                {{ trans('cruds.serviceGroup.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="service_items_service_groups">
            @includeIf('admin.serviceItems.relationships.serviceItemsServiceGroups', ['serviceGroups' => $serviceItem->serviceItemsServiceGroups])
        </div>
    </div>
</div>

@endsection
