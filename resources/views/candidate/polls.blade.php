@extends('layouts.app-candidate')

@section('content')
<div class="section">
<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body">
                <p>Bienvenido al <strong>Cuestionario de Empleabilidad</strong>. El cuestionario que va a realizar está desarrollado a partir de la experiencia acumulada en la Gestión de Programas de Outplacement durante los últimos 25 años y está contrastado con las respuestas de 700 profesionales que han desarrollado estos programas en los últimos años.</p>
                <p>El cuestionario es una orientación y debe ser, necesariamente, validado por un Consultor especializado en la Gestión de la Carrera Profesional mediante una entrevista personal.</p>
                <p>El Cuestionario consta de <strong>11 preguntas</strong> sobre su perfil y trayectoria profesional y le devolverá un indicador de su nivel de empleabilidad. Se entiende <strong>empleabilidad</strong> como el tiempo medio que un profesional tiene que dedicar a encontrar una nueva posición en el mercado laboral.</p>

                <p>La puntuación final se pondera del 0 al 2.5 y tiene una correspondencia con:</p>
                <ul>
                 <li><span class="">Empleabilidad Alta:</span> Menos de 3 meses</li>
                 <li><span class="">Empleabilidad Media/Alta:</span> Entre 3 y 6 meses</li>
                 <li><span class="">Empleabilidad Media:</span> Entre 6 y 9 meses</li>
                 <li><span class="">Empleabilidad Media/Baja:</span> Entre 9 y 12 meses</li>
                 <li><span class="">Empleabilidad Baja:</span> Más de 12 meses</li>
                </ul>
                <p>La <strong>empleabilidad</strong> se puede mejorar, por lo que la respuesta al cuestionario le permitirá obtener un itinerario de trabajo para conseguir mejorarla y si además quiere que le ayudemos obtendrá una orientación de la inversión necesaria.</p>
                <p>Tiempo de cumplimentación del Cuestionario: 3 minutos</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6 text-center">
        <button type="button" class="btn btn-outline-secondary btn-block mt-1 mb-1" onclick="window.history.back();">{{ trans('global.cancel') }}</button>
    </div>
    <div class="col-6 text-center">
        <button type="button" class="btn btn-primary btn-block mt-1 mb-1">{{ trans('global.start') }}</button>
    </div>
</div>
</div>
@endsection
