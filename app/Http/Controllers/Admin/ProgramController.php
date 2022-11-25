<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProgramRequest;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Session;
use App\Models\Company;
use App\Models\Program;
use App\Models\ProgramType;
use App\Models\User;
use App\Models\Consultant;
use App\Models\SessionTemplate;
use App\Models\ServiceGroup;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ProgramController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('program_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $programs = Program::with(['program_type', 'user', 'company'])->withCount('sessions', 'programCandidatePrograms')->get();

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        abort_if(Gate::denies('program_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $program_types     = ProgramType::orderBy('name')->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $session_templates = SessionTemplate::orderBy('title')->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $service_groups    = ServiceGroup::orderBy('name')->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //Solo usuarios que son consultores
        $users = User::select(DB::raw('CONCAT(name, \' \', COALESCE(lastname,\'\')) AS name'), 'id')
        ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.consultant')); })
        ->orderBy('name')
        ->get()
        ->pluck('name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.programs.create', compact('companies', 'program_types', 'users', 'session_templates', 'service_groups'));
    }

    public function store(StoreProgramRequest $request)
    {
        $user = Auth::user();
        if($user->is_consultant && !$user->is_admin) {
            $request['user_id'] = $user->id;

            $program = Program::create($request->all());
            return redirect()->route('admin.home');
        }

        $program = Program::create($request->all());

        foreach ($request->input('attachments', []) as $file) {
            $program->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $program->id]);
        }

        return redirect()->route('admin.programs.index');
    }

    public function edit(Program $program)
    {
        abort_if(Gate::denies('program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $program_types     = ProgramType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $session_templates = SessionTemplate::orderBy('title')->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $service_groups    = ServiceGroup::orderBy('name')->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companies         = Company::orderBy('name')->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = User::select(DB::raw('CONCAT(name, \' \', COALESCE(lastname,\'\')) AS name'), 'id')
            ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.consultant')); })
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');

        $program->load('program_type', 'user', 'company');

        return view('admin.programs.edit', compact('companies', 'program', 'program_types', 'users', 'session_templates', 'service_groups'));
    }

    public function update(UpdateProgramRequest $request, Program $program)
    {
        $program->update($request->all());

        if (count($program->attachments) > 0) {
            foreach ($program->attachments as $media) {
                if (!in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }
        $media = $program->attachments->pluck('file_name')->toArray();
        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $program->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.programs.index');
    }

    public function show(Program $program)
    {
        abort_if(Gate::denies('program_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $program->load('program_type', 'user', 'company', 'programJobOffers', 'programCandidatePrograms', 'programsEvents', 'serviceGroup');

        return view('admin.programs.show', compact('program'));
    }

    public function destroy(Program $program)
    {
        abort_if(Gate::denies('program_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $program->delete();

        return back();
    }

    public function massDestroy(MassDestroyProgramRequest $request)
    {
        Program::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    //Only admin and consultants can view this
    public function getDossier(Program $program) {
        abort_if(Gate::denies('program_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if(!Auth::user()->is_consultant && !Auth::user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $program->load('sessions', 'user', 'program_type', 'company', 'programCandidatePrograms');

        $candidateCount       = 0;
        $sessionCount         = 0;
        $sessionCompleteCount = 0;
        $jobOfferCount        = 0;

        list($candidateCount, $sessionCount, $sessionCompleteCount, $jobOfferCount) = $this->getDossierData($program);

        return view('admin.programs.dossier', compact('program', 'candidateCount', 'sessionCount', 'sessionCompleteCount', 'jobOfferCount'));
    }

    public function exportDossier(Request $request, Program $program) {

        $note = $request->note;
        $program->load('sessions', 'user', 'program_type', 'company', 'programCandidatePrograms');

        $candidateCount       = 0;
        $sessionCount         = 0;
        $sessionCompleteCount = 0;
        $jobOfferCount        = 0;

        list($candidateCount, $sessionCount, $sessionCompleteCount, $jobOfferCount) = $this->getDossierData($program);

        $pdf = Pdf::setOption(['dpi' => 100])
            ->loadView('admin.programs.dossier-export', compact('note', 'program', 'candidateCount', 'sessionCount', 'sessionCompleteCount', 'jobOfferCount'));
        return $pdf->download('Informe_Programa.pdf');
    }

    private function getDossierData($program) {
        $program->loadCount('sessions', 'candidates', 'joboffers');
        $candidateCount = $program->candidates_count;
        $sessionCount   = $program->sessions_count;
        $jobOfferCount  = $program->joboffers_count;

        $sessionCompleteCount = Session::where('program_id', $program->id)
            ->where('status', 'd')->get()->count();

        //$sessions = $program->sessions;

        //Calcular detalles por cada sesion
        //$sessions->map(function ($item) use ($sessionCompleteCount) {
        //    if($item['status'] == 'd') {
        //        $sessionCompleteCount = $sessionCompleteCount + 1;
        //    }
        //
        //    //Obtener participantes adicionales en la sesion
        //    ...

        //    $item['points'] = $count;
        //    return $item;
        //});

        //$userID = $candidate->user_id;
        //$programID = 0;
        //if($candidate->program) {
        //    $programID = $candidate->program->id;
        //}
//
        //$sessions = Session::select('sessions.id', 'sessions.status', 'session_users.attendance')
        //    ->leftJoin('session_users', function($join) use ($userID) {
        //        $join->on('sessions.id', '=', 'session_users.session_id')
        //            ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
        //            ->whereNull('session_users.deleted_at');
        //    })
        //    ->whereHas('session_users', function($q) use($userID){ $q->where('user_id', $userID); })
        //    ->orWhere('sessions.program_id', $programID)
        //    ->orderByDesc('sessions.start_time')
        //    ->get();
        //if($sessions) {
        //    $sessionCount         = $sessions->count();
        //    $sessionCompleteCount = $sessions->where('attendance', '1')->count();
        //    $sessionMissingCount  = $sessions->whereIn('status', ['s','r','c'])->count();
        //}
//
        //$commitments = CandidateCommitment::where('program_id', $candidate->id)
        //    ->orderByDesc('created_at')
        //    ->get();
        //if($commitments) {
        //    $commitmentCount         = $commitments->count();
        //    $commitmentCompleteCount = $commitments->where('complete', '1')->count();
        //}
//
        //$eventCount = EventCandidate::where('program_id', $candidate->id)->where('attendance', '1')->get()->count();
//
        //$jobOfferCount = JobOfferCandidate::where('program_id', $candidate->id)->get()->count();

        //return  [$sessions, $candidateCount, $sessionCount, $sessionCompleteCount, $jobOfferCount];
        return  [$candidateCount, $sessionCount, $sessionCompleteCount, $jobOfferCount];
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('program_create') && Gate::denies('program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Program();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
