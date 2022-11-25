<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySessionRequest;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\DevelopmentArea;
use App\Models\Program;
use App\Models\Session;
use App\Models\SessionType;
use App\Models\SessionUser;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('session_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = Session::with(['user', 'session_type', 'program', 'company', 'development_area', 'media'])->withCount('sessions')->get();
        $users = User::whereHas('roles', function($q){ $q->where('id', config('enums.roles.consultant')); })
            ->orderBy('name')
            ->orderBy('lastname')
            ->get();

        $session_types = SessionType::get();
        $programs = Program::has('sessions')->orderBy('name')->get();
        $companies = Company::get();
        $development_areas = DevelopmentArea::get();

        return view('admin.sessions.index', compact('companies', 'development_areas', 'programs', 'session_types', 'sessions', 'users'));
    }

    public function create($programID=null)
    {
        abort_if(Gate::denies('session_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::select(DB::raw('CONCAT(name, \' \', COALESCE(lastname,\'\')) AS name'), 'id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.consultant')); })
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $session_types = SessionType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $programs = Program::select('name','internal_name', 'id')->orderBy('created_at', 'DESC')->get();

        //$companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $development_areas = DevelopmentArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //Listado de candidatos que pueden ser agregados a una sesion
        $candidates = User::select(DB::raw('CONCAT(name, \' \', COALESCE(lastname,\'\')) AS name'), 'id')
        ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
        ->orderBy('name')
        ->get();

        return view('admin.sessions.create', compact('programID', 'development_areas', 'programs', 'session_types', 'users', 'candidates'));
    }

    public function addCandidates(Request $request) {
        $session = Session::find($request->session_id);
        if($session) {
            foreach ($request->input('candidates', []) as $candidate) {
                SessionUser::create([
                    'user_id' => $candidate,
                    'session_id' => $request->session_id
                ]);
            }
        }

        return back();
    }

    public function store(StoreSessionRequest $request)
    {
        $user = Auth::user();
        if($user->is_consultant && !$user->is_admin) {
            $request['user_id'] = $user->id;
        }

        $session = Session::create(array_merge($request->all(), ['experience_points' => config('global.experience.session')]));

        //Add candidates to session
        foreach ($request->input('candidates', []) as $candidate) {
            SessionUser::create([
                'user_id' => $candidate,
                'session_id' => $session->id
            ]);
        }

        foreach ($request->input('attachments', []) as $file) {
            $session->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $session->id]);
        }

        if($user->is_consultant && !$user->is_admin) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('admin.sessions.index');
    }

    public function edit(Session $session)
    {
        abort_if(Gate::denies('session_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::select(DB::raw('CONCAT(name, \' \', COALESCE(lastname,\'\')) AS name'), 'id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.consultant')); })
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');

        $session_types = SessionType::pluck('name', 'id');
        $programs = Program::select('name','internal_name', 'id')->orderBy('created_at', 'DESC')->get();
        //$companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $development_areas = DevelopmentArea::pluck('name', 'id');
        $session->load('user', 'session_type', 'program', 'company', 'development_area');

        //--
        //Listado de candidatos que pueden ser agregados a una sesion
        //$sessionID = $session->id;
        //$usersInProgram = [];
        //if($session->program) {
        //    //Lista de user_id que ya participan a la sesion por pertenecer al programa de la sesion
        //    $usersInProgram = $session->program->candidates->pluck('user_id')->toArray();
        //}
//
        //$candidates = User::select(DB::raw('CONCAT(users.name, \' \', COALESCE(users.lastname,\'\')) AS name'), 'users.id', DB::RAW('session_users.id AS session_user_id'))
        //->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
        //->leftjoin('session_users', function ($join) use ($sessionID, $usersInProgram) {
        //    $join->on('session_users.user_id', '=', 'users.id')
        //        ->where('session_users.session_id', '=', $sessionID)
        //        ->whereNotIn('session_users.user_id', $usersInProgram);
        //})
        //->orderBy('name')
        //->get();
        //--

        return view('admin.sessions.edit', compact('development_areas', 'programs', 'session', 'session_types', 'users'));
    }

    public function update(UpdateSessionRequest $request, Session $session)
    {
        $session->update($request->all());

        if (count($session->attachments) > 0) {
            foreach ($session->attachments as $media) {
                if (!in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }
        $media = $session->attachments->pluck('file_name')->toArray();
        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $session->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.sessions.index');
    }

    public function show(Session $session)
    {
        abort_if(Gate::denies('session_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $session->load('user', 'session_type', 'program', 'company', 'development_area', 'session_users');
        $sessionUsers = $session->session_users;

        $program = $session->program;
        $candidatesMissing = null;  //Agregar al collection $sessionUsers todos los candidatos de un programa que no tienen aún registro en sessionUsers
        $candidatesMissingCount = 0;
        if($program) {
            $program->loadCount('sessions', 'candidates');

            $candidatesMissing = Candidate::select('user_id')
                ->join('candidate_programs', 'candidate_programs.candidate_id', '=', 'candidates.id')
                ->where('candidate_programs.program_id', '=', $session->program_id)
                ->whereNull('candidate_programs.deleted_at')
                ->whereNotIn('candidates.user_id', $sessionUsers->pluck('user_id')->toArray())
                ->get();

            $candidatesMissingCount = $candidatesMissing->count();

            $currentUsersIDs = array_merge($sessionUsers->pluck('user_id')->toArray(), $candidatesMissing->pluck('user_id')->toArray());
            //Listado de candidatos que pueden ser agregados a una sesion
            $candidatesToAdd = Candidate::with('user')
                ->whereNotIn('candidates.user_id', $sessionUsers->pluck('user_id')->toArray())
                ->get();
        } else {
            //Listado de candidatos que pueden ser agregados a una sesion
            $candidatesToAdd = Candidate::with('user')
                ->whereNotIn('candidates.user_id', $sessionUsers->pluck('user_id')->toArray())
                ->get();
        }

        return view('admin.sessions.show', compact('session', 'sessionUsers', 'program', 'candidatesMissing', 'candidatesMissingCount', 'candidatesToAdd'));
    }

    public function destroy(Session $session)
    {
        abort_if(Gate::denies('session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $session->delete();

        return back();
    }

    public function massDestroy(MassDestroySessionRequest $request)
    {
        Session::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('session_create') && Gate::denies('session_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Session();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
