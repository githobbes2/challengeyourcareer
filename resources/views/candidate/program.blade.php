@extends('layouts.app-candidate')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="{{ asset('css/select2.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection

@section('content')
<div class="section">
<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body">
                <h2>{{ $program ? $program->name : trans('cruds.candidate.program_null_short') }}</h2>
                <div class="row pb-2">
                    <div class="col-6">
                        <p class="mb-0">Estado</p>
                        <h4>{{ $candidateProgram ? (App\Models\CandidateProgram::STATUS_RADIO[$candidateProgram->status] ?? '') : '' }}</h4>

                        @if($program)
                        @if($program->session_template_count > 0)
                        <p class="mb-0">Mi nivel de avance en el programa</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $candidate->program_completion>0 ? $candidate->program_completion : '3' }}%;" aria-valuenow="{{ $candidate->program_completion }}" aria-valuemin="0" aria-valuemax="100">{{ $candidate->program_completion }}%</div>
                        </div>
                        @endif
                        @endif
                    </div>
                    <div class="col-6">
                        @foreach($developmentAreas as $key => $developmentArea)
                        <h3 class="mb-0 {{ $loop->first ? '' : 'mt-1'}}">{{ $developmentArea->name }}</h3>
                        <span>{{ $developmentArea->points }} exp</span>
                        @endforeach
                    </div>
                </div>
                @if($program)
                <div class="row text-center">
                    <div class="col-sm-4">
                        <a href="#ViewRecord" type="button" class="btn btn-outline-primary btn-block mt-1 mb-1" data-toggle="modal" data-target="#ViewRecord">Detalles del Programa</a>
                    </div>
                    <!-- div class="col-sm-4">
                        @if(Auth::user()->candidate->program->program_type->outplacement)
                        <a href="{{ route('admin.candidate.poll.show') }}" type="button" class="btn btn-outline-primary btn-block mt-1 mb-1">Cuestionario de Empleabilidad</a>
                        @endif
                    </div -->
                    <!-- div class="col-sm-4">
                        <a href="{{ route('admin.candidate.opportunities.show') }}" type="button" class="btn btn-outline-primary btn-block mt-1 mb-1">Mis Oportunidades</a>
                    </div -->
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body">
                <ul class="nav nav-tabs lined" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#sessionsTab" role="tab"><h3 class="text-primary">Sesiones ({{ $sessions->count() }})</h3></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#commitmentsTab" role="tab"><h3 class="text-primary">Compromisos ({{ $commitments->count() }})</h3></a>
                    </li>
                </ul>
                <div class="tab-content mt-2">
                    <div class="tab-pane fade show active" id="sessionsTab" role="tabpanel">
                        <div class="row">
                            @forelse($sessions as $key => $session)
                            <div class="col-md-6">
                            <div class="card mb-1">
                            <div class="card-body">
                                @if($session->attendance)
                                <ion-icon class="float-right text-success h3" name="checkmark-outline"></ion-icon>
                                @endif
                                <h5 class="card-title">{{ $session->title }}</h5>
                                <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="person-outline"></ion-icon> {{ $session->name ?? '' }}</h6>
                                <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="flag-outline"></ion-icon> <em>{{ App\Models\Session::STATUS_RADIO[$session->status] ?? '' }}</em></h6>
                                <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="calendar-outline"></ion-icon> {{ $session->start_time ?? '' }}</h6>

                                @can('session_show')
                                <a class="btn btn-xs btn-primary float-right" href="{{ route('admin.candidate.session.show', $session->id) }}">{{ trans('global.details') }}</a>
                                @endcan
                            </div>
                            </div>
                            </div>
                            @empty
                            <div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane fade" id="commitmentsTab" role="tabpanel">
                        <div class="row">
                            <div class="col">
                            <button type="button" class="btn btn-sm btn-outline-primary mt-1 mb-1 float-right" data-toggle="modal" data-target="#NewCommitment">Nuevo Compromiso</button>
                            </div>
                        </div>
                        <div class="row">
                            @forelse($commitments as $key => $commitment)
                            <div class="col-md-6">
                            <div class="card mb-1">
                            <div class="card-body">
                                <h5 class="card-title">{{ $commitment->title }}</h5>
                                @foreach($commitment->tags as $key => $tag)
                                    <span class="badge badge-info">{{ $tag->name }}</span>
                                @endforeach

                                @if($commitment->session_user)
                                <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="book-outline"></ion-icon> {{ $commitment->session_user->session->title }}</h6>
                                @endif

                                @if($commitment->complete)
                                <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="checkbox-outline"></ion-icon> Completado</h6>
                                @else
                                <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="square-outline"></ion-icon> Sin Completar</h6>
                                @endif

                                @if($commitment->completion_date)
                                <h6 class="card-subtitle mt-1 mb-1"><ion-icon name="calendar-outline"></ion-icon> {{ $commitment->completion_date }}</h6>
                                @endif

                                @can('candidate_commitment_show')
                                <a class="btn btn-xs btn-primary float-right" href="{{ route('admin.candidate.commitment.show', $commitment) }}">{{ trans('global.details') }}</a>
                                @endcan
                            </div>
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

<!-- Record Details -->
<div class="modal fade modalbox" id="ViewRecord" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Programa</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.close') }}</a>
            </div>
            <div class="modal-body">
                <div class="card card-default">
                    <div class="card-body">
                        @if($program)
                        <h3 class="mb-2 text-center">{{ $program->name ?? '' }}</h3>
                        <hr>
                        @if($candidateProgram)
                        <div class="row">
                            <div class="col-md-4"><p class="mb-0">{{ trans('cruds.candidateProgram.fields.status') }}</p></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ App\Models\CandidateProgram::STATUS_RADIO[$candidateProgram->status] ?? '' }}</p></div>
                        </div>
                        <hr>
                        @endif
                        @if($program->program_type)
                        <div class="row">
                            <div class="col-md-4"><p class="mb-0">{{ trans('cruds.program.fields.program_type') }}</p></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $program->program_type->name ?? '' }}</p></div>
                        </div>
                        <hr>
                        @endif
                        <div class="row">
                            <div class="col-md-4"><p class="mb-0">{{ trans('global.session_count') }}</p></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $program->sessions_count ?? '' }}</p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4"><p class="mb-0">{{ trans('global.consultant_in_charge') }}</p></div>
                            <div class="col-md-8"><p class="text-muted mb-0">{{ $program->user->name ?? '' }}</p></div>
                        </div>
                        <hr>
                        @if($candidateProgram->program_start_date)
                        <div class="row">
                            <div class="col-md-4"><p class="mb-0">{{ trans('candidate.profile.program_dates') }}</p></div>
                            <div class="col-md-8"><p class="text-muted mb-0">
                                @if($candidateProgram->program_end_date)
                                {{ trans('global.from_date') . ' ' . $candidateProgram->program_start_date . ' ' . trans('global.to_date') . ' ' . $candidateProgram->program_end_date }}
                                @else
                                {{ trans('candidate.profile.start_date') . ' ' . $candidateProgram->program_start_date }}
                                @endif
                            </p></div>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Record Details -->

<!-- New Commitment -->
<div class="modal fade modalbox" id="NewCommitment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Compromiso</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route("admin.candidate-commitments.store") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-default">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="title">{{ trans('cruds.candidateCommitment.fields.title') }}</label>
                                        <input class="form-control" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.title_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="session_user_id">{{ trans('cruds.candidateCommitment.fields.session_user') }}</label>
                                        <select class="form-control select2 {{ $errors->has('session_user') ? 'is-invalid' : '' }}" name="session_user_id" id="session_user_id">
                                            @foreach($session_users as $id => $entry)
                                                <option value="{{ $id }}" {{ old('session_user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('session_user'))
                                            <span class="text-danger">{{ $errors->first('session_user') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.session_user_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="completion_date">{{ trans('cruds.candidateCommitment.fields.completion_date') }}</label>
                                        <input class="form-control date" type="text" name="completion_date" id="completion_date" value="{{ old('completion_date') }}">
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.completion_date_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pt-md-4">
                                        <div class="form-check pt-md-1">
                                            <input type="hidden" name="complete" value="0">
                                            <input class="form-check-input" type="checkbox" name="complete" id="complete" value="1" {{ old('complete', 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="complete">{{ trans('cruds.candidateCommitment.fields.complete') }}</label>
                                        </div>
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.complete_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="required no-margin-bottom">{{ trans('cruds.candidateCommitment.candidate_fields.development_area') }}</label><br>
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.candidate_fields.development_area_helper') }}</span>
                                        <div class="row display-flex pt-1">
                                        @foreach($developmentAreas as $area)
                                            <div class="col-sm-4 mb-1">
                                                <div class="cards-1">
                                                <label class="no-margin-bottom" style="min-height:130px">
                                                <div class="row">
                                                    <div class="col-1 col-sm-2 text-center">
                                                        <input id="development_area_id" value="{{ $area->id }}" type="radio" name="development_area_id" {{ old('development_area_id', '0') === (string) $area->id ? 'checked' : '' }} required>
                                                    </div>
                                                    <div class="col-11 col-sm-10">
                                                        <h3 class="no-maring-top">{{ $area->name }}</h3>
                                                        <p class="small no-margin-bottom">{{ $area->description ?? ' ' }}</p>
                                                    </div>
                                                </div>
                                                </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="note">{{ trans('cruds.candidateCommitment.fields.note') }}</label>
                                        <textarea class="form-control" name="note" id="note">{{ old('note') }}</textarea>
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.note_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comments">{{ trans('cruds.candidateCommitment.fields.comments') }}</label>
                                        <textarea class="form-control" name="comments" id="comments">{{ old('comments') }}</textarea>
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.comments_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tags">{{ trans('cruds.candidateCommitment.fields.tag') }}</label>
                                        <div style="padding-bottom: 4px">
                                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                        </div>
                                        <select class="form-control select2" name="tags[]" id="tags" multiple>
                                            @foreach($tags as $id => $tag)
                                                <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.tag_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                                <a href="javascript:;" data-dismiss="modal" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- * New Commitment -->
@endsection
