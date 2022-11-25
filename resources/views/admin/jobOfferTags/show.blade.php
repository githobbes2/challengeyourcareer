@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.jobOfferTag.title') }}
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
                            {{ trans('cruds.jobOfferTag.fields.name') }}
                        </th>
                        <td>
                            {{ $jobOfferTag->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOfferTag.fields.color') }}
                        </th>
                        <td>
                            {{ App\Models\JobOfferTag::COLOR_RADIO[$jobOfferTag->color] ?? '' }}
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
            <a class="nav-link" href="#tag_job_offers" role="tab" data-toggle="tab">
                {{ trans('cruds.jobOffer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="tag_job_offers">
            @includeIf('admin.jobOfferTags.relationships.tagJobOffers', ['jobOffers' => $jobOfferTag->tagJobOffers])
        </div>
    </div>
</div>

@endsection
