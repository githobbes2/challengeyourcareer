<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPollAgeScoreRequest;
use App\Http\Requests\StorePollAgeScoreRequest;
use App\Http\Requests\UpdatePollAgeScoreRequest;
use App\Models\PollAgeScore;
use App\Models\ProfessionalLevel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PollAgeScoreController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('poll_age_score_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollAgeScores = PollAgeScore::with(['professional_levels'])->get();

        return view('admin.pollAgeScores.index', compact('pollAgeScores'));
    }

    public function create()
    {
        abort_if(Gate::denies('poll_age_score_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $professional_levels = ProfessionalLevel::pluck('name', 'id');

        return view('admin.pollAgeScores.create', compact('professional_levels'));
    }

    public function store(StorePollAgeScoreRequest $request)
    {
        $pollAgeScore = PollAgeScore::create($request->all());
        $pollAgeScore->professional_levels()->sync($request->input('professional_levels', []));

        return redirect()->route('admin.poll-age-scores.index');
    }

    public function edit(PollAgeScore $pollAgeScore)
    {
        abort_if(Gate::denies('poll_age_score_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $professional_levels = ProfessionalLevel::pluck('name', 'id');

        $pollAgeScore->load('professional_levels');

        return view('admin.pollAgeScores.edit', compact('pollAgeScore', 'professional_levels'));
    }

    public function update(UpdatePollAgeScoreRequest $request, PollAgeScore $pollAgeScore)
    {
        $pollAgeScore->update($request->all());
        $pollAgeScore->professional_levels()->sync($request->input('professional_levels', []));

        return redirect()->route('admin.poll-age-scores.index');
    }

    public function show(PollAgeScore $pollAgeScore)
    {
        abort_if(Gate::denies('poll_age_score_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollAgeScore->load('professional_levels');

        return view('admin.pollAgeScores.show', compact('pollAgeScore'));
    }

    public function destroy(PollAgeScore $pollAgeScore)
    {
        abort_if(Gate::denies('poll_age_score_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollAgeScore->delete();

        return back();
    }

    public function massDestroy(MassDestroyPollAgeScoreRequest $request)
    {
        PollAgeScore::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
