@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.city.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('city_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.cities.edit', $city->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.city.fields.name') }}</th>
                        <td>{{ $city->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.city.fields.state') }}</th>
                        <td>{{ $city->state->name ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('city_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.cities.edit', $city->id) }}">{{ trans('global.edit') }}</a>
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
            <a class="nav-link" href="#city_offices" role="tab" data-toggle="tab">
                {{ trans('cruds.office.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="city_offices">
            @includeIf('admin.cities.relationships.cityOffices', ['offices' => $city->cityOffices])
        </div>
    </div>
</div>

@endsection
