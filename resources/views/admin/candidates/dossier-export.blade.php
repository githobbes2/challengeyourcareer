@extends('layouts.export-pdf')

@section('styles')
<style>
div.col-row {
    height: 16px;
    clear: both;
}
div.col-header {
    width: 240px;
    float: left;
}
div.col-data   {
    width: 600px;
    float: left;
}
hr {
    margin-bottom: 4px !important;
}
</style>
@endsection

@section('header')
<p class="m-0" style="font-size:30px">Informe Candidato</p>
<p class="m-0">Fecha: {{ Carbon\Carbon::now()->isoFormat('D/M/YYYY') }}</p>
@endsection

@section('content')
<section>
    <div class="card mb-3">
        <div class="card-body">
            <div class="mt-3 ml-2">
                <div style="float:left; width: 150px;"><img src="{{ $candidate->user->photo_default->preview }}" class="rounded-circle img-fluid" style="width: 150px;"></div>
                <div class="ml-4" style="float:left; margin-top:52px"><p class="mb-0" style="font-size:24px">{{ $candidate->full_name ?? '' }}</p></div>
            </div>

            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.candidateProgram.fields.program') }}</p>
                </div>
                <div class="col-data">
                    @if($candidate->program)
                    <p class="text-muted mb-0">{{ $candidate->program->name ?? '' }}</p>
                    @else
                    <p class="text-muted mb-0">{{ trans('cruds.candidate.program_null') }}</p>
                    @endif
                </div>
            </div>
            @if($candidate->program)
            <hr>
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.program.fields.program_type') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ $candidate->program->program_type->name ?? '' }}</p>
                </div>
            </div>
            @endif
            <hr>
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.candidate.fields.company') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ $candidate->company->name ?? '' }}</p>
                </div>
            </div>
            @if($candidate->candidateProgram)
            <hr>
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.candidateProgram.fields.program_start_date') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ $candidate->candidateProgram->program_start_date ?? '' }}</p>
                </div>
            </div>
            <hr>
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.candidateProgram.fields.status') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ App\Models\CandidateProgram::STATUS_RADIO[$candidate->candidateProgram->status] ?? '' }}</p>
                </div>
            </div>
            <hr>
            @endif
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">Score de Empleabilidad</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">
                    @if($candidate->employability_score)
                    {{ $candidate->employability_score }} <span class="small">({{ $candidate->employability_score_date }})</span>
                    @else
                    <em>{{ trans('cruds.candidate.fields.no_employability_score') }}</em>
                    @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-left:0; font-size:15px !important">
        <div class="card mb-3" style="width:226px; float:left">
            <div class="card-body">
                <strong style="font-size:20px; margin-right:8px;">{{ $sessionCount }}</strong> Sesiones creadas
                <hr>
                <strong style="font-size:20px; margin-right:8px;">{{ $sessionCompleteCount }}</strong> Sesiones realizadas
                <hr>
                <strong style="font-size:20px; margin-right:8px;">{{ $sessionMissingCount }}</strong> Reagendadas, rechazadas ó canceladas
            </div>
        </div>
        <div class="card mb-3" style="width:226px; float:left; margin:0 15px">
            <div class="card-body">
                <strong style="font-size:20px; margin-right:8px;">{{ $commitmentCount }}</strong> Compromisos creados
                <hr>
                <strong style="font-size:20px; margin-right:8px;">{{ $commitmentCompleteCount }}</strong> Completados
            </div>
        </div>
        <div class="mb-3" style="width:226px; float:left">
            <div class="card mb-3">
                <div class="card-body">
                    <strong style="font-size:20px; margin-right:8px;">{{ $eventCount }}</strong> Eventos asistidos
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <strong style="font-size:20px; margin-right:8px;">{{ $jobOfferCount }}</strong> Oportunidades vinculadas
                </div>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>

    @if($note)
    <div class="card mb-3">
        <div class="card-body">
            <div class="mb-2"><strong>Información Cualitativa</strong></div>
            <p><em>{!! nl2br($note) !!}</em></p>
        </div>
    </div>
    @endif

</section>

@endsection
