<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyJobOfferRequest;
use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use App\Models\Candidate;
use App\Models\City;
use App\Models\EducationLevel;
use App\Models\FunctionalArea;
use App\Models\IndustrySector;
use App\Models\JobOffer;
use App\Models\JobOfferTag;
use App\Models\Language;
use App\Models\ProfessionalLevel;
use App\Models\Program;
use App\Models\RecruiterType;
use App\Models\Skill;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class JobOfferController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('job_offer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOffers = JobOffer::with(['user', 'candidate', 'program', 'tags', 'recruiter_type', 'city', 'educational_level', 'professional_level', 'functional_area', 'languages', 'skill', 'industry_sector', 'media'])->get();

        $users = User::get();

        $candidates = Candidate::get();

        $programs = Program::get();

        $job_offer_tags = JobOfferTag::get();

        $recruiter_types = RecruiterType::get();

        $cities = City::get();

        $education_levels = EducationLevel::get();

        $professional_levels = ProfessionalLevel::get();

        $functional_areas = FunctionalArea::get();

        $languages = Language::get();

        $skills = Skill::get();

        $industry_sectors = IndustrySector::get();

        return view('admin.jobOffers.index', compact('candidates', 'cities', 'education_levels', 'functional_areas', 'industry_sectors', 'jobOffers', 'job_offer_tags', 'languages', 'professional_levels', 'programs', 'recruiter_types', 'skills', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('job_offer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $programs = Program::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = JobOfferTag::pluck('name', 'id');

        $recruiter_types = RecruiterType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $educational_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::pluck('name', 'id');

        $skills = Skill::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.jobOffers.create', compact('candidates', 'cities', 'educational_levels', 'functional_areas', 'industry_sectors', 'languages', 'professional_levels', 'programs', 'recruiter_types', 'skills', 'tags', 'users'));
    }

    public function store(StoreJobOfferRequest $request)
    {
        $user = Auth::user();
        if($user->is_consultant && !$user->is_admin) {
            $request['user_id'] = $user->id;
        }

        $jobOffer = JobOffer::create($request->all());
        $jobOffer->tags()->sync($request->input('tags', []));
        $jobOffer->languages()->sync($request->input('languages', []));
        foreach ($request->input('attachments', []) as $file) {
            $jobOffer->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $jobOffer->id]);
        }

        return redirect()->route('admin.job-offers.index');
    }

    public function edit(JobOffer $jobOffer)
    {
        abort_if(Gate::denies('job_offer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidates = \App\Models\User::select('users.name', 'candidates.id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.candidate')); })
            ->join('candidates', 'candidates.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->orderBy('users.lastname')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $programs = Program::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = JobOfferTag::pluck('name', 'id');

        $recruiter_types = RecruiterType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $educational_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::pluck('name', 'id');

        $skills = Skill::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $jobOffer->load('user', 'candidate', 'program', 'tags', 'recruiter_type', 'city', 'educational_level', 'professional_level', 'functional_area', 'languages', 'skill', 'industry_sector');

        return view('admin.jobOffers.edit', compact('candidates', 'cities', 'educational_levels', 'functional_areas', 'industry_sectors', 'jobOffer', 'languages', 'professional_levels', 'programs', 'recruiter_types', 'skills', 'tags', 'users'));
    }

    public function update(UpdateJobOfferRequest $request, JobOffer $jobOffer)
    {
        $jobOffer->update($request->all());
        $jobOffer->tags()->sync($request->input('tags', []));
        $jobOffer->languages()->sync($request->input('languages', []));
        if (count($jobOffer->attachments) > 0) {
            foreach ($jobOffer->attachments as $media) {
                if (!in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }
        $media = $jobOffer->attachments->pluck('file_name')->toArray();
        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $jobOffer->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.job-offers.index');
    }

    public function show(JobOffer $jobOffer)
    {
        abort_if(Gate::denies('job_offer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOffer->load('user', 'candidate', 'program', 'tags', 'recruiter_type', 'city', 'educational_level', 'professional_level', 'functional_area', 'languages', 'skill', 'industry_sector', 'jobOfferJobOfferCandidates');

        return view('admin.jobOffers.show', compact('jobOffer'));
    }

    public function destroy(JobOffer $jobOffer)
    {
        abort_if(Gate::denies('job_offer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOffer->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobOfferRequest $request)
    {
        JobOffer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('job_offer_create') && Gate::denies('job_offer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new JobOffer();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
