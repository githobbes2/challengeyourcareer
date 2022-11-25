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

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h1>Informe Programa</h1>
                    <div class="row mt-4">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.program.fields.name') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $program->name }}</p>
                        </div>
                    </div>
                    <hr>
                    @if($program->program_type)
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.program.fields.program_type') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $program->program_type->name }}</p>
                        </div>
                    </div>
                    <hr>
                    @endif
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.program.fields.user') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $program->user->name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.program.fields.individual') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ App\Models\Program::INDIVIDUAL_RADIO[$program->individual] }}</p>
                        </div>
                    </div>
                    <hr>
                    @if($program->company)
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.program.fields.company') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $program->company->name }}</p>
                        </div>
                    </div>
                    <hr>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body infobox-1">
                    <div class="infobox-1-item-wrapper">
                        <div class="infobox-1-data-primary">
                            <span class="infobox-1-title">{{ $sessionCount }}</span>
                        </div>
                        <div class="infobox-1-text-info">
                            <span class="infobox-1-title">Sesiones registradas</span>
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
                </div>
            </div>
            <div class="card">
                <div class="card-body infobox-1">
                    <div class="infobox-1-item-wrapper">
                        <div class="infobox-1-data-primary">
                            <span class="infobox-1-title">{{ $candidateCount }}</span>
                        </div>
                        <div class="infobox-1-text-info">
                            <span class="infobox-1-title">Candidatos</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body infobox-1">
                    <div class="infobox-1-item-wrapper">
                        <div class="infobox-1-data-primary">
                            <span class="infobox-1-title">{{ $jobOfferCount }}</span>
                        </div>
                        <div class="infobox-1-text-info">
                            <span class="infobox-1-title">Ofertas de Trabajo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="mb-4">Sesiones</h3>
                    @foreach ($program->sessions as $session)
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ $session->title }}</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="text-muted mb-0">{{ $session->start_time }}</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="text-muted mb-0">{{ App\Models\Session::STATUS_RADIO[$session->status] ?? '' }}</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="text-muted mb-0">{{ count($session->session_users) + $candidateCount }} Candidatos</p>
                        </div>
                    </div>
                    @if(!$loop->last)
                    <hr>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="mb-4">Candidatos</h3>
                    @foreach ($program->programCandidatePrograms as $candidateProgram)
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-0">{{ $candidateProgram->candidate->full_name }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted mb-0">{{ App\Models\CandidateProgram::STATUS_RADIO[$candidateProgram->status] ?? '' }}</p>
                        </div>
                    </div>
                    @if(!$loop->last)
                    <hr>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.programs.dossier-pdf', [$program]) }}">
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
