<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuestionRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\DevelopmentArea;
use App\Models\Question;
use App\Models\SessionType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::with(['development_area'])->get();

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $session_types = SessionType::pluck('name', 'id');

        $development_areas = DevelopmentArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.questions.create', compact('development_areas', 'session_types'));
    }

    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->all());
        for($i=1; $i <= 5; $i++) {
            $sessions  = $request->input('session_types_' . $i, []);
            $question->score_session_type()->attach($sessions, ['score' => $i]);
        }

        return redirect()->route('admin.questions.index');
    }

    public function edit(Question $question)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $session_types = SessionType::pluck('name', 'id');

        $development_areas = DevelopmentArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $question->load('score_session_type', 'development_area');

        $score_session_types_arr = array();
        foreach($question->score_session_type as $key => $lcl_session_types) {
            if (array_key_exists($lcl_session_types->pivot->score, $score_session_types_arr)) {
                array_push($score_session_types_arr[$lcl_session_types->pivot->score], $lcl_session_types->pivot->session_type_id);
            } else {
                $score_session_types_arr[$lcl_session_types->pivot->score] = array($lcl_session_types->pivot->session_type_id);
            }
        }
        $score_session_types = $score_session_types_arr;

        return view('admin.questions.edit', compact('development_areas', 'question', 'session_types', 'score_session_types'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->all());

        $question->score_session_type()->detach();
        for($i=1; $i <= 5; $i++) {
            $sessions  = $request->input('session_types_' . $i, []);
            $question->score_session_type()->attach($sessions, ['score' => $i]);
        }

        return redirect()->route('admin.questions.index');
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->load('score_session_type', 'development_area', 'questionsQuestionGroups');

        return view('admin.questions.show', compact('question'));
    }

    public function destroy(Question $question)
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuestionRequest $request)
    {
        Question::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
