<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Company;
use App\Models\DevelopmentArea;
use App\Models\Event;
use App\Models\Program;
use App\Models\ProgramType;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\EventCandidate;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::with(['user', 'program_types', 'companies', 'programs', 'development_area'])->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //Solo usuarios que son consultores
        $users = User::select(DB::raw('CONCAT(name, \' \', COALESCE(lastname,\'\')) AS name'), 'id')
        ->whereHas('roles', function($q){ $q->where('id', config('enums.roles.consultant')); })
        ->orderBy('name')
        ->get()
        ->pluck('name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

        $program_types = ProgramType::pluck('name', 'id');
        $companies = Company::pluck('name', 'id');
        $programs = Program::pluck('name', 'id');
        $development_areas = DevelopmentArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.events.create', compact('companies', 'development_areas', 'program_types', 'programs', 'users'));
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create(array_merge($request->all(), ['experience_points' => config('global.experience.event')]));
        $event->program_types()->sync($request->input('program_types', []));
        $event->companies()->sync($request->input('companies', []));
        $event->programs()->sync($request->input('programs', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $event->id]);
        }

        return redirect()->route('admin.events.index');
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $program_types = ProgramType::pluck('name', 'id');
        $companies = Company::pluck('name', 'id');
        $programs = Program::pluck('name', 'id');
        $development_areas = DevelopmentArea::pluck('name', 'id');
        $event->load('user', 'program_types', 'companies', 'programs', 'development_area');

        return view('admin.events.edit', compact('companies', 'development_areas', 'event', 'program_types', 'programs', 'users'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->all());
        $event->program_types()->sync($request->input('program_types', []));
        $event->companies()->sync($request->input('companies', []));
        $event->programs()->sync($request->input('programs', []));

        return redirect()->route('admin.events.index');
    }

    // HBS 2022.10 Método exclusivo para candidatos
    public function updateAttendance(Request $request, Event $event)
    {
        abort_if(!Auth::user()->is_candidate, Response::HTTP_FORBIDDEN, '403 Forbidden');

        //Seguridad: Sólo aceptar asistencia para eventos a los que puede asistir un candidato
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

        $candidateEvent = EventCandidate::firstOrNew(['candidate_id' => $candidateID, 'event_id' => $event->id]);
        if($candidateEvent->attendance != $request->attendance) {
            $candidateEvent->attendance = $request->attendance;
            $candidateEvent->save();
        }

        return back();
    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->load('user', 'program_types', 'companies', 'programs', 'development_area', 'candidates');

        return view('admin.events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventRequest $request)
    {
        Event::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('event_create') && Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Event();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
