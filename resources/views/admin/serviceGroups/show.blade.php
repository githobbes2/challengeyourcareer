@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.serviceGroup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('service_group_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.service-groups.edit', $serviceGroup->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">
                            {{ trans('cruds.serviceGroup.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\ServiceGroup::TYPE_RADIO[$serviceGroup->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceGroup.fields.name') }}
                        </th>
                        <td>
                            {{ $serviceGroup->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceGroup.fields.service_items') }}
                        </th>
                        <td>
                            @foreach($serviceGroup->service_items as $key => $service_items)
                                <span class="badge badge-info">{{ $service_items->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('service_group_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.service-groups.edit', $serviceGroup->id) }}">{{ trans('global.edit') }}</a>
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
            <a class="nav-link" href="#service_groups_program_types" role="tab" data-toggle="tab">
                {{ trans('cruds.programType.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="service_groups_program_types">
            @includeIf('admin.serviceGroups.relationships.serviceGroupsProgramTypes', ['programTypes' => $serviceGroup->serviceGroupsProgramTypes])
        </div>
    </div>
</div>

@endsection
