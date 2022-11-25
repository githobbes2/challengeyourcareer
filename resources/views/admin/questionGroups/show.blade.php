@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.questionGroup.title') }}
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
                            {{ trans('cruds.questionGroup.fields.name') }}
                        </th>
                        <td>
                            {{ $questionGroup->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionGroup.fields.order') }}
                        </th>
                        <td>
                            {{ $questionGroup->order }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionGroup.fields.weight') }}
                        </th>
                        <td>
                            {{ $questionGroup->weight }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionGroup.fields.questions') }}
                        </th>
                        <td>
                            @foreach($questionGroup->questions as $key => $questions)
                                <span class="badge badge-info">{{ $questions->name }}</span>
                            @endforeach
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
            <a class="nav-link" href="#question_group_polls" role="tab" data-toggle="tab">
                {{ trans('cruds.poll.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="question_group_polls">
            @includeIf('admin.questionGroups.relationships.questionGroupPolls', ['polls' => $questionGroup->questionGroupPolls])
        </div>
    </div>
</div>

@endsection
