@extends('layouts.app-candidate')

@section('content')
<div class="section">
    <div class="card">
        <div class="card-header">Analytics</div>
        <div class="card-body">
            <div class="pb-2 bb">
                <p>Mi nivel de avance en el programa:</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
            </div>

            <div class="mt-1 pb-2 bb">
                <p>Sesiones completadas:</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">(4/8)</div>
                </div>
            </div>

            <div class="mt-1 pb-2 bb">
                <p>Mi empleabilidad:</p>
                <span class="smaller">Inicial <em>(12 abr 2022)</em></span>
                <div class="progress mb-1">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">Alta</div>
                </div>
                <span class="smaller">Final (pendiente)</span>
                <div class="progress mb-1">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p>Evolución:</p>
            </div>

            <div class="mt-1 pb-2 bb">
                <p>Indicadores de la mejora de la empleabilidad:</p>
                <div class="row">
                    @foreach($developmentAreas as $key => $developmentArea)
                    <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $developmentArea->name }}</h5>
                            <span>{{ $developmentArea->points }} exp</span>
                        </div>
                    </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-1 pb-2 bb">
                <p>Compromisos completados:</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">(4/8)</div>
                </div>
            </div>

            <div class="mt-1 pb-2 bb">
                <p>Eventos atendidos:
                <span class="larger float-right mr-2"><strong>5</strong></span>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
