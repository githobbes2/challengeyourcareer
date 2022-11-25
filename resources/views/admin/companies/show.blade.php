@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.company.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('company_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.companies.edit', $company->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.company.fields.name') }}</th>
                        <td>{{ $company->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.tax_number') }}</th>
                        <td>{{ $company->tax_number }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.contact_name') }}</th>
                        <td>{{ $company->contact_name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.contact_phone') }}</th>
                        <td>{{ $company->contact_phone }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.contact_email') }}</th>
                        <td>{{ $company->contact_email }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.industry_sector') }}</th>
                        <td>{{ $company->industry_sector->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.country') }}</th>
                        <td>
                            @foreach($company->countries as $key => $country)
                                <span class="badge badge-info">{{ $country->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.notes') }}</th>
                        <td>{{ $company->notes }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.logo') }}</th>
                        <td>
                            @if($company->logo)
                                <a href="{{ $company->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $company->logo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.company.fields.attachments') }}</th>
                        <td>
                            @foreach($company->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('company_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.companies.edit', $company->id) }}">{{ trans('global.edit') }}</a>
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
        @if(!Auth::user()->is_consultant)
        <li class="nav-item">
            <a class="nav-link" href="#company_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="#company_programs" role="tab" data-toggle="tab">
                {{ trans('cruds.program.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#company_candidates" role="tab" data-toggle="tab">
                {{ trans('cruds.candidate.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#companies_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        @if(!Auth::user()->is_consultant)
        <div class="tab-pane" role="tabpanel" id="company_users">
            @includeIf('admin.companies.relationships.companyUsers', ['users' => $company->companyUsers])
        </div>
        @endif
        <div class="tab-pane" role="tabpanel" id="company_programs">
            @includeIf('admin.companies.relationships.companyPrograms', ['programs' => $company->companyPrograms])
        </div>
        <div class="tab-pane" role="tabpanel" id="company_candidates">
            @includeIf('admin.companies.relationships.companyCandidates', ['candidates' => $company->companyCandidates])
        </div>
        <div class="tab-pane" role="tabpanel" id="companies_events">
            @includeIf('admin.companies.relationships.companiesEvents', ['events' => $company->companiesEvents])
        </div>
    </div>
</div>

@endsection
