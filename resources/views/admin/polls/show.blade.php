@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.poll.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('poll_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.polls.edit', $poll->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.poll.fields.name') }}</th>
                        <td>{{ $poll->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.question_group') }}</th>
                        <td>
                            @foreach($poll->question_groups as $key => $question_group)
                                <span class="badge badge-info">{{ $question_group->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.label_1') }}</th>
                        <td>{{ $poll->label_1 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.label_2') }}</th>
                        <td>{{ $poll->label_2 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.label_3') }}</th>
                        <td>{{ $poll->label_3 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.label_4') }}</th>
                        <td>{{ $poll->label_4 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.label_5') }}</th>
                        <td>{{ $poll->label_5 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.use_age_score') }}</th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $poll->use_age_score ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.poll.fields.use_language_score') }}</th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $poll->use_language_score ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('poll_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.polls.edit', $poll->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
