<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySessionUserRequest;
use App\Http\Requests\StoreSessionUserRequest;
use App\Http\Requests\UpdateSessionUserRequest;
use App\Models\Session;
use App\Models\SessionUser;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SessionUserController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('session_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionUsers = SessionUser::with(['user', 'session', 'media'])->get();

        return view('admin.sessionUsers.index', compact('sessionUsers'));
    }

    public function create()
    {
        abort_if(Gate::denies('session_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->orderBy('name')
            ->orderBy('lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $sessions = Session::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sessionUsers.create', compact('sessions', 'users'));
    }

    public function store(StoreSessionUserRequest $request)
    {
        $sessionUser = SessionUser::create($request->all());

        foreach ($request->input('attachments', []) as $file) {
            $sessionUser->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $sessionUser->id]);
        }

        return redirect()->route('admin.session-users.index');
    }

    public function edit(SessionUser $sessionUser)
    {
        abort_if(Gate::denies('session_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->orderBy('name')
            ->orderBy('lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $sessions = Session::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessionUser->load('user', 'session');

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        return view('admin.sessionUsers.edit', compact('sessionUser', 'sessions', 'users', 'referer'));
    }

    public function editNew(Request $request)
    {
        abort_if(Gate::denies('session_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->orderBy('name')
            ->orderBy('lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $sessions = Session::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessionUser = SessionUser::firstOrCreate(['user_id' => $request->user, 'session_id' => $request->session]);
        $sessionUser->load('user', 'session');

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        return view('admin.sessionUsers.edit', compact('sessionUser', 'sessions', 'users', 'referer'));
    }

    public function update(UpdateSessionUserRequest $request, SessionUser $sessionUser)
    {
        //Seguridad
        if(Auth::user()->is_consultant && !Auth::user()->is_admin) {
            $sessionUser->update($request->except(['user_id', 'session_id', 'score']));
        } else {
            $sessionUser->update($request->all());
        }

        if (count($sessionUser->attachments) > 0) {
            foreach ($sessionUser->attachments as $media) {
                if (!in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }
        $media = $sessionUser->attachments->pluck('file_name')->toArray();
        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $sessionUser->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
            }
        }

        // HBS 2022.09 Temporal. FALTA mejorar navegacion luego de guardar datos
        if($request->referer) {
            return redirect($request->referer);
        }
        return redirect()->route('admin.session-users.index');
    }

    public function show(SessionUser $sessionUser)
    {
        abort_if(Gate::denies('session_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sessionUser->load('user', 'session', 'sessionUserCandidateCommitments', 'sessionUserUserNotes', 'sessionUserCandidateServices');
        $session = $sessionUser->session;
        return view('admin.sessionUsers.show', compact('sessionUser', 'session'));
    }

    public function showNew(Request $request)
    {
        abort_if(Gate::denies('session_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sessionUser = SessionUser::firstOrCreate(['user_id' => $request->user, 'session_id' => $request->session]);
        $sessionUser->load('user', 'session', 'sessionUserCandidateCommitments', 'sessionUserUserNotes', 'sessionUserCandidateServices');
        $session = $sessionUser->session;
        return view('admin.sessionUsers.show', compact('sessionUser', 'session'));
    }

    public function destroy(SessionUser $sessionUser)
    {
        abort_if(Gate::denies('session_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionUser->delete();

        return back();
    }

    public function massDestroy(MassDestroySessionUserRequest $request)
    {
        SessionUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('session_user_create') && Gate::denies('session_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SessionUser();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
