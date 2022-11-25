<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserNoteRequest;
use App\Http\Requests\StoreUserNoteRequest;
use App\Http\Requests\UpdateUserNoteRequest;
use App\Models\SessionUser;
use App\Models\User;
use App\Models\UserNote;
use App\Models\UserNoteTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserNoteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_note_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userNotes = UserNote::with(['user', 'session_user', 'tags'])->get();

        return view('admin.userNotes.index', compact('userNotes'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_note_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $session_users = SessionUser::with(['session'])->get()->pluck('session.title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = UserNoteTag::pluck('name', 'id');

        return view('admin.userNotes.create', compact('session_users', 'tags', 'users'));
    }

    public function store(StoreUserNoteRequest $request)
    {
        $userNote = UserNote::create($request->all());
        $userNote->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.user-notes.index');
    }

    public function edit(UserNote $userNote)
    {
        abort_if(Gate::denies('user_note_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $session_users = SessionUser::with(['session'])->get()->pluck('session.title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = UserNoteTag::pluck('name', 'id');

        $userNote->load('user', 'session_user', 'tags');

        return view('admin.userNotes.edit', compact('session_users', 'tags', 'userNote', 'users'));
    }

    public function update(UpdateUserNoteRequest $request, UserNote $userNote)
    {
        $userNote->update($request->all());
        $userNote->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.user-notes.index');
    }

    public function show(UserNote $userNote)
    {
        abort_if(Gate::denies('user_note_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userNote->load('user', 'session_user', 'tags');

        return view('admin.userNotes.show', compact('userNote'));
    }

    public function destroy(UserNote $userNote)
    {
        abort_if(Gate::denies('user_note_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userNote->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserNoteRequest $request)
    {
        UserNote::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
