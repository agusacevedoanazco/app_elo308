@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.eventos.index') }}">Eventos</a></li>
        @isset($evento)
            <li class="breadcrumb-item"><a href="{{route('admin.eventos.show',$evento->id)}}">{{$evento->titulo}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Analíticas</li>
        @endisset
    </ol>
@endsection

@section('content')
    @isset($evento)
        <div class="text-center mb-4">
            <h1>{{$evento->titulo}}</h1>
            <h5 class="text-muted">{{$evento->curso->nombre}} - {{$evento->curso->oc_series_name}}</h5>
        </div>
        @isset($totalstats,$timeseries,$bounce)
            <div class="card-deck row">
                <div class="card col rounded">
                    <div class="card-body">
                        <h5 class="card-title">Total de Visualizaciones</h5>
                        <div>{{$totalstats->pageviews->value}} Visualizaciones</div>
                    </div>
                </div>
                <div class="card col rounded">
                    <div class="card-body">
                        <h5 class="card-title">Total de Usuarios únicos</h5>
                        <div>{{$totalstats->visitors->value}} Usuario(s)</div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
            <div class="mt-4 bg-light border shadow">
                <canvas id="timeseries"></canvas>
            </div>
            <div class="mt-4 bg-light border shadow">
                <canvas id="goalconversion"></canvas>
            </div>
        @endisset
    @endisset
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const uusers = {!! $totalstats->visitors->value !!}
        labels1 = [];values1 = [];
        labels2 = ['0 %','25 %','50 %','75 %','100 %'];const values2 = [];
        {!! $timeseries !!}.forEach(data => {
            labels1.push(data.date);
            values1.push(data.visitors);
        });
        {!! $bounce !!}.forEach(data => {
            const val = (data.visitors/uusers*100).toFixed(2);
            if(data.position=='start') values2[0]=val;
            switch (data.position) {
                case 'start': values2[0]=val;break;
                case 'reach-firstquarter': values2[1]=val;break;
                case 'reach-half': values2[2]=val;break;
                case 'reach-thirdquarter': values2[3]=val;break;
                case 'reach-end': values2[4]=val;break;
                default:break;
            }
        });

        const data1 = {
            labels: labels1,
            datasets: [{
                label: 'Visualizaciones',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: values1,
            }]
        }
        const data2 = {
            labels: labels2,
            datasets: [{
                label: 'Porcentaje de Usuarios',
                backgroundColor: 'rgb(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                data: values2,
            }]
        }

        const config1 = {
            type: 'line',
            data: data1,
            options: {
                responsive: true,
                scales:{
                    x:{
                        display:true,
                        title:{
                            display:true,
                            text:"Fecha"
                        },

                    },
                    y:{
                        display:true,
                        title: {
                            display: true,
                            text: "Visualizaciones"
                        },
                    },

                },
                plugins:{
                    title:{
                        display: true,
                        text: 'Visualizaciones por día (Últimos 30 días)'
                    }
                }
            }
        };
        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                plugins:{
                    title:{
                        display: true,
                        text: 'Porcentaje de retención de Usuarios (Últimos 6 meses)',
                    }
                },
                scales: {
                    x:{
                        display:true,
                        title:{
                            display:true,
                            text:"Porcentaje de reproducción de Video"
                        },

                    },
                    y: {
                        display: true,
                        title : {
                            display: true,
                            title: 'Porcentaje de Usuarios'
                        },
                        beginAtZero: true
                    },
                }
            },
        };
        const chart1 = new Chart(document.getElementById('timeseries'),config1);
        const chart2 = new Chart(document.getElementById('goalconversion'),config2);
    </script>
@endsection
