<?php

namespace App\Http\Controllers\Admin;
use Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\Program;
use App\Models\Session;
use App\Models\Candidate;
use App\Models\DevelopmentArea;
use App\Models\CandidateCommitment;
use App\Models\EventCandidate;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $user = Auth::user();

        // -- ADMIN --
        if($user->is_admin) {
            $settings1 = [
                'chart_title'           => 'Sesiones registradas recientemente',
                'chart_type'            => 'latest_entries',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\Session',
                'group_by_field'        => 'created_at',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'count',
                'filter_field'          => 'created_at',
                'filter_days'           => '30',
                'group_by_field_format' => 'd/m/Y H:i:s',
                'column_class'          => 'col-md-6',
                'entries_number'        => '10',
                'fields'                => [
                    'title'      => '',
                    'start_time' => '',
                    'duration'   => '',
                    'user'       => 'name',
                ],
                'translation_key' => 'session',
            ];

            $settings1['data'] = [];
            if (class_exists($settings1['model'])) {
                $settings1['data'] = $settings1['model']::latest()
                    ->take($settings1['entries_number'])
                    ->get();
            }

            if (!array_key_exists('fields', $settings1)) {
                $settings1['fields'] = [];
            }

            $settings2 = [
                'chart_title'           => 'Ofertas de Empleo recientes',
                'chart_type'            => 'latest_entries',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\JobOffer',
                'group_by_field'        => 'date_start',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'count',
                'filter_field'          => 'created_at',
                'group_by_field_format' => 'd/m/Y',
                'column_class'          => 'col-md-6',
                'entries_number'        => '10',
                'fields'                => [
                    'title'           => '',
                    'city'            => 'name',
                    'program'         => 'name',
                    'functional_area' => 'name',
                    'industry_sector' => 'name',
                ],
                'translation_key' => 'jobOffer',
            ];

            $settings2['data'] = [];
            if (class_exists($settings2['model'])) {
                $settings2['data'] = $settings2['model']::latest()
                    ->take($settings2['entries_number'])
                    ->get();
            }

            if (!array_key_exists('fields', $settings2)) {
                $settings2['fields'] = [];
            }

            $settings3 = [
                'chart_title'           => 'Número de Candidatos registrados',
                'chart_type'            => 'number_block',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\Candidate',
                'group_by_field'        => 'created_at',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'count',
                'filter_field'          => 'created_at',
                'group_by_field_format' => 'd/m/Y H:i:s',
                'column_class'          => 'col-md-6',
                'entries_number'        => '5',
                'translation_key'       => 'candidate',
            ];

            $settings3['total_number'] = 0;
            if (class_exists($settings3['model'])) {
                $settings3['total_number'] = $settings3['model']::when(isset($settings3['filter_field']), function ($query) use ($settings3) {
                    if (isset($settings3['filter_days'])) {
                        return $query->where($settings3['filter_field'], '>=',
                    now()->subDays($settings3['filter_days'])->format('Y-m-d'));
                    }
                    if (isset($settings3['filter_period'])) {
                        switch ($settings3['filter_period']) {
                    case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                    case 'month': $start = date('Y-m') . '-01'; break;
                    case 'year': $start = date('Y') . '-01-01'; break;
                }
                        if (isset($start)) {
                            return $query->where($settings3['filter_field'], '>=', $start);
                        }
                    }
                })
                    ->{$settings3['aggregate_function'] ?? 'count'}($settings3['aggregate_field'] ?? '*');
            }

            return view('home', compact('settings1', 'settings2', 'settings3'));
        }

        // -- CONSULTOR --
        if($user->is_consultant) {
            $programs = Program::with(['program_type', 'user', 'company'])->where('user_id', $user->id)->get();
            $sessions = Session::with(['user', 'session_type', 'program', 'company'])->where('user_id', $user->id)->get();
            $candidates = Candidate::with(['user', 'company', 'city', 'tags', 'education_level', 'professional_level', 'functional_area', 'industry_sector'])
                ->where('created_by', $user->id)
                ->get();

            return view('consultant-home', compact('programs', 'sessions', 'candidates'));
        }

        // -- CANDIDATO --
        if($user->is_candidate) {
            return redirect()->route('admin.candidate.program.show');
        }


    }
}
