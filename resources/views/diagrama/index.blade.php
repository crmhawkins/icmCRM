@extends('layouts.app')

@section('titulo', 'Diagrama de Gantt')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
@endsection

@section('content')
    <div class="page-heading card" style="box-shadow: none !important" >
        <div class="page-title card-body">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Diagrama de Gantt</h3>
                    <p class="text-subtitle text-muted">Formulario para editar un dominio</p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dominios</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar dominio</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div id="chart_div"></div>

    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

google.charts.load('current', { 'packages': ['gantt'] });
google.charts.setOnLoadCallback(drawChart);

function parseDate(dateString) {
    if (!dateString) return null;
    const parts = dateString.split(/[- :]/);
    return new Date(parts[0], parts[1] - 1, parts[2], parts[3], parts[4], parts[5]);
}
function daysToMilliseconds(days) {
    return days * 24 * 60 * 60 * 1000;
}
function drawChart() {
    // var data = new google.visualization.DataTable();
    // data.addColumn('string', 'ID');
    // data.addColumn('string', 'Tarea');
    // data.addColumn('string', 'Recurso');
    // data.addColumn('date', 'Inicio');
    // data.addColumn('date', 'Fin');
    // data.addColumn('number', 'Duración');
    // data.addColumn('number', 'Progreso');
    // data.addColumn('string', 'Dependencias');

    // data.addRows([
    //     @foreach($datos['datos'] as $dato)
    //         [
    //             '{{ addslashes($dato['Tarea']) }}',
    //             '{{ addslashes($dato['Tarea']) }}',
    //             '{{ addslashes($dato['Proyecto']) }}',
    //             new Date('{{ $dato['Inicio'] }}'.replace(/-/g, '/')),
    //             new Date('{{ $dato['Fin'] }}'.replace(/-/g, '/')),
    //             {{ floatval($dato['Duración']) }},
    //             {{ floatval($dato['Progreso']) }},
    //             null
    //         ],
    //     @endforeach
    // ]);

    // var options = {
    //     height: 500,
    //     gantt: {
    //         trackHeight: 30,
    //         barHeight: 25,
    //         percentEnabled: true,
    //         showRowLabels: true,
    //         showTaskLabels: true,
    //         criticalPathEnabled: true,
    //         ganttViewOptions: {
    //             intervalUnit: 'hour'
    //         }
    //     },
    //     timeline: {
    //         groupByRowLabel: true,
    //         showBarLabels: true,
    //         rowLabelStyle: { fontSize: 12 },
    //         barLabelStyle: { fontSize: 10 },
    //         minValue: new Date('{{ $datos["minFechaInicio"] }}'.replace(/-/g, '/')),
    //         maxValue: new Date('{{ $datos["maxFechaFin"] }}'.replace(/-/g, '/'))
    //     }
    // };

    // var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
    // chart.draw(data, options);

    var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        [
            'Research',
            'Find sources',
            null,
            new Date(2015, 0, 1),
            new Date(2015, 0, 5),
            null,
            100,
            null
        ],
        [
            'Write',
            'Write paper',
            'write',
            null,
            new Date(2015, 0, 9),
            daysToMilliseconds(3),
            25,
            'Research,Outline'
        ],
        ['Cite', 'Create bibliography', 'write',
         null, new Date(2015, 0, 7), daysToMilliseconds(1), 20, 'Research'],
        ['Complete', 'Hand in paper', 'complete',
         null, new Date(2015, 0, 10), daysToMilliseconds(1), 0, 'Cite,Write'],
        ['Outline', 'Outline paper', 'write',
         null, new Date(2015, 0, 6), daysToMilliseconds(1), 100, 'Research']
      ]);

      var options = {
        height: 275
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
}

console.log("Datos enviados a Google Charts:", [
    @foreach($datos['datos'] as $dato)
        [
            '{{ addslashes($dato['Tarea']) }}',
            '{{ addslashes($dato['Tarea']) }}',
            '{{ addslashes($dato['Proyecto']) }}',
            '{{ $dato['Inicio'] }}',
            '{{ $dato['Fin'] }}',
            {{ floatval($dato['Duración']) }},
            {{ floatval($dato['Progreso']) }},
            null
        ],
    @endforeach
]);




</script>
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
<script>

</script>
@endsection
