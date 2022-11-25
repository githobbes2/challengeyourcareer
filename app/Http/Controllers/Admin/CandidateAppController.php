<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Program;
use App\Models\CandidateProgram;
use App\Models\CommitmentTag;
use App\Models\Session;
use App\Models\SessionUser;
use App\Models\CandidateCommitment;
use App\Models\DevelopmentArea;
use App\Models\Event;
use App\Models\EventCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateCandidateRequest;

use App\Models\Candidate;
use App\Models\CandidateTag;
use App\Models\City;
use App\Models\Company;
use App\Models\EducationLevel;
use App\Models\FunctionalArea;
use App\Models\Gender;
use App\Models\IndustrySector;
use App\Models\ProfessionalLevel;
use App\Models\Skill;
use App\Models\Language;

class CandidateAppController extends Controller
{
    protected $user;
    protected $candidate;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= auth()->user();
            $this->candidate = $this->user->candidate;

            return $next($request);
         });
    }

    public function program($id=null)
    {
        abort_if(!$this->user->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(!$id) {
            $program = $this->candidate->program;
        } else {
            //HBS 2022.08 FALTA seguridad para no entregar info de cualquier programa
            $program = Program::where('id', $id)->first();
        }

        $programID = 0;
        if($program) {
            $programID = $program->id;
            $program->load('program_type');
            $program->loadCount('sessions');
        }

        $candidateProgram = CandidateProgram::where('program_id', $programID)
            ->where('candidate_id', $this->candidate->id)
            ->first();

        $userID = $this->user->id;
        $sessions = Session::select('sessions.id', 'sessions.title', 'sessions.status', 'sessions.start_time', 'session_users.attendance', 'users.name')
            ->leftJoin('users', 'users.id', '=', 'sessions.user_id')
            ->leftJoin('session_users', function($join) use ($userID) {
                $join->on('sessions.id', '=', 'session_users.session_id')
                    ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
                    ->whereNull('session_users.deleted_at');
            })
            ->whereHas('session_users', function($q){ $q->where('user_id', $this->user->id); })
            ->orWhere('sessions.program_id', $programID)
            ->whereNull('users.deleted_at')
            ->orderByDesc('sessions.start_time')
            ->get();

        $commitments = CandidateCommitment::where('candidate_id', $this->candidate->id)
            ->orderByDesc('created_at')
            ->get();

        $candidate = $this->candidate;
        $title = trans('global.program');

        //session records for new commitment
        $session_users = $sessions->sortBy('title')->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = CommitmentTag::pluck('name', 'id');

        //Experience Points
        $xpSession = Session::select('sessions.id', 'sessions.status', 'sessions.development_area_id', 'sessions.experience_points', 'session_users.attendance')
        ->join('session_users', function($join) use ($userID) {
            $join->on('sessions.id', '=', 'session_users.session_id')
                ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
                ->whereNull('session_users.deleted_at');
        })
        ->where('session_users.attendance', '1')
        ->whereNotNull('sessions.development_area_id')
        ->whereNotNull('sessions.experience_points')
        ->get();

        $xpCommitment = CandidateCommitment::where('candidate_id', $this->candidate->id)
        ->where('complete', '1')
        ->whereNotNull('development_area_id')
        ->whereNotNull('experience_points')
        ->get();

        $xpEvent = EventCandidate::where('event_candidates.candidate_id', $this->candidate->id)
        ->join('events', function($join) use ($userID) {
            $join->on('event_candidates.event_id', '=', 'events.id')
                ->whereNull('events.deleted_at');
        })
        ->where('event_candidates.attendance', '1')
        ->whereNotNull('events.development_area_id')
        ->whereNotNull('events.experience_points')
        ->get();

        $developmentAreas = DevelopmentArea::all();
        //Calcular puntos de experiencia
        $developmentAreas->map(function ($item) use ($xpSession, $xpCommitment, $xpEvent) {
            $count = 0;

            foreach($xpSession as $xpItem) {
                if($xpItem->development_area_id == $item['id']) {
                    $count = $count + $xpItem->experience_points;
                }
            }
            foreach($xpCommitment as $xpItem) {
                if($xpItem->development_area_id == $item['id']) {
                    $count = $count + $xpItem->experience_points;
                }
            }
            foreach($xpEvent as $xpItem) {
                if($xpItem->development_area_id == $item['id']) {
                    $count = $count + $xpItem->experience_points;
                }
            }

            $item['points'] = $count;
            return $item;
        });

        return view('candidate.program', compact('title', 'candidate', 'program', 'candidateProgram', 'sessions', 'commitments', 'session_users', 'tags', 'developmentAreas'));
    }

    public function session($id)
    {
        abort_if(!$this->user->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $title = trans('candidate.titles.session');

        $session = Session::find($id);
        $sessionUse = null;
        if(!$session) {
            abort(404);
        } else {
            $sessionUser = SessionUser::where('user_id','=',$this->user->id)->where('session_id','=',$id)->first();
            if(!$sessionUser && $session->program && $this->candidate) {
                //Verificar que el usuario sí pertenece a la sesión solicitada, a través del programa
                $CandidateProgram = CandidateProgram::where('candidate_id','=',$this->candidate->id)->where('program_id','=', $session->program->id)->first();
                if($CandidateProgram) {
                    $sessionUser = SessionUser::firstOrCreate(['user_id' => $this->user->id, 'session_id' => $id]);
                }
            }

            if(!$sessionUser) { abort(Response::HTTP_FORBIDDEN, '403 Forbidden'); }

            $sessionUser->load('sessionUserCandidateCommitments');
            $session->load('session_type');
        }

        $tags = CommitmentTag::pluck('name', 'id');

        $candidate = $this->candidate;
        $program   = $candidate->program;
        $printBackBtn = true;

        return view('candidate.session', compact('title', 'printBackBtn', 'candidate', 'program', 'session', 'sessionUser', 'tags'));
    }

    public function sessionUpdate(Request $request, SessionUser $SessionUser) {
        //SEGURIDAD: Los candidatos solo pueden editar sus propios registros
        if($SessionUser->user_id == $this->user->id) {
            $SessionUser->update($request->only('notes'));
        }
        return Redirect::to(url()->previous());
    }

    public function sessionEvaluate(Request $request, SessionUser $SessionUser) {
        //SEGURIDAD: Los candidatos solo pueden editar sus propios registros
        if($SessionUser->user_id == $this->user->id) {
            $SessionUser->update($request->only('score', 'score_feedback'));
        }
        return Redirect::to(url()->previous());
    }

    public function commitment(CandidateCommitment $candidateCommitment)
    {
        //SEGURIDAD: Un candidato no puede ver compromisos que no sean propios
        abort_if((!$this->user->is_candidate || !$candidateCommitment || $candidateCommitment->candidate_id<>$this->candidate->id), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $title = trans('candidate.titles.commitment');

        $candidateCommitment->load('candidate', 'session_user', 'tags', 'development_area');

        $candidate = $this->candidate;
        $program   = $candidate->program;
        $printBackBtn = true;

        $programID = $program ? $program->id : 0;
        $userID = $this->user->id;
        $session_users = Session::select('sessions.id', 'sessions.title')
            ->leftJoin('users', 'users.id', '=', 'sessions.user_id')
            ->leftJoin('session_users', function($join) use ($userID) {
                $join->on('sessions.id', '=', 'session_users.session_id')
                    ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
                    ->whereNull('session_users.deleted_at');
            })
            ->whereHas('session_users', function($q){ $q->where('user_id', $this->user->id); })
            ->orWhere('sessions.program_id', $programID)
            ->whereNull('users.deleted_at')
            ->orderBy('sessions.title')
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $tags = CommitmentTag::pluck('name', 'id');
        $development_areas = DevelopmentArea::get();

        return view('candidate.commitment', compact('title', 'printBackBtn', 'candidate', 'program', 'candidateCommitment', 'session_users', 'tags', 'development_areas'));
    }

    public function profile()
    {
        abort_if(!$this->user->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $title = trans('candidate.titles.profile');

        $candidate = $this->candidate;
        $user      = $this->user;
        $program   = $candidate->program;
        $program->load('program_type');
        $program->loadCount('sessions');

        $candidateProgram = \App\Models\CandidateProgram::where('candidate_id', $candidate->id)->where('program_id', $program->id)->first();

        // edit profile - user related
        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = Language::pluck('name', 'id');
        $system_languages = Language::pluck('name', 'id')->prepend(trans('global.defaultLanguage'), '');

        // edit profile - candidate related
        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $tags = CandidateTag::pluck('name', 'id');
        $education_levels = EducationLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $professional_levels = ProfessionalLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $functional_areas = FunctionalArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $skills = Skill::pluck('name', 'id');
        $industry_sectors = IndustrySector::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $related_companies = Company::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('candidate.profile', compact('user', 'title', 'candidate', 'program', 'candidateProgram', 'companies', 'languages', 'system_languages', 'cities', 'tags', 'education_levels', 'professional_levels', 'functional_areas', 'skills', 'industry_sectors', 'related_companies', 'genders'));
    }

    public function profileUpdate(UpdateCandidateRequest $request, Candidate $candidate)
    {
        $candidate->update($request->only(['disability', 'immigrant', 'address', 'postalcode', 'profile', 'position', 'gender_id', 'city_id', 'education_level_id', 'industry_sector_id', 'functional_area_id', 'professional_level_id']));
        $candidate->tags()->sync($request->input('tags', []));
        $candidate->skills()->sync($request->input('skills', []));
        $candidate->related_companies()->sync($request->input('related_companies', []));

        $user = $candidate->user;
        if($user) {
            $user->update($request->only(['name', 'lastname', 'email', 'password', 'birthday', 'phone', 'government_number', 'passport', 'social_linkedin']));
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

        return back();
    }

    public function opportunities()
    {
        abort_if(!$this->user->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $title = 'Mis Oportunidades';

        return view('candidate.opportunities', compact('title'));
    }

    public function analytics()
    {
        abort_if(!$this->user->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        //Experience Points
        $userID      = $this->user->id;
        $candidateID = $this->candidate->id;
        $xpSession = Session::select('sessions.id', 'sessions.status', 'sessions.development_area_id', 'sessions.experience_points', 'session_users.attendance')
        ->join('session_users', function($join) use ($userID) {
            $join->on('sessions.id', '=', 'session_users.session_id')
                ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
                ->whereNull('session_users.deleted_at');
        })
        ->where('session_users.attendance', '1')
        ->whereNotNull('sessions.development_area_id')
        ->whereNotNull('sessions.experience_points')
        ->get();

        $xpCommitment = CandidateCommitment::where('candidate_id', $candidateID)
        ->where('complete', '1')
        ->whereNotNull('development_area_id')
        ->whereNotNull('experience_points')
        ->get();

        $xpEvent = EventCandidate::where('event_candidates.candidate_id', $candidateID)
        ->join('events', function($join) use ($userID) {
            $join->on('event_candidates.event_id', '=', 'events.id')
                ->whereNull('events.deleted_at');
        })
        ->where('event_candidates.attendance', '1')
        ->whereNotNull('events.development_area_id')
        ->whereNotNull('events.experience_points')
        ->get();

        $developmentAreas = DevelopmentArea::all();
        //Calcular puntos de experiencia
        $developmentAreas->map(function ($item) use ($xpSession, $xpCommitment, $xpEvent) {
            $count = 0;

            foreach($xpSession as $xpItem) {
                if($xpItem->development_area_id == $item['id']) {
                    $count = $count + $xpItem->experience_points;
                }
            }
            foreach($xpCommitment as $xpItem) {
                if($xpItem->development_area_id == $item['id']) {
                    $count = $count + $xpItem->experience_points;
                }
            }
            foreach($xpEvent as $xpItem) {
                if($xpItem->development_area_id == $item['id']) {
                    $count = $count + $xpItem->experience_points;
                }
            }

            $item['points'] = $count;
            return $item;
        });

        return view('candidate.analytics', compact('developmentAreas'));
    }

    public function event(Event $event=null)
    {
        abort_if(!$this->user->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $title = 'Detalles de Evento';
        $printBackBtn = true;
        if($event){
            //Seguridad: Sólo mostrar eventos al que puede asistir el candidato
            $candidate   = Auth::user()->candidate;
            $companyID   = $candidate->company_id ? $candidate->company_id : 0;
            $candidateID = $candidate->id;

            $ptList    = [];
            $prList    = [];
            $candidatePrograms = \App\Models\CandidateProgram::select('candidate_programs.program_id')->where('candidate_id', $candidateID)->with('program')->get();
            foreach($candidatePrograms as $programItem) {
                $ptList[] = $programItem->program->program_type_id;
                $prList[] = $programItem->program_id;
            }

            $eventsList = Event::select('events.id')
                ->orWhereHas('program_types', function($q) use ($ptList) {
                    $q->whereIn('id', $ptList);
                })
                ->orWhereHas('companies', function($q) use ($companyID) {
                    $q->whereIn('id', [$companyID]);
                })
                ->orWhereHas('programs', function($q) use ($prList) {
                    $q->whereIn('id', $prList);
                })
                ->orWhereHas('candidates', function($q) use ($candidateID) {
                    $q->whereIn('candidate_id', [$candidateID]);
                })
                ->pluck('id')->all();

            abort_if(!in_array($event->id, $eventsList), Response::HTTP_FORBIDDEN, '403 Forbidden');

            $event->load('user');
        }

        $attendance = '0';
        $candidateEvent = EventCandidate::where('event_id', $event->id)->where('candidate_id', $candidateID)->first();
        if($candidateEvent) {
            $attendance = (string) $candidateEvent->attendance;
        }

        return view('candidate.event', compact('title', 'printBackBtn', 'event', 'attendance'));
    }

    public function polls($pollID=null)
    {
        abort_if(!$this->user->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $title = 'Cuestionario de Empleabilidad';

        return view('candidate.polls', compact('title'));
    }
}
