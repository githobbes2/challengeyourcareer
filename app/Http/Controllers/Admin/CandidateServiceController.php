<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCandidateServiceRequest;
use App\Http\Requests\StoreCandidateServiceRequest;
use App\Http\Requests\UpdateCandidateServiceRequest;
use App\Models\Candidate;
use App\Models\CandidateProgram;
use App\Models\CandidateService;
use App\Models\ServiceItem;
use App\Models\SessionUser;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CandidateServiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('candidate_service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateServices = CandidateService::with(['candidate', 'service_item', 'user', 'candidate_program', 'session_user'])->get();

        return view('admin.candidateServices.index', compact('candidateServices'));
    }

    public function create()
    {
        abort_if(Gate::denies('candidate_service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $service_items = ServiceItem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidate_programs = CandidateProgram::pluck('program_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $session_users = SessionUser::with(['session'])->get()->pluck('session.title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.candidateServices.create', compact('candidate_programs', 'candidates', 'service_items', 'session_users', 'users'));
    }

    public function store(StoreCandidateServiceRequest $request)
    {
        $candidateService = CandidateService::create($request->all());

        return redirect()->route('admin.candidate-services.index');
    }

    public function edit(CandidateService $candidateService)
    {
        abort_if(Gate::denies('candidate_service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $service_items = ServiceItem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidate_programs = CandidateProgram::pluck('program_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $session_users = SessionUser::with(['session'])->get()->pluck('session.title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidateService->load('candidate', 'service_item', 'user', 'candidate_program', 'session_user');

        return view('admin.candidateServices.edit', compact('candidateService', 'candidate_programs', 'candidates', 'service_items', 'session_users', 'users'));
    }

    public function update(UpdateCandidateServiceRequest $request, CandidateService $candidateService)
    {
        $candidateService->update($request->all());

        return redirect()->route('admin.candidate-services.index');
    }

    public function show(CandidateService $candidateService)
    {
        abort_if(Gate::denies('candidate_service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateService->load('candidate', 'service_item', 'user', 'candidate_program', 'session_user');

        return view('admin.candidateServices.show', compact('candidateService'));
    }

    public function destroy(CandidateService $candidateService)
    {
        abort_if(Gate::denies('candidate_service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateService->delete();

        return back();
    }

    public function massDestroy(MassDestroyCandidateServiceRequest $request)
    {
        CandidateService::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
