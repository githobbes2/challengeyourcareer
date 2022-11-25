@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.candidateService.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('candidate_service_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.candidate-services.edit', $candidateService->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.candidateService.fields.candidate') }}</th>
                        <td>{{ $candidateService->candidate->full_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateService.fields.service_item') }}</th>
                        <td>{{ $candidateService->service_item->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateService.fields.date_service') }}</th>
                        <td>{{ $candidateService->date_service }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateService.fields.user') }}</th>
                        <td>{{ $candidateService->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateService.fields.attendance') }}</th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $candidateService->attendance ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateService.fields.notes') }}</th>
                        <td>{{ $candidateService->notes }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateService.fields.candidate_program') }}</th>
                        <td>{{ $candidateService->candidate_program->program_start_date ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateService.fields.session_user') }}</th>
                        <td>{{ $candidateService->session_user->attendance ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('candidate_service_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.candidate-services.edit', $candidateService->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
