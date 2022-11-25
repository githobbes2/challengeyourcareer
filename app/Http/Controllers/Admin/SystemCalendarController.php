<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class SystemCalendarController extends Controller
{
    public $sources = [
        [
            'model'      => '\App\Models\Session',
            'date_field' => 'start_time',
            'field'      => 'title',
            'prefix'     => '',
            'suffix'     => '',
            'route'      => 'admin.sessions.show',
        ],
        [
            'model'      => '\App\Models\Event',
            'date_field' => 'start_time',
            'field'      => 'title',
            'prefix'     => '',
            'suffix'     => '',
            'route'      => 'admin.events.show',
        ],
        [
            'model'      => '\App\Models\User',
            'date_field' => 'birthday',
            'field'      => 'name',
            'prefix'     => '',
            'suffix'     => 'cumpleaños',
            'route'      => 'admin.users.show',
        ],
        [
            'model'      => '\App\Models\CandidateCommitment',
            'date_field' => 'completion_date',
            'field'      => 'title',
            'prefix'     => '',
            'suffix'     => '',
            'route'      => 'admin.candidate-commitments.show',
        ],
    ];

    public function index()
    {
        $events = [];

        if(Auth::user()->is_candidate && !Auth::user()->is_admin) {

            //-- CANDIDATES --

            $userID      = Auth::user()->id;
            $candidate   = Auth::user()->candidate;
            $programID   = 0;
            $candidateID = 0;
            $companyID   = 0;
            if($candidate) {
                $companyID   = $candidate->company_id ? $candidate->company_id : 0;
                $candidateID = $candidate->id;
                $program     = $candidate->program;
                $programID   = $program ? $program->id : 0;
            }

            //Sesiones
            $sessions = \App\Models\Session::select('sessions.id', 'sessions.title', 'sessions.status', 'sessions.start_time', 'users.name')
            ->leftJoin('users', 'users.id', '=', 'sessions.user_id')
            ->leftJoin('session_users', function($join) use ($userID) {
                $join->on('sessions.id', '=', 'session_users.session_id')
                    ->on('session_users.user_id', '=', DB::raw("'".$userID."'"))
                    ->whereNull('session_users.deleted_at');
            })
            ->orWhere('sessions.program_id', $programID)
            ->whereNull('users.deleted_at')
            ->whereNotNull('sessions.start_time')
            ->get();

            foreach ($sessions as $item) {
                $events[] = [
                    'title' => $item->title,
                    'start' => $item->getAttributes()['start_time'],
                    'url'   => route('admin.candidate.session.show', $item->id),
                ];
            }
            unset($sessions);

            //Eventos
            $ptList    = [];
            $prList    = [];
            $candidatePrograms = \App\Models\CandidateProgram::select('candidate_programs.program_id')->where('candidate_id', $candidateID)->with('program')->get();
            foreach($candidatePrograms as $programItem) {
                $ptList[] = $programItem->program->program_type_id;
                $prList[] = $programItem->program_id;
            }
            $eventsList = \App\Models\Event::select('events.id', 'events.title', 'events.start_time', 'events.duration', 'events.user_id', 'users.name')
                ->leftJoin('users', function($join) {
                    $join->on('users.id', '=', 'events.user_id')
                    ->whereNull('users.deleted_at');
                })
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
                ->get();

            foreach ($eventsList as $item) {
                $events[] = [
                    'title' => $item->title,
                    'start' => $item->getAttributes()['start_time'],
                    'url'   => route('admin.candidate.event.show', $item->id),
                ];
            }

            //Compromisos
            $commitments = \App\Models\CandidateCommitment::select('id', 'title', 'completion_date')
                ->where('candidate_id', $candidateID)
                ->whereNotNull('completion_date')
                ->get();

            foreach ($commitments as $item) {
                $events[] = [
                    'title' => $item->title,
                    'start' => $item->getAttributes()['completion_date'],
                    'url'   => route('admin.candidate.commitment.show', $item->id),
                ];
            }
            unset($commitments);

            //--

            $title = 'Calendario';
            return view('candidate.calendar', compact('events', 'title', 'eventsList'));

        }
        else
        {
            //-- Admin and Consultants --

            foreach ($this->sources as $source) {
                foreach ($source['model']::all() as $model) {
                    $crudFieldValue = $model->getAttributes()[$source['date_field']];
                    if (!$crudFieldValue) {continue;}
                    $route = $source['route'];

                    $events[] = [
                        'title' => trim($source['prefix'] . ' ' . $model->{$source['field']} . ' ' . $source['suffix']),
                        'start' => $crudFieldValue,
                        'url'   => route($route, $model->id),
                    ];
                }
            }

            return view('admin.calendar.calendar', compact('events'));
        }
    }
}
