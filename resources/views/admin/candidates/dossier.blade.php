@extends('layouts.admin')

@section('content')
<section>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    <a href="#" onclick="window.history.back();" class="btn btn-sm btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 text-center mt-3">
                    <img src="{{ $candidate->user->photo_default->preview }}" class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-1">{{ $candidate->full_name }}</h5>
                    <p class="text-muted mb-3">{{ $candidate->company->name ?? '' }}</p>
                    <h6 class="mb-1">{{ $candidate->program->name ?? '' }}</h6>
                    <p class="text-muted mb-4">
                        @if($candidate->employability_score)
                        {{ trans('cruds.candidate.fields.employability_score') }}: {{ $candidate->employability_score }} <span class="small">({{ $candidate->employability_score_date }})</span>
                        @else
                        <em>{{ trans('cruds.candidate.fields.no_employability_score') }}</em>
                        @endif
                    </p>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.user.fields.name') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $candidate->full_name ?? '' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.candidateProgram.fields.program') }}</p>
                        </div>
                        <div class="col-sm-9">
                            @if($candidate->program)
                            <p class="text-muted mb-0">{{ $candidate->program->name ?? '' }}</p>
                            @else
                            <p class="text-muted mb-0">{{ trans('cruds.candidate.program_null') }}</p>
                            @endif
                        </div>
                    </div>
                    @if($candidate->program)
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.program.fields.program_type') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $candidate->program->program_type->name ?? '' }}</p>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.candidate.fields.company') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $candidate->company->name ?? '' }}</p>
                        </div>
                    </div>
                    @if($candidate->candidateProgram)
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.candidateProgram.fields.program_start_date') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $candidate->candidateProgram->program_start_date ?? '' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.candidateProgram.fields.status') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ App\Models\CandidateProgram::STATUS_RADIO[$candidate->candidateProgram->status] ?? '' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card-deck">
        <div class="card border-primary">
            <div class="card-header bg-primary"><i class="fa-fw nav-icon far fa-calendar-check"></i> Sesiones</div>
            <div class="card-body infobox-1">
                <div class="infobox-1-item-wrapper">
                    <div class="infobox-1-data-primary">
                        <span class="infobox-1-title">{{ $sessionCount }}</span>
                    </div>
                    <div class="infobox-1-text-info">
                        <span class="infobox-1-title">Sesiones creadas</span>
                    </div>
                </div>
                <div class="infobox-1-item-wrapper">
                    <div class="infobox-1-data-primary">
                        <span class="infobox-1-title">{{ $sessionCompleteCount }}</span>
                    </div>
                    <div class="infobox-1-text-info">
                        <span class="infobox-1-title">Sesiones realizadas</span>
                    </div>
                </div>
                <div class="infobox-1-item-wrapper">
                    <div class="infobox-1-data-primary">
                        <span class="infobox-1-title">{{ $sessionMissingCount }}</span>
                    </div>
                    <div class="infobox-1-text-info">
                        <span class="infobox-1-title">Reagendadas, rechazadas ó canceladas</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-primary">
            <div class="card-header bg-primary"><i class="fa-fw nav-icon fas fa-check-double"></i> Compromisos</div>
            <div class="card-body infobox-1">
                <div class="infobox-1-item-wrapper">
                    <div class="infobox-1-data-primary">
                        <span class="infobox-1-title">{{ $commitmentCount }}</span>
                    </div>
                    <div class="infobox-1-text-info">
                        <span class="infobox-1-title">Compromisos creados</span>
                    </div>
                </div>
                <div class="infobox-1-item-wrapper">
                    <div class="infobox-1-data-primary">
                        <span class="infobox-1-title">{{ $commitmentCompleteCount }}</span>
                    </div>
                    <div class="infobox-1-text-info">
                        <span class="infobox-1-title">Completados</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-primary">
            <div class="card-header bg-primary"><i class="fa-fw nav-icon fas fa-calendar-alt"></i> Eventos</div>
            <div class="card-body infobox-1">
                <div class="infobox-1-item-wrapper">
                    <div class="infobox-1-data-primary">
                        <span class="infobox-1-title">{{ $eventCount }}</span>
                    </div>
                    <div class="infobox-1-text-info">
                        <span class="infobox-1-title">Eventos asistidos</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-primary">
            <div class="card-header bg-primary"><i class="fa-fw nav-icon fas fa-briefcase"></i> Oportunidades</div>
            <div class="card-body infobox-1">
                <div class="infobox-1-item-wrapper">
                    <div class="infobox-1-data-primary">
                        <span class="infobox-1-title">{{ $jobOfferCount }}</span>
                    </div>
                    <div class="infobox-1-text-info">
                        <span class="infobox-1-title">Oportunidades vinculadas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.candidates.dossier-pdf', [$candidate]) }}">
                @csrf
                <div class="form-group">
                    <label for="note">Información Cualitativa</label>
                    <textarea class="form-control" name="note" id="note">{{ old('note') }}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.buttons.pdf_export') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
