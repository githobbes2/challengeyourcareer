<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPollLanguageScoreRequest;
use App\Http\Requests\StorePollLanguageScoreRequest;
use App\Http\Requests\UpdatePollLanguageScoreRequest;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\PollLanguageScore;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PollLanguageScoreController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('poll_language_score_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollLanguageScores = PollLanguageScore::with(['language', 'education_level'])->get();

        return view('admin.pollLanguageScores.index', compact('pollLanguageScores'));
    }

    public function create()
    {
        abort_if(Gate::denies('poll_language_score_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languages = Language::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $education_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.pollLanguageScores.create', compact('education_levels', 'languages'));
    }

    public function store(StorePollLanguageScoreRequest $request)
    {
        $pollLanguageScore = PollLanguageScore::create($request->all());

        return redirect()->route('admin.poll-language-scores.index');
    }

    public function edit(PollLanguageScore $pollLanguageScore)
    {
        abort_if(Gate::denies('poll_language_score_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languages = Language::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $education_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pollLanguageScore->load('language', 'education_level');

        return view('admin.pollLanguageScores.edit', compact('education_levels', 'languages', 'pollLanguageScore'));
    }

    public function update(UpdatePollLanguageScoreRequest $request, PollLanguageScore $pollLanguageScore)
    {
        $pollLanguageScore->update($request->all());

        return redirect()->route('admin.poll-language-scores.index');
    }

    public function show(PollLanguageScore $pollLanguageScore)
    {
        abort_if(Gate::denies('poll_language_score_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollLanguageScore->load('language', 'education_level');

        return view('admin.pollLanguageScores.show', compact('pollLanguageScore'));
    }

    public function destroy(PollLanguageScore $pollLanguageScore)
    {
        abort_if(Gate::denies('poll_language_score_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollLanguageScore->delete();

        return back();
    }

    public function massDestroy(MassDestroyPollLanguageScoreRequest $request)
    {
        PollLanguageScore::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
