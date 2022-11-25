<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyConsultantRequest;
use App\Http\Requests\StoreConsultantRequest;
use App\Http\Requests\UpdateConsultantRequest;
use App\Models\Consultant;
use App\Models\ConsultantType;
use App\Models\Office;
use App\Models\SkillTag;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ConsultantController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('consultant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $consultants = Consultant::with(['user', 'consultant_type', 'office', 'skill_tags'])->get();

        return view('admin.consultants.index', compact('consultants'));
    }

    public function create()
    {
        abort_if(Gate::denies('consultant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $consultant_types = ConsultantType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $offices = Office::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $skill_tags = SkillTag::pluck('name', 'id');

        return view('admin.consultants.create', compact('consultant_types', 'offices', 'skill_tags', 'users'));
    }

    public function store(StoreConsultantRequest $request)
    {
        $consultant = Consultant::create($request->all());
        $consultant->skill_tags()->sync($request->input('skill_tags', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $consultant->id]);
        }

        return redirect()->route('admin.consultants.index');
    }

    public function edit(Consultant $consultant)
    {
        abort_if(Gate::denies('consultant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $consultant_types = ConsultantType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $offices = Office::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $skill_tags = SkillTag::pluck('name', 'id');

        $consultant->load('user', 'consultant_type', 'office', 'skill_tags');

        return view('admin.consultants.edit', compact('consultant', 'consultant_types', 'offices', 'skill_tags', 'users'));
    }

    public function update(UpdateConsultantRequest $request, Consultant $consultant)
    {
        $consultant->update($request->all());
        $consultant->skill_tags()->sync($request->input('skill_tags', []));

        return redirect()->route('admin.consultants.index');
    }

    public function show(Consultant $consultant)
    {
        abort_if(Gate::denies('consultant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $consultant->load('user', 'consultant_type', 'office', 'skill_tags');

        return view('admin.consultants.show', compact('consultant'));
    }

    public function destroy(Consultant $consultant)
    {
        abort_if(Gate::denies('consultant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $consultant->delete();

        return back();
    }

    public function massDestroy(MassDestroyConsultantRequest $request)
    {
        Consultant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('consultant_create') && Gate::denies('consultant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Consultant();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
