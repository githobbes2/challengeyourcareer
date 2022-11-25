<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserNoteTagRequest;
use App\Http\Requests\StoreUserNoteTagRequest;
use App\Http\Requests\UpdateUserNoteTagRequest;
use App\Models\UserNoteTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserNoteTagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_note_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userNoteTags = UserNoteTag::all();

        return view('admin.userNoteTags.index', compact('userNoteTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_note_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userNoteTags.create');
    }

    public function store(StoreUserNoteTagRequest $request)
    {
        $userNoteTag = UserNoteTag::create($request->all());

        return redirect()->route('admin.user-note-tags.index');
    }

    public function edit(UserNoteTag $userNoteTag)
    {
        abort_if(Gate::denies('user_note_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userNoteTags.edit', compact('userNoteTag'));
    }

    public function update(UpdateUserNoteTagRequest $request, UserNoteTag $userNoteTag)
    {
        $userNoteTag->update($request->all());

        return redirect()->route('admin.user-note-tags.index');
    }

    public function show(UserNoteTag $userNoteTag)
    {
        abort_if(Gate::denies('user_note_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userNoteTags.show', compact('userNoteTag'));
    }

    public function destroy(UserNoteTag $userNoteTag)
    {
        abort_if(Gate::denies('user_note_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userNoteTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserNoteTagRequest $request)
    {
        UserNoteTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
