@extends('layouts/master')

@section('title', 'PRODUTIVIDADE')

@section('image-top')
    <i class="fas fa-users"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <a id='filter_button' class='circular-button secondary pt-2'>
        <i class="fa fa-filter" aria-hidden="true"></i>
    </a>

    {{ createButtonList('journey') }}
@endsection

@section('main')

    <div class='row'>
        <form id="filter" action="{{ route('journey.reportDepartments') }}" method="get"
            style="text-align: right;display:none">
            @csrf
            <select class="select" name="year">
                @php
                    $currentYear = date('Y');
                    $selectedYear = request('year', $currentYear);
                    $startYear = 2020;
                @endphp
                @for ($y = $currentYear; $y >= $startYear; $y--)
                    <option class="fields" value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
            <a class="text-button secondary" href='{{ route('journey.reportDepartments') }}'>
                LIMPAR
            </a>
            <input class="text-button secondary" type="submit" value="FILTRAR">
        </form>
    </div>

    <div class='row mt-4'>
        <div class="col-3">
            <canvas id="chart" width="400" height="250"></canvas>
        </div>
        <div class="col-3 pt-5 offset-4">
            <br>
            <span class="labels">{{ $annualTotal }}</span> horas executadas em {{ date('Y') }} .
            <br>
            <span class="labels">{{ $monthlyAverage }}</span> horas de média mensal.
            </p>
        </div>
        <div class="col-2 pt-5">
            <a class='text-button primary' href='{{ route('journey.reportUsers') }}'>
                EQUIPE
            </a>
            <br>
            <br>
            <a class='text-button secondary' href='{{ route('journey.reportDepartments') }}'>
                DEPARTAMENTOS
            </a>
        </div>
    </div>


    <div class="row mt-1">
        <div class="tb-header-start col-2">
            DEPARTAMENTOS
        </div>
        @foreach ($months as $month)
            <div class="tb-header col justify-content-center" style="width: 5%">
                {{ $month }}
            </div>
        @endforeach
        <div class="tb-header-end col">
            TOTAL
        </div>
    </div>

    @foreach ($departments as $department)
        <div class="row">
            <div class="tb col-2 justify-content-start">
                {{ $department['name'] }}
            </div>
            @foreach ($months as $key => $month)
                <div class="tb col justify-content-end">
                    <a
                        href="{{ route('journey.index', [
                            'department' => $department,
                            'start' => date("$year-$key-01"),
                            'end' => date("$year-$key-t"),
                        ]) }}">
                        {{ number_format($department['monthlys'][$month] / 3600, 1, ',', '.') }}
                    </a>
                </div>
            @endforeach
            <div class="tb col justify-content-end" style='color:white;background-color: #874983;border-color: white'>
                {{ number_format($department['year'] / 3600, 1, ',', '.') }}
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="tb-header col-2">
            TOTAL
        </div>
        @foreach ($monthlyTotals as $monthlyTotal)
            <div class="tb-header col justify-content-end" style="width: 5%;border-color: white">
                {{ number_format($monthlyTotal / 3600, 1, ',', '.') }}
            </div>
        @endforeach
        <div class="tb col justify-content-end" style='color:white;background-color: #49d194;border-color: white'>
            {{ $annualTotal }}
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Botão de exibir/ocultar filtro
        const filterButton = document.getElementById('filter_button');
        const filterElement = document.getElementById('filter');

        if (filterButton && filterElement) {
            filterButton.addEventListener('click', function(e) {
                e.preventDefault();

                if (filterElement.style.display === 'none' || filterElement.style.display === '') {
                    filterElement.style.display = 'block';
                } else {
                    filterElement.style.display = 'none';
                }
            });
        }

        // Gráfico pizza
        var ctx = document.getElementById('chart');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($departmentsNames) !!},
                datasets: [{
                    label: 'Horas',
                    data: [
                        @foreach ($departments as $department)
                            {!! json_encode(round($department['year'] / 3600, 1)) !!},
                        @endforeach
                    ],
                    backgroundColor: [
                        @php
                            $colors = ['rgba(255, 206, 86, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(41, 221, 101, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                        @endphp
                        @foreach ($departments as $department)
                            {!! json_encode($colors[$loop->index % count($colors)]) !!},
                        @endforeach
                    ],
                    borderColor: [
                        @php
                            $borderColors = ['rgba(255, 206, 86, 1)', 'rgba(54, 162, 235, 1)', 'rgba(153, 102, 255, 1)', 'rgba(41, 221, 101, 1)', 'rgba(255, 99, 132, 1)'];
                        @endphp
                        @foreach ($departments as $department)
                            {!! json_encode($borderColors[$loop->index % count($borderColors)]) !!},
                        @endforeach
                    ],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'left',
                    },
                    title: {
                        display: true,
                        text: 'HORAS POR DEPARTAMENTO'
                    }
                }
            },
        });
    });
</script>
