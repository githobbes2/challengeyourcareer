<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuestionGroupRequest;
use App\Http\Requests\StoreQuestionGroupRequest;
use App\Http\Requests\UpdateQuestionGroupRequest;
use App\Models\Question;
use App\Models\QuestionGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionGroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('question_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionGroups = QuestionGroup::with(['questions'])->get();

        return view('admin.questionGroups.index', compact('questionGroups'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::pluck('name', 'id');

        return view('admin.questionGroups.create', compact('questions'));
    }

    public function store(StoreQuestionGroupRequest $request)
    {
        $questionGroup = QuestionGroup::create($request->all());
        $questionGroup->questions()->sync($request->input('questions', []));

        return redirect()->route('admin.question-groups.index');
    }

    public function edit(QuestionGroup $questionGroup)
    {
        abort_if(Gate::denies('question_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::pluck('name', 'id');

        $questionGroup->load('questions');

        return view('admin.questionGroups.edit', compact('questionGroup', 'questions'));
    }

    public function update(UpdateQuestionGroupRequest $request, QuestionGroup $questionGroup)
    {
        $questionGroup->update($request->all());
        $questionGroup->questions()->sync($request->input('questions', []));

        return redirect()->route('admin.question-groups.index');
    }

    public function show(QuestionGroup $questionGroup)
    {
        abort_if(Gate::denies('question_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionGroup->load('questions', 'questionGroupPolls');

        return view('admin.questionGroups.show', compact('questionGroup'));
    }

    public function destroy(QuestionGroup $questionGroup)
    {
        abort_if(Gate::denies('question_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionGroup->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuestionGroupRequest $request)
    {
        QuestionGroup::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
