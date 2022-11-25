@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.consultant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('consultant_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.consultants.edit', $consultant->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('global.name') }}</th>
                        <td>{{ $consultant->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.consultant.fields.consultant_type') }}</th>
                        <td>{{ $consultant->consultant_type->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.consultant.fields.office') }}</th>
                        <td>{{ $consultant->office->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.consultant.fields.profile') }}</th>
                        <td>
                            {!! $consultant->profile !!}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.consultant.fields.session_skills') }}</th>
                        <td>{{ $consultant->session_skills }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.consultant.fields.skill_tags') }}</th>
                        <td>
                            @foreach($consultant->skill_tags as $key => $skill_tags)
                                <span class="badge badge-info">{{ $skill_tags->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.consultant.fields.challenge_card') }}</th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $consultant->challenge_card ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.consultant.fields.url_linkedin') }}</th>
                        <td>{{ $consultant->url_linkedin }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('consultant_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.consultants.edit', $consultant->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
