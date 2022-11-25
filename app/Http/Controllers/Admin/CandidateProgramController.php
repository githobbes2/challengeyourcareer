<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCandidateProgramRequest;
use App\Http\Requests\StoreCandidateProgramRequest;
use App\Http\Requests\UpdateCandidateProgramRequest;
use App\Models\Candidate;
use App\Models\CandidateProgram;
use App\Models\CandidateProgramTag;
use App\Models\Company;
use App\Models\FunctionalArea;
use App\Models\IndustrySector;
use App\Models\ProfessionalLevel;
use App\Models\Program;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CandidateProgramController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('candidate_program_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidatePrograms = CandidateProgram::with(['candidate', 'program', 'functional_area', 'profesional_level', 'industry_sector'])->get();

        $candidates = Candidate::get();

        $programs = Program::get();

        //$candidate_program_tags = CandidateProgramTag::get();

        $companies = Company::get();

        $functional_areas = FunctionalArea::get();

        $professional_levels = ProfessionalLevel::get();

        $industry_sectors = IndustrySector::get();

        return view('admin.candidatePrograms.index', compact('candidatePrograms', 'candidates', 'companies', 'functional_areas', 'industry_sectors', 'professional_levels', 'programs'));
    }

    public function create($programID=null, $candidateID=null)
    {
        abort_if(Gate::denies('candidate_program_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($programID>0) {
            $programs = Program::find($programID)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            $programCandidates = CandidateProgram::select('candidate_id')->where('program_id', '=', $programID)->get();

            $candidates = \App\Models\User::select(DB::raw('CONCAT(users.name, \' \', COALESCE(users.lastname,\'\')) AS name'), 'candidates.id')
                ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
                ->join('candidates', 'candidates.user_id', '=', 'users.id')
                ->whereNotIn('candidates.id', $programCandidates->pluck('candidate_id')->toArray())
                ->orderBy('users.name')
                ->orderBy('users.lastname')
                ->get()
                ->pluck('name', 'id');
        } else {
            $programs = Program::select('name','internal_name', 'id')->orderBy('created_at', 'DESC')->get();

            if(!is_null($candidateID)) {
                $candidates = \App\Models\User::select(DB::raw('CONCAT(users.name, \' \', COALESCE(users.lastname,\'\')) AS name'), 'candidates.id')
                ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
                ->join('candidates', 'candidates.user_id', '=', 'users.id')
                ->where('candidates.id', '=', $candidateID)
                ->get()
                ->pluck('name', 'id');
            } else {
                $candidates = \App\Models\User::select(DB::raw('CONCAT(users.name, \' \', COALESCE(users.lastname,\'\')) AS name'), 'candidates.id')
                ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
                ->join('candidates', 'candidates.user_id', '=', 'users.id')
                ->orderBy('users.name')
                ->orderBy('users.lastname')
                ->get()
                ->pluck('name', 'id');
            }
        }

        //$tags = CandidateProgramTag::pluck('name', 'id');
        //$relocation_companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $profesional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        return view('admin.candidatePrograms.create', compact('referer', 'programID', 'candidateID', 'candidates', 'functional_areas', 'industry_sectors', 'profesional_levels', 'programs'));
    }

    public function store(StoreCandidateProgramRequest $request)
    {
        $referer = $request->input('referer');

        if (isset($request['candidate_id'])) {
            $candidateProgram = CandidateProgram::create($request->except(['referer']));
            //$candidateProgram->tags()->sync($request->input('tags', []));

            if(str_contains($referer, '/candidates/')) {
                return redirect()->route('admin.candidates.show', $request->input('candidate_id'));
            }
        } else {
            foreach ($request->input('candidates', []) as $candidate) {
                $request['candidate_id'] = $candidate;
                $candidateProgram = CandidateProgram::create($request->except(['candidates', 'referer']));
                //$candidateProgram->tags()->sync($request->input('tags', []));
            }
            if(str_contains($referer, '/programs/')) {
                return redirect()->route('admin.programs.show', $request->input('program_id'));
            }
        }

        return redirect()->route('admin.candidate-programs.index');
    }

    public function edit(CandidateProgram $candidateProgram)
    {
        abort_if(Gate::denies('candidate_program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = \App\Models\User::select(DB::raw('CONCAT(users.name, \' \', COALESCE(users.lastname,\'\')) AS name'), 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id');

        $programs = Program::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$tags = CandidateProgramTag::pluck('name', 'id');
        //$relocation_companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $profesional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $candidateProgram->load('candidate', 'program', 'functional_area', 'profesional_level', 'industry_sector');

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        return view('admin.candidatePrograms.edit', compact('referer', 'candidateProgram', 'candidates', 'functional_areas', 'industry_sectors', 'profesional_levels', 'programs'));
    }

    public function update(UpdateCandidateProgramRequest $request, CandidateProgram $candidateProgram)
    {
        $referer = $request->input('referer');

        $candidateProgram->update($request->except(['candidate_id', 'program_id']));
        //$candidateProgram->tags()->sync($request->input('tags', []));
        $candidateProgram->refresh();

        if(str_contains($referer, '/candidates/')) {
            return redirect()->route('admin.candidates.show', $candidateProgram->candidate_id);
        }
        if(str_contains($referer, '/programs/')) {
            return redirect()->route('admin.programs.show', $candidateProgram->program_id);
        }

        return redirect()->route('admin.home');
    }

    public function show(CandidateProgram $candidateProgram)
    {
        abort_if(Gate::denies('candidate_program_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateProgram->load('candidate', 'program', 'functional_area', 'profesional_level', 'industry_sector', 'candidateProgramCandidateServices', 'candidateProgramPollCandidates');

        return view('admin.candidatePrograms.show', compact('candidateProgram'));
    }

    public function destroy(CandidateProgram $candidateProgram)
    {
        abort_if(Gate::denies('candidate_program_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateProgram->delete();

        return back();
    }

    public function massDestroy(MassDestroyCandidateProgramRequest $request)
    {
        CandidateProgram::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
