@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.skill.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('skill_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.skills.edit', $skill->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.skill.fields.name') }}</th>
                        <td>{{ $skill->name }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('skill_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.skills.edit', $skill->id) }}">{{ trans('global.edit') }}</a>
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
            <a class="nav-link" href="#skill_job_offers" role="tab" data-toggle="tab">
                {{ trans('cruds.jobOffer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="skill_job_offers">
            @includeIf('admin.skills.relationships.skillJobOffers', ['jobOffers' => $skill->skillJobOffers])
        </div>
    </div>
</div>

@endsection
