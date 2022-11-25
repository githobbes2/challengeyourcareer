<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySessionTypeRequest;
use App\Http\Requests\StoreSessionTypeRequest;
use App\Http\Requests\UpdateSessionTypeRequest;
use App\Models\SessionType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('session_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionTypes = SessionType::all();

        return view('admin.sessionTypes.index', compact('sessionTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('session_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sessionTypes.create');
    }

    public function store(StoreSessionTypeRequest $request)
    {
        $sessionType = SessionType::create($request->all());

        return redirect()->route('admin.session-types.index');
    }

    public function edit(SessionType $sessionType)
    {
        abort_if(Gate::denies('session_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sessionTypes.edit', compact('sessionType'));
    }

    public function update(UpdateSessionTypeRequest $request, SessionType $sessionType)
    {
        $sessionType->update($request->all());

        return redirect()->route('admin.session-types.index');
    }

    public function show(SessionType $sessionType)
    {
        abort_if(Gate::denies('session_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionType->load('sessionTypesQuestions', 'sessionTypesProgramTypes');

        return view('admin.sessionTypes.show', compact('sessionType'));
    }

    public function destroy(SessionType $sessionType)
    {
        abort_if(Gate::denies('session_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionType->delete();

        return back();
    }

    public function massDestroy(MassDestroySessionTypeRequest $request)
    {
        SessionType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
