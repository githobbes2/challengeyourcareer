@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pollCandidate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('poll_candidate_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.poll-candidates.edit', $pollCandidate->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">
                            {{ trans('cruds.pollCandidate.fields.poll') }}
                        </th>
                        <td>
                            {{ $pollCandidate->poll->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.candidate') }}
                        </th>
                        <td>
                            {{ $pollCandidate->candidate->full_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.score') }}
                        </th>
                        <td>
                            {{ $pollCandidate->score }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.experience_points') }}
                        </th>
                        <td>
                            {{ $pollCandidate->experience_points }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.age') }}
                        </th>
                        <td>
                            {{ $pollCandidate->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.company') }}
                        </th>
                        <td>
                            {{ $pollCandidate->company }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.city') }}
                        </th>
                        <td>
                            {{ $pollCandidate->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.professional_level') }}
                        </th>
                        <td>
                            {{ $pollCandidate->professional_level->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.languages') }}
                        </th>
                        <td>
                            @foreach($pollCandidate->languages as $key => $languages)
                                <span class="badge badge-info">{{ $languages->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.educational_level') }}
                        </th>
                        <td>
                            {{ $pollCandidate->educational_level->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.functional_area') }}
                        </th>
                        <td>
                            {{ $pollCandidate->functional_area->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.company_size') }}
                        </th>
                        <td>
                            {{ App\Models\PollCandidate::COMPANY_SIZE_RADIO[$pollCandidate->company_size] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.candidate_program') }}
                        </th>
                        <td>
                            {{ $pollCandidate->candidate_program->program_end_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.is_initial') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $pollCandidate->is_initial ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollCandidate.fields.is_final') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $pollCandidate->is_final ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('poll_candidate_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.poll-candidates.edit', $pollCandidate->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
