@extends('layouts.admin')

@section('styles')
@parent
<style>

.local-menu .dropdown-menu a:hover{
    background-color: #52585d !important;
    -webkit-transition: all 0.2s ease-in-out;
    -moz-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
}

.local-menu .dropdown-menu a {
  border: 1px solid rgba(0,0,0,.5);
  border-right: 0;
  border-left: 0;
  border-bottom: 0;
  border-radius: 0;
}

.local-menu .dropdown-menu a:first-of-type {
  border: 0;
}

</style>
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.dashboard') }}
                    <div class="local-menu float-right">
                        <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Alta
                        </button>
                        <div class="dropdown-menu bg-dark">
                            @can('candidate_create')
                            <a class="dropdown-item" href="{{ route('admin.candidates.create') }}">{{ trans('global.candidate') }}</a>
                            @endcan
                            @can('session_create')
                            <a class="dropdown-item" href="{{ route('admin.sessions.create') }}">{{ trans('global.session') }}</a>
                            @endcan
                            @can('program_create')
                            <a class="dropdown-item" href="{{ route('admin.programs.create') }}">{{ trans('global.program') }}</a>
                            @endcan
                            @can('event_create')
                            <a class="dropdown-item" href="{{ route('admin.events.create') }}">{{ trans('global.event') }}</a>
                            @endcan
                            @can('company_create')
                            <a class="dropdown-item" href="{{ route('admin.companies.create') }}">{{ trans('global.company') }}</a>
                            @endcan
                            @can('job_offer_create')
                            <a class="dropdown-item" href="{{ route('admin.job-offers.create') }}">{{ trans('global.jobOffer') }}</a>
                            @endcan
                        </div>
                        </div>

                        <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Seguimiento
                        </button>
                        <div class="dropdown-menu bg-dark">
                            @can('candidate_access')
                            <a class="dropdown-item" href="{{ route('admin.candidates.index') }}">{{ trans('cruds.candidate.title') }}</a>
                            @endcan
                            @can('session_access')
                            <a class="dropdown-item" href="{{ route('admin.sessions.index') }}">{{ trans('cruds.session.title') }}</a>
                            @endcan
                            @can('program_access')
                            <a class="dropdown-item" href="{{ route('admin.programs.index') }}">{{ trans('cruds.program.title') }}</a>
                            @endcan
                            @can('company_access')
                            <a class="dropdown-item" href="{{ route('admin.companies.index') }}">{{ trans('cruds.company.title') }}</a>
                            @endcan
                            @can('event_access')
                            <a class="dropdown-item" href="{{ route('admin.events.index') }}">{{ trans('cruds.event.title') }}</a>
                            @endcan
                            @can('job_offer_access')
                            <a class="dropdown-item" href="{{ route('admin.job-offers.index') }}">{{ trans('cruds.jobOffer.title') }}</a>
                            @endcan
                        </div>
                        </div>

                        <div class="btn-group">
                            <a class="btn btn-light" href="{{ route('admin.reports.index') }}">Reportes</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- local menu -->
                    <!-- div class="fab-button animate top-right dropdown">
                        <a href="#" class="fab" data-toggle="dropdown">
                            <ion-icon name="add-outline"></ion-icon>
                        </a>
                        <div class="dropdown-menu">
                            <div class="card bg-primary dropdown-item" style="width: 18rem; display:inline">
                                <div class="card-body">
                                <ul class="list-group list-group-flush bg-primary">
                                    @can('candidate_create')
                                    <a href="{{ route('admin.candidates.create') }}"><li class="list-group-item bg-primary">{{ trans('global.candidate') }}</li></a>
                                    @endcan
                                    @can('session_create')
                                    <a href="{{ route('admin.sessions.create') }}"><li class="list-group-item bg-primary">{{ trans('global.session') }}</li></a>
                                    @endcan
                                    @can('program_create')
                                    <a href="{{ route('admin.programs.create') }}"><li class="list-group-item bg-primary">{{ trans('global.program') }}</li></a>
                                    @endcan
                                    @can('company_create')
                                    <a href="{{ route('admin.companies.create') }}"><li class="list-group-item bg-primary">{{ trans('global.company') }}</li></a>
                                    @endcan
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div -->

                    <div class="row mb-3">
                        {{-- Programs --}}
                        <div class="col-md-6" style="overflow-x: auto;">
                            <h3>{{ trans('cruds.consultantDashboard.active_programs') }}</h3>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ trans('cruds.program.fields.name') }}</th>
                                        <th>{{ trans('cruds.program.fields.company') }}</th>
                                        <th>{{ trans('cruds.program.fields.candidate_count') }}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($programs as $key => $program)
                                        <tr>
                                            <th>{{ $program->name ?? '' }} {{ $program->internal_name ? '('.$program->internal_name.')' : '' }}</td>
                                            <td>{{ $program->company->name ?? '' }}</td>
                                            <td>{{ $program->programCandidatePrograms()->count() ?? '' }}</td>
                                            <td width="50">
                                                <div class="btn-group" role="group" aria-label="Acciones">
                                                    @can('program_show')
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.programs.show', $program->id) }}">{{ trans('global.view') }}</a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4"><div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Sessions --}}
                        <div class="col-md-6" style="overflow-x: auto;">
                            <h3>{{ trans('cruds.consultantDashboard.active_sessions') }}</h3>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ trans('cruds.session.fields.title') }}</th>
                                        <th>{{ trans('cruds.session.fields.program') }}</th>
                                        <th>{{ trans('global.date_time') }}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sessions as $key => $session)
                                        <tr>
                                            <th>{{ $session->title ?? '' }}</td>
                                            <td>{{ $session->program ? ($session->program->internal_name ? '('.$session->program->internal_name.')' : '') : '' }}</td>
                                            <td>{{ $session->start_time ?? '' }}</td>
                                            <td width="50">
                                                <div class="btn-group" role="group" aria-label="Acciones">
                                                    @can('session_show')
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sessions.show', $session->id) }}">{{ trans('global.view') }}</a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4"><div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Candidates --}}
                        <div class="col-md-12">
                            <h3>{{ trans('cruds.consultantDashboard.active_candidates') }}</h3>

                            <div class="row">
                                @forelse($candidates as $key => $candidate)
                                <div class="card ml-3 bg-info" style="width: 24rem;">
                                <div class="card-body">
                                    <table class="mb-2">
                                        <tbody>
                                            <tr>
                                            <td width="100" style="vertical-align:top">
                                                @if ($candidate->user)
                                                <img src="{{ $candidate->user->photo_default->preview }}" width="80px" height="80px" class="imaged rounded">
                                                @endif
                                            </th>
                                            <td>
                                                <h5 class="card-title">{{ $candidate->full_name }}</h5>
                                                <h6 class="card-subtitle mt-1 mb-1"><i class="fa-fw far fa-building mr-1"></i>{{ $candidate->company->name ?? '' }}</h6>
                                                <h6 class="card-subtitle mt-1 mb-1"><i class="fa-fw fas fa-book-open mr-1"></i><em>{{ $candidate->program ? $candidate->program->name : trans('cruds.candidate.program_null_short') }}</em></h6>
                                            </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    @foreach($candidate->tags as $key => $tag)
                                    <span class="badge badge-secondary">{{ $tag->name }}</span>
                                    @endforeach

                                    <h6 class="card-subtitle mt-1 mb-1">{{ trans('global.score') }}: {{ $candidate->employability_score ?? trans('cruds.candidate.fields.no_employability_score') }}</h6>
                                    <h6 class="card-subtitle mt-1 mb-1">{{ trans('global.experience') }}: -</h6>
                                    <!-- p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p -->
                                    @can('candidate_show')
                                    <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="btn btn-sm btn-primary position-bottom-right">{{ trans('global.details') }}</a>
                                    @endcan
                                </div>
                                </div>
                                @empty
                                <div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!-- Ionicons -->
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
@endsection
