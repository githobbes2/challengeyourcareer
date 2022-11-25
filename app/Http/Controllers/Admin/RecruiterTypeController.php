<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRecruiterTypeRequest;
use App\Http\Requests\StoreRecruiterTypeRequest;
use App\Http\Requests\UpdateRecruiterTypeRequest;
use App\Models\RecruiterType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecruiterTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recruiter_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recruiterTypes = RecruiterType::all();

        return view('admin.recruiterTypes.index', compact('recruiterTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('recruiter_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.recruiterTypes.create');
    }

    public function store(StoreRecruiterTypeRequest $request)
    {
        $recruiterType = RecruiterType::create($request->all());

        return redirect()->route('admin.recruiter-types.index');
    }

    public function edit(RecruiterType $recruiterType)
    {
        abort_if(Gate::denies('recruiter_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.recruiterTypes.edit', compact('recruiterType'));
    }

    public function update(UpdateRecruiterTypeRequest $request, RecruiterType $recruiterType)
    {
        $recruiterType->update($request->all());

        return redirect()->route('admin.recruiter-types.index');
    }

    public function show(RecruiterType $recruiterType)
    {
        abort_if(Gate::denies('recruiter_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recruiterType->load('recruiterTypeJobOffers');

        return view('admin.recruiterTypes.show', compact('recruiterType'));
    }

    public function destroy(RecruiterType $recruiterType)
    {
        abort_if(Gate::denies('recruiter_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recruiterType->delete();

        return back();
    }

    public function massDestroy(MassDestroyRecruiterTypeRequest $request)
    {
        RecruiterType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
