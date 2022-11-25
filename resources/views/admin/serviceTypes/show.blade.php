@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.serviceType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">
                            {{ trans('cruds.serviceType.fields.code') }}
                        </th>
                        <td>
                            {{ $serviceType->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceType.fields.name') }}
                        </th>
                        <td>
                            {{ $serviceType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceType.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\ServiceType::TYPE_RADIO[$serviceType->type] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
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
            <a class="nav-link" href="#service_type_service_items" role="tab" data-toggle="tab">
                {{ trans('cruds.serviceItem.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="service_type_service_items">
            @includeIf('admin.serviceTypes.relationships.serviceTypeServiceItems', ['serviceItems' => $serviceType->serviceTypeServiceItems])
        </div>
    </div>
</div>

@endsection
