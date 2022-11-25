@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.candidateCommitment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.candidateCommitment.fields.title') }}</th>
                        <td>{{ $candidateCommitment->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.candidate') }}</th>
                        <td>{{ $candidateCommitment->candidate->full_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.session_user') }}</th>
                        <td>{{ $candidateCommitment->session_user->session->title ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.complete') }}</th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $candidateCommitment->complete ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.completion_date') }}</th>
                        <td>{{ $candidateCommitment->completion_date }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.tag') }}</th>
                        <td>
                            @foreach($candidateCommitment->tags as $key => $tag)
                                <span class="badge badge-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.note') }}</th>
                        <td>{{ $candidateCommitment->note }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.comments') }}</th>
                        <td>{{ $candidateCommitment->comments }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.development_area') }}</th>
                        <td>{{ $candidateCommitment->development_area->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.candidateCommitment.fields.experience_points') }}</th>
                        <td>{{ $candidateCommitment->experience_points }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
