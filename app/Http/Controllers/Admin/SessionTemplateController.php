<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySessionTemplateRequest;
use App\Http\Requests\StoreSessionTemplateRequest;
use App\Http\Requests\UpdateSessionTemplateRequest;
use App\Models\Program;
use App\Models\SessionTemplate;
use App\Models\SessionType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTemplateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('session_template_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionTemplates = SessionTemplate::with(['session_types'])->get();

        return view('admin.sessionTemplates.index', compact('sessionTemplates'));
    }

    public function create()
    {
        abort_if(Gate::denies('session_template_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $session_types = SessionType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sessionTemplates.create', compact('session_types'));
    }

    public function store(StoreSessionTemplateRequest $request)
    {
        $sessionTemplate = SessionTemplate::create($request->all());

        for($i=1; $i <= 12; $i++) {
            $session  = $request['session_type_' . $i];
            if($session) {
                $quantity    = $request['session_quantity_' . $i];
                $duration    = $request['session_duration_' . $i];

                $sessionTemplate->session_types()->attach($session, [
                    'quantity' => $quantity,
                    'duration' => $duration
                ]);
            }
        }

        return redirect()->route('admin.session-templates.index');
    }

    public function edit(SessionTemplate $sessionTemplate)
    {
        abort_if(Gate::denies('session_template_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $session_types = SessionType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessionTemplate->load('session_types');

        return view('admin.sessionTemplates.edit', compact('sessionTemplate', 'session_types'));
    }

    public function update(UpdateSessionTemplateRequest $request, SessionTemplate $sessionTemplate)
    {
        $sessionTemplate->update($request->all());

        $sessionTemplate->session_types()->detach();
        for($i=1; $i <= 5; $i++) {
            $session  = $request['session_type_' . $i];
            if($session) {
                $quantity    = $request['session_quantity_' . $i];
                $duration    = $request['session_duration_' . $i];

                $sessionTemplate->session_types()->attach($session, [
                    'quantity' => $quantity,
                    'duration' => $duration
                ]);
            }
        }

        return redirect()->route('admin.session-templates.index');
    }

    public function show(SessionTemplate $sessionTemplate)
    {
        abort_if(Gate::denies('session_template_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionTemplate->load('session_types');

        return view('admin.sessionTemplates.show', compact('sessionTemplate'));
    }

    public function destroy(SessionTemplate $sessionTemplate)
    {
        abort_if(Gate::denies('session_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessionTemplate->delete();

        return back();
    }

    public function massDestroy(MassDestroySessionTemplateRequest $request)
    {
        SessionTemplate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
