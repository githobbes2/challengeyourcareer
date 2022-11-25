<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCandidateRequest;
use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use App\Models\Candidate;
use App\Models\CandidateCommitment;
use App\Models\CandidateTag;
use App\Models\City;
use App\Models\Company;
use App\Models\EducationLevel;
use App\Models\FunctionalArea;
use App\Models\Gender;
use App\Models\IndustrySector;
use App\Models\ProfessionalLevel;
use App\Models\Skill;
use App\Models\Session;
use App\Models\User;
use App\Models\Language;
use App\Models\Role;
use App\Models\EventCandidate;
use App\Models\JobOfferCandidate;
use Barryvdh\DomPDF\Facade\Pdf;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Notifications\NewUserNotification;

class CandidateController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('candidate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidates = Candidate::with(['user', 'company', 'city', 'tags', 'education_level', 'professional_level', 'functional_area', 'skills', 'industry_sector', 'gender', 'media'])->get();
        $users = User::get();
        $companies = Company::get();
        $cities = City::get();
        $candidate_tags = CandidateTag::get();
        $education_levels = EducationLevel::get();
        $professional_levels = ProfessionalLevel::get();
        $functional_areas = FunctionalArea::get();
        $skills = Skill::get();
        $industry_sectors = IndustrySector::get();
        $genders = Gender::get();

        return view('admin.candidates.index', compact('candidate_tags', 'candidates', 'cities', 'companies', 'education_levels', 'functional_areas', 'genders', 'industry_sectors', 'professional_levels', 'skills', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('candidate_create') || Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // user related
        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = Language::pluck('name', 'id');
        $system_languages = Language::pluck('name', 'id')->prepend(trans('global.defaultLanguage'), '');

        // candidate related
        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $tags = CandidateTag::pluck('name', 'id');
        $education_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $skills = Skill::pluck('name', 'id');
        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$related_companies = Company::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.candidates.create', compact('companies', 'languages', 'system_languages', 'cities', 'education_levels', 'functional_areas', 'genders', 'industry_sectors', 'professional_levels', 'skills', 'tags'));
    }

    // HBS 2022.08 Respaldo de CREATE para tener aún la opción de generar registro de candidate sin user
    public function createCandidate()
    {
        abort_if(Gate::denies('candidate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $tags = CandidateTag::pluck('name', 'id');
        $education_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $skills = Skill::pluck('name', 'id');
        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$related_companies = Company::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.candidates.create_candidate', compact('cities', 'companies', 'education_levels', 'functional_areas', 'genders', 'industry_sectors', 'professional_levels', 'skills', 'tags', 'users'));
    }

    public function store(StoreCandidateRequest $request)
    {
        //password handling
        $permitted = "0123456789QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm[].*+-";
        $request['password'] = substr(str_shuffle($permitted), 0, 15);

        $user = User::create($request->all());
        $user->languages()->sync($request->input('languages', []));
        $user->roles()->sync([ config('enums.roles.candidate') ]);

        if ($request->input('photo', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $user->id]);
        }
        $request['user_id']    = $user->id;
        $request['created_by'] = Auth::user()->id;

        $candidate = Candidate::create($request->all());
        $candidate->tags()->sync($request->input('tags', []));
        $candidate->skills()->sync($request->input('skills', []));
        //$candidate->related_companies()->sync($request->input('related_companies', []));

        // HBS 2022.11 Enviar notificacion al candidato
        if($request['send_notification']=="1") {
            $user->notify(new NewUserNotification($user));
        }

        // HBS 2022.11 Despues de guardar ir a registro de CandidateProgram
        if($request['program_aftersave']=="1") {
            return redirect()->route('admin.candidate-programs.create', ['programID'=>0, 'candidateID'=>$candidate->id]) ->with('message', trans('cruds.candidate.messages.saved_program_aftersave'));
        }

        if(Auth::user()->is_consultant && !Auth::user()->is_admin) {
            return redirect()->route('admin.home');
        }
        return redirect()->route('admin.candidates.index');
    }

    // HBS 2022.08 Respaldo de STORE para tener aún la opción de generar registro de candidate sin user
    public function storeCandidate(StoreCandidateRequest $request)
    {
        $candidate = Candidate::create($request->all());
        $candidate->tags()->sync($request->input('tags', []));
        $candidate->skills()->sync($request->input('skills', []));
        //$candidate->related_companies()->sync($request->input('related_companies', []));
        if ($request->input('curriculum', false)) {
            $candidate->addMedia(storage_path('tmp/uploads/' . basename($request->input('curriculum'))))->toMediaCollection('curriculum');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $candidate->id]);
        }

        return redirect()->route('admin.candidates.index');
    }

    public function edit(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // user related
        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = Language::pluck('name', 'id');
        $system_languages = Language::pluck('name', 'id')->prepend(trans('global.defaultLanguage'), '');

        // candidate related
        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $tags = CandidateTag::pluck('name', 'id');
        $education_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $skills = Skill::pluck('name', 'id');
        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$related_companies = Company::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $candidate->load('user', 'company', 'city', 'tags', 'education_level', 'professional_level', 'functional_area', 'skills', 'industry_sector', 'related_companies', 'gender');
        $user = $candidate->user;

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        return view('admin.candidates.edit', compact('referer', 'user', 'companies', 'languages', 'system_languages', 'candidate', 'cities', 'education_levels', 'functional_areas', 'genders', 'industry_sectors', 'professional_levels', 'skills', 'tags'));
    }

    public function update(UpdateCandidateRequest $request, Candidate $candidate)
    {
        $referer = $request->input('referer');

        $candidate->update($request->only(['challenge_card', 'disability', 'immigrant', 'address', 'postalcode', 'profile', 'position', 'gender_id', 'city_id', 'company_id', 'education_level_id', 'industry_sector_id', 'functional_area_id', 'professional_level_id']));
        $candidate->tags()->sync($request->input('tags', []));
        $candidate->skills()->sync($request->input('skills', []));
        //$candidate->related_companies()->sync($request->input('related_companies', []));

        $user = $candidate->user;
        if($user) {
            $user->update($request->only(['name', 'lastname', 'system_language_id', 'email', 'password', 'birthday', 'phone', 'government_number', 'passport', 'social_linkedin']));
            $user->languages()->sync($request->input('languages', []));
            if ($request->input('photo', false)) {
                if (!$user->photo || $request->input('photo') !== $user->photo->file_name) {
                    if ($user->photo) {
                        $user->photo->delete();
                    }
                    $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
                }
            } elseif ($user->photo) {
                $user->photo->delete();
            }
        }

        if(str_contains($referer, '/candidates/')) {
            return redirect()->route('admin.candidates.show', $candidate->id);
        }

        return redirect()->route('admin.candidates.index');
    }

    // HBS 2022.10 Respaldo de UPDATE para tener aún la opción de actualizar registro de candidate sin user
    public function updateCandidate(UpdateCandidateRequest $request, Candidate $candidate)
    {
        $candidate->update($request->all());
        $candidate->tags()->sync($request->input('tags', []));
        $candidate->skills()->sync($request->input('skills', []));
        //$candidate->related_companies()->sync($request->input('related_companies', []));
        if ($request->input('curriculum', false)) {
            if (!$candidate->curriculum || $request->input('curriculum') !== $candidate->curriculum->file_name) {
                if ($candidate->curriculum) {
                    $candidate->curriculum->delete();
                }
                $candidate->addMedia(storage_path('tmp/uploads/' . basename($request->input('curriculum'))))->toMediaCollection('curriculum');
            }
        } elseif ($candidate->curriculum) {
            $candidate->curriculum->delete();
        }

        return redirect()->route('admin.candidates.index');
    }

    public function show(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidate->load('user', 'company', 'city', 'tags', 'education_level', 'professional_level', 'functional_area', 'skills', 'industry_sector', 'gender', 'candidateCandidatePrograms', 'candidateCandidateCommitments', 'candidateCandidateServices', 'candidateJobOfferCandidates', 'candidateEventCandidates', 'candidatePollCandidates', 'candidateCandidateCurriculums', 'candidateJobOffers');

        $userID      = $candidate->user_id;
        $candidateID = $candidate->id;
        $programID   = null;
        if($candidate->program) {
            $programID = $candidate->program->id;
        }
        $sessions = Session::select('sessions.id', 'sessions.title', 'sessions.status', 'sessions.start_time', 'session_users.attendance', 'session_users.score', 'users.name', 'programs.internal_name', DB::raw('session_users.id AS session_user_id'), DB::raw('candidate_programs.id AS candidate_program_id'))
            ->leftJoin('users', 'users.id', '=', 'sessions.user_id')
            ->leftJoin('programs', 'programs.id', '=', 'sessions.program_id')
            ->leftJoin('candidate_programs', function($join) use ($candidateID) {
                $join->on('sessions.program_id', '=', 'candidate_programs.program_id')
                    ->on('candidate_programs.candidate_id', '=', DB::raw("'".$candidateID."'"))
                    ->whereNull('candidate_programs.deleted_at');
            })
            ->leftJoin('session_users', function($join) use ($userID) {
                $join->on('sessions.id', '=', 'session_users.session_id')
                    ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
                    ->whereNull('session_users.deleted_at');
            })
            ->whereHas('session_users', function($q) use ($userID){ $q->where('user_id', $userID); })
            ->orWhere('sessions.program_id', $programID)
            ->whereNull('users.deleted_at')
            ->whereNull('programs.deleted_at')
            ->orderByDesc('sessions.start_time')
            ->get();

        return view('admin.candidates.show', compact('candidate', 'sessions'));
    }

    public function destroy(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidate->delete();

        return back();
    }

    public function massDestroy(MassDestroyCandidateRequest $request)
    {
        Candidate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('candidate_create') && Gate::denies('candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Candidate();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    //Only admin and consultants can view this
    public function getDossier(Candidate $candidate) {
        abort_if(Gate::denies('candidate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if(!Auth::user()->is_consultant && !Auth::user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidate->load('user', 'company');

        $sessionCount            = 0;
        $sessionCompleteCount    = 0;
        $sessionMissingCount     = 0;
        $commitmentCount         = 0;
        $commitmentCompleteCount = 0;
        $eventCount              = 0;
        $jobOfferCount           = 0;

        list($sessionCount, $sessionCompleteCount, $sessionMissingCount, $commitmentCount, $commitmentCompleteCount, $eventCount, $jobOfferCount) = $this->getDossierData($candidate);

        return view('admin.candidates.dossier', compact('candidate', 'sessionCount', 'sessionCompleteCount', 'sessionMissingCount', 'commitmentCount', 'commitmentCompleteCount', 'eventCount', 'jobOfferCount'));
    }

    public function exportDossier(Request $request, Candidate $candidate) {

        $note = $request->note;

        $sessionCount            = 0;
        $sessionCompleteCount    = 0;
        $sessionMissingCount     = 0;
        $commitmentCount         = 0;
        $commitmentCompleteCount = 0;
        $eventCount              = 0;
        $jobOfferCount           = 0;

        list($sessionCount, $sessionCompleteCount, $sessionMissingCount, $commitmentCount, $commitmentCompleteCount, $eventCount, $jobOfferCount) = $this->getDossierData($candidate);

        $pdf = Pdf::setOption(['dpi' => 100])
            ->loadView('admin.candidates.dossier-export', compact('note', 'candidate', 'sessionCount', 'sessionCompleteCount', 'sessionMissingCount', 'commitmentCount', 'commitmentCompleteCount', 'eventCount', 'jobOfferCount'));
        return $pdf->download('Informe_Candidato.pdf');
        //return view('admin.candidates.dossier-export', compact('note', 'candidate', 'sessionCount', 'sessionCompleteCount', 'sessionMissingCount', 'commitmentCount', 'commitmentCompleteCount', 'eventCount', 'jobOfferCount'));
    }

    //TEMP
    public function exportDossierView(Request $request, Candidate $candidate) {

        $note = $request->note;

        $sessionCount            = 0;
        $sessionCompleteCount    = 0;
        $sessionMissingCount     = 0;
        $commitmentCount         = 0;
        $commitmentCompleteCount = 0;
        $eventCount              = 0;
        $jobOfferCount           = 0;

        list($sessionCount, $sessionCompleteCount, $sessionMissingCount, $commitmentCount, $commitmentCompleteCount, $eventCount, $jobOfferCount) = $this->getDossierData($candidate);

        return view('admin.candidates.dossier-export', compact('note', 'candidate', 'sessionCount', 'sessionCompleteCount', 'sessionMissingCount', 'commitmentCount', 'commitmentCompleteCount', 'eventCount', 'jobOfferCount'));
    }

    private function getDossierData($candidate) {
        $sessionCount            = 0;
        $sessionCompleteCount    = 0;
        $sessionMissingCount     = 0;
        $commitmentCount         = 0;
        $commitmentCompleteCount = 0;
        $eventCount              = 0;
        $jobOfferCount           = 0;

        $userID = $candidate->user_id;
        $programID = 0;
        if($candidate->program) {
            $programID = $candidate->program->id;
        }

        $sessions = Session::select('sessions.id', 'sessions.status', 'session_users.attendance')
            ->leftJoin('session_users', function($join) use ($userID) {
                $join->on('sessions.id', '=', 'session_users.session_id')
                    ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
                    ->whereNull('session_users.deleted_at');
            })
            ->whereHas('session_users', function($q) use($userID){ $q->where('user_id', $userID); })
            ->orWhere('sessions.program_id', $programID)
            ->orderByDesc('sessions.start_time')
            ->get();
        if($sessions) {
            $sessionCount         = $sessions->count();
            $sessionCompleteCount = $sessions->where('attendance', '1')->count();
            $sessionMissingCount  = $sessions->whereIn('status', ['s','r','c'])->count();
        }

        $commitments = CandidateCommitment::where('candidate_id', $candidate->id)
            ->orderByDesc('created_at')
            ->get();
        if($commitments) {
            $commitmentCount         = $commitments->count();
            $commitmentCompleteCount = $commitments->where('complete', '1')->count();
        }

        $eventCount = EventCandidate::where('candidate_id', $candidate->id)->where('attendance', '1')->get()->count();

        $jobOfferCount = JobOfferCandidate::where('candidate_id', $candidate->id)->get()->count();

        return  [$sessionCount, $sessionCompleteCount, $sessionMissingCount, $commitmentCount, $commitmentCompleteCount, $eventCount, $jobOfferCount];
    }
}
