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
div.col-S1   {
    width: 300px;
    float: left;
}
div.col-S2   {
    width: 140px;
    float: left;
}
div.col-S3   {
    width: 115px;
    float: left;
}
div.col-half   {
    width: 350px;
    float: left;
}
hr {
    margin-bottom: 4px !important;
}
</style>
@endsection

@section('header')
<p class="m-0" style="font-size:30px">Informe Programa</p>
<p class="m-0">Fecha: {{ Carbon\Carbon::now()->isoFormat('D/M/YYYY') }}</p>
@endsection

@section('content')
<section>
    <div class="card mb-3">
        <div class="card-body">
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.program.fields.name') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ $program->name ?? '' }}</p>
                </div>
            </div>
            <hr>
            @if($program->program_type)
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.program.fields.program_type') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ $program->program_type->name }}</p>
                </div>
            </div>
            <hr>
            @endif
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.program.fields.user') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ $program->user->name }}</p>
                </div>
            </div>
            <hr>
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.program.fields.individual') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ App\Models\Program::INDIVIDUAL_RADIO[$program->individual] }}</p>
                </div>
            </div>
            <hr>
            @if($program->company)
            <div class="col-row">
                <div class="col-header">
                    <p class="mb-0">{{ trans('cruds.program.fields.company') }}</p>
                </div>
                <div class="col-data">
                    <p class="text-muted mb-0">{{ $program->company->name }}</p>
                </div>
            </div>
            <hr>
            @endif
        </div>
    </div>

    <div class="row" style="margin-left:0; font-size:15px !important">
        <div class="card mb-3" style="width:228px; float:left; margin-right:15px">
            <div class="card-body">
                <strong style="font-size:20px; margin-right:8px;">{{ $sessionCount }}</strong> Sesiones registradas
                <hr>
                <strong style="font-size:20px; margin-right:8px;">{{ $sessionCompleteCount }}</strong> Sesiones realizadas
            </div>
        </div>
        <div class="mb-3" style="width:228px; float:left; margin-right:15px">
            <div class="card mb-3">
                <div class="card-body">
                    <strong style="font-size:20px; margin-right:8px;">{{ $candidateCount }}</strong> Candidatos
                </div>
            </div>
        </div>
        <div class="mb-3" style="width:228px; float:left">
            <div class="card mb-3">
                <div class="card-body">
                    <strong style="font-size:20px; margin-right:8px;">{{ $jobOfferCount }}</strong> Ofertas de Trabajo
                </div>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>


    <div class="card mb-3">
        <div class="card-body">
            <p class="m-0" style="font-size:20px; padding-bottom:10px"><strong>Sesiones</strong></p>
            <div style="clear:both"></div>
            @foreach ($program->sessions as $session)
            <div class="col-row">
                <div class="col-S1">
                    <p class="mb-0">{{ $session->title }}</p>
                </div>
                <div class="col-S2">
                    <p class="text-muted mb-0">{{ $session->start_time }}</p>
                </div>
                <div class="col-S3">
                    <p class="text-muted mb-0">{{ App\Models\Session::STATUS_RADIO[$session->status] ?? '' }}</p>
                </div>
                <div class="col-S3">
                    <p class="text-muted mb-0">{{ count($session->session_users) + $candidateCount }} Candidatos</p>
                </div>
            </div>
            <div style="clear:both"></div>
            @if(!$loop->last)
            <hr>
            @endif
            @endforeach
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p class="m-0" style="font-size:20px; padding-bottom:10px"><strong>Candidatos</strong></p>
            <div style="clear:both"></div>
            @foreach ($program->programCandidatePrograms as $candidateProgram)
            <div class="col-row">
                <div class="col-half">
                    <p class="mb-0">{{ $candidateProgram->candidate->full_name }}</p>
                </div>
                <div class="col-half">
                    <p class="text-muted mb-0">{{ App\Models\CandidateProgram::STATUS_RADIO[$candidateProgram->status] ?? '' }}</p>
                </div>
            </div>
            @if(!$loop->last)
            <hr>
            @endif
            @endforeach
        </div>
    </div>

    @if($note)
    <div class="card mb-3">
        <div class="card-body">
            <p class="m-0" style="font-size:20px; padding-bottom:10px"><strong>Información Cualitativa</strong></p>
            <div style="clear:both"></div>
            <p><em>{!! nl2br($note) !!}</em></p>
        </div>
    </div>
    @endif

</section>

@endsection
