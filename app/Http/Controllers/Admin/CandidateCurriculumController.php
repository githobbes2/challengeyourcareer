<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCandidateCurriculumRequest;
use App\Http\Requests\StoreCandidateCurriculumRequest;
use App\Http\Requests\UpdateCandidateCurriculumRequest;
use App\Models\Candidate;
use App\Models\CandidateCurriculum;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CandidateCurriculumController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('candidate_curriculum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateCurriculums = CandidateCurriculum::with(['candidate', 'media'])->get();

        return view('admin.candidateCurriculums.index', compact('candidateCurriculums'));
    }

    public function create()
    {
        abort_if(Gate::denies('candidate_curriculum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('admin.candidateCurriculums.create', compact('candidates'));
    }

    public function store(StoreCandidateCurriculumRequest $request)
    {
        $candidateCurriculum = CandidateCurriculum::create($request->all());

        if ($request->input('file', false)) {
            $candidateCurriculum->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $candidateCurriculum->id]);
        }

        return redirect()->route('admin.candidate-curriculums.index');
    }

    public function edit(CandidateCurriculum $candidateCurriculum)
    {
        abort_if(Gate::denies('candidate_curriculum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $candidateCurriculum->load('candidate');

        return view('admin.candidateCurriculums.edit', compact('candidateCurriculum', 'candidates'));
    }

    public function update(UpdateCandidateCurriculumRequest $request, CandidateCurriculum $candidateCurriculum)
    {
        $candidateCurriculum->update($request->all());

        if ($request->input('file', false)) {
            if (!$candidateCurriculum->file || $request->input('file') !== $candidateCurriculum->file->file_name) {
                if ($candidateCurriculum->file) {
                    $candidateCurriculum->file->delete();
                }
                $candidateCurriculum->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($candidateCurriculum->file) {
            $candidateCurriculum->file->delete();
        }

        return redirect()->route('admin.candidate-curriculums.index');
    }

    public function show(CandidateCurriculum $candidateCurriculum)
    {
        abort_if(Gate::denies('candidate_curriculum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateCurriculum->load('candidate', 'curriculumJobOfferCandidates');

        return view('admin.candidateCurriculums.show', compact('candidateCurriculum'));
    }

    public function destroy(CandidateCurriculum $candidateCurriculum)
    {
        abort_if(Gate::denies('candidate_curriculum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidateCurriculum->delete();

        return back();
    }

    public function massDestroy(MassDestroyCandidateCurriculumRequest $request)
    {
        CandidateCurriculum::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('candidate_curriculum_create') && Gate::denies('candidate_curriculum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CandidateCurriculum();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
