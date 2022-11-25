<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCandidateCommitmentRequest;
use App\Http\Requests\StoreCandidateCommitmentRequest;
use App\Http\Requests\UpdateCandidateCommitmentRequest;
use App\Models\Candidate;
use App\Models\CandidateCommitment;
use App\Models\CommitmentTag;
use App\Models\DevelopmentArea;
use App\Models\SessionUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CandidateCommitmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('candidate_commitment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateCommitments = CandidateCommitment::with(['candidate', 'session_user', 'tags', 'development_area'])->get();

        return view('admin.candidateCommitments.index', compact('candidateCommitments'));
    }

    public function create()
    {
        abort_if(Gate::denies('candidate_commitment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $session_users = SessionUser::with(['session'])->get()->pluck('session.title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = CommitmentTag::pluck('name', 'id');

        $development_areas = DevelopmentArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.candidateCommitments.create', compact('candidates', 'development_areas', 'session_users', 'tags'));
    }

    public function store(StoreCandidateCommitmentRequest $request)
    {
        if(Auth::user()->is_candidate && !Auth::user()->is_admin){
            //HBS 2022.09 FALTA review session_user_id perhaps?

            //En el campo session_user_id se recibe el valor session.id que se debe traducir
            if($request->session_user_id) {
                $sessionUser = SessionUser::firstOrCreate(['user_id' => Auth::user()->id, 'session_id' => $request->session_user_id]);
                $request->merge(['session_user_id' => $sessionUser->id]);
            }

            //add candidate_id
            $candidateID = Auth::user()->candidate->id;
            $candidateCommitment = CandidateCommitment::create(array_merge($request->all(), ['candidate_id' => $candidateID], ['experience_points' => config('global.experience.commitment')]));
            $candidateCommitment->tags()->sync($request->input('tags', []));

            return back();
        } else {
            $candidateCommitment = CandidateCommitment::create(array_merge($request->all(), ['experience_points' => config('global.experience.commitment')]));
            $candidateCommitment->tags()->sync($request->input('tags', []));

            return redirect()->route('admin.candidate-commitments.index');
        }
    }

    public function edit(CandidateCommitment $candidateCommitment)
    {
        abort_if(Gate::denies('candidate_commitment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $session_users = SessionUser::with(['session'])->get()->pluck('session.title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $tags = CommitmentTag::pluck('name', 'id');
        $development_areas = DevelopmentArea::pluck('name', 'id');
        $candidateCommitment->load('candidate', 'session_user', 'tags', 'development_area');

        return view('admin.candidateCommitments.edit', compact('candidateCommitment', 'candidates', 'development_areas', 'session_users', 'tags'));
    }

    public function update(UpdateCandidateCommitmentRequest $request, CandidateCommitment $candidateCommitment)
    {
        if(Auth::user()->is_candidate && !Auth::user()->is_admin){

            //SEGURIDAD: Los candidatos solo pueden editar sus propios registros
            if($candidateCommitment->candidate_id == Auth::user()->candidate->id) {
                //En el campo session_user_id se recibe el valor session.id que se debe traducir
                if($request->session_user_id) {
                    $sessionUser = SessionUser::firstOrCreate(['user_id' => Auth::user()->id, 'session_id' => $request->session_user_id]);
                    $request->merge(['session_user_id' => $sessionUser->id]);
                }

                //HBS 2022.09 FALTA review session_user_id perhaps?
                $candidateCommitment->update($request->all());
                $candidateCommitment->tags()->sync($request->input('tags', []));
            }

            return back();
        } else {
            $candidateCommitment->update($request->all());
            $candidateCommitment->tags()->sync($request->input('tags', []));

            return redirect()->route('admin.candidate-commitments.index');
        }
    }

    public function show(CandidateCommitment $candidateCommitment)
    {
        abort_if(Gate::denies('candidate_commitment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateCommitment->load('candidate', 'session_user', 'tags', 'development_area');

        return view('admin.candidateCommitments.show', compact('candidateCommitment'));
    }

    public function destroy(CandidateCommitment $candidateCommitment)
    {
        $denyAction = Auth::user()->is_candidate && !Auth::user()->is_admin && $candidateCommitment->candidate_id != Auth::user()->candidate->id;
        abort_if($denyAction || Gate::denies('candidate_commitment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateCommitment->delete();

        if(Auth::user()->is_candidate && !Auth::user()->is_admin) {
            return redirect()->route('admin.candidate.program.show');
        }

        return back();
    }

    public function massDestroy(MassDestroyCandidateCommitmentRequest $request)
    {
        CandidateCommitment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
