@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.question.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('question_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.questions.edit', $question->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.question.fields.name') }}</th>
                        <td>{{ $question->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.question.fields.development_area') }}</th>
                        <td>{{ $question->development_area->name ?? '' }}</td>
                    </tr>
                    @for ($i=1; $i <= 5; $i++)
                    <tr>
                        <th>{{ trans('cruds.question.fields.score') }} {{ $i }}</th>
                        <td>
                            <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="200">{{ trans('cruds.question.fields.points') }}</th>
                                    <td>{{ $question['points_' . $i] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('cruds.question.fields.session_types') }}</th>
                                    <td>
                                        @foreach($question->score_session_type as $key => $session_types)
                                            @if($session_types->pivot->score == $i)
                                            <span class="badge badge-info">{{ $session_types->name }}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('cruds.question.fields.experience_points') }}</th>
                                    <td>{{ $question['experience_points_' . $i] }}</td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            <div class="form-group">
                @can('question_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.questions.edit', $question->id) }}">{{ trans('global.edit') }}</a>
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
            <a class="nav-link" href="#questions_question_groups" role="tab" data-toggle="tab">
                {{ trans('cruds.questionGroup.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="questions_question_groups">
            @includeIf('admin.questions.relationships.questionsQuestionGroups', ['questionGroups' => $question->questionsQuestionGroups])
        </div>
    </div>
</div>

@endsection
