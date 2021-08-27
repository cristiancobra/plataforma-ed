<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

                    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
    </head>
    <body>


        <div class="row mt-4">
            <div class="tb-header col-1">
                TIPO 
            </div>
            @foreach($data['months'] as $month)
            <div   class="tb-header col" style="width: 5%">
                {{$month}}
            </div>
            @endforeach
            <div   class="tb-header col" style="width: 10%">
                TOTAL 
            </div>
        </div>

        @php
        $counterArray = 1;
        $counterMonth = 1;
        @endphp

        <div class="row mt-1">
            <div class="tb-header col-1 justify-content-start"  style='background-color: #4863A0;font-weight: 600'>
                RECEITAS
            </div>

            @while($counterMonth <= 12)
            <div class='tb col justify-content-end' style='background-color: lightblue;font-weight: 600'>

                {{formatCurrency($data['monthlyRevenues'][$counterArray])}}
            </div>
            @php
            $counterMonth++;
            $counterArray++;    
            @endphp
            @endwhile

            <div class='tb tb-header col justify-content-end'  style='background-color: #4863A0;font-weight: 600'>
                {{formatCurrency($data['annualRevenues'])}}
            </div>
        </div>

        @php
        $counterArray = 1;
        $counterMonth = 1;
        @endphp

        @foreach($data['categories'] as $category)
        <div class="row">
            <div class="tb col-1 justify-content-start" style='background-color: lightblue;font-weight: 600'>
                {{$category['name']}}
            </div>
            @foreach($data['months'] as $key => $month)
            <div class="tb col justify-content-end">

                {{formatCurrency(floatval($category['monthlys'][$month]))}}
            </div>
            @endforeach
            <div class="tb col justify-content-end" style='background-color: lightblue;font-weight: 600'>
                {{formatCurrency(floatval($category['year']))}}
            </div>
        </div>
        @endforeach

        <div class="row mt-5">
            <div class="tb-header col-1 justify-content-start" style='background-color: red;color:white;font-weight: 600'>
                DESPESAS
            </div>
            @php
            $counterArray = 1;
            $counterMonth = 1;
            @endphp

            @while ($counterMonth <= 12)
            <div class='tb col justify-content-end' style='background-color: #FDDBDD;font-weight: 600'>
                {{formatCurrency($data['monthlyExpenses'][$counterArray])}}
            </div>
            @php
            $counterMonth++;
            $counterArray++;
            @endphp
            @endwhile
            <div class='tb col justify-content-end' style='background-color: red;color:white;font-weight: 600'>
                {{formatCurrency($data['annualExpenses'])}}
            </div>
        </div>


        @php
        $counterArray = 1;
        $counterMonth = 1;
        @endphp

        @foreach($data['groups'] as $group)
        <div class="row">
            <div class="tb col-1 justify-content-start" style='background-color: #FDDBDD;font-weight: 600'>
                {{$group['name']}}
            </div>
            @foreach($data['months'] as $key => $month)
            <div class="tb col justify-content-end">
                {{formatCurrency(floatval($group['monthlys'][$month]))}}
            </div>
            @endforeach
            <div class="tb col justify-content-end"  style='background-color: #FDDBDD;font-weight: 600'>
                {{formatCurrency(floatval($group['year']))}}
            </div>
        </div>
        @endforeach
        <br>
        <br>

        <script>
            $(document).ready(function () {
                //botao de exibir filtro
                $("#filter_button").click(function () {
                    $("#filter").slideToggle(600);
                });
            });

            //gráfico de linhas

<?php
$monthsLabel = json_encode(array_values($data['months']));
$monthlyRevenues = json_encode(array_values($data['monthlyRevenues']));

$monthlyCategory = [];
$counter = 1;
foreach ($data['categories'] as $category) {
    $monthlyCategory[] = json_encode(array_values($category['monthlys']));
    //    $monthlyCategory[$counter++] = json_encode(array_values($monthlyCategory));
}
//    dd($monthlyCategory[0]);
?>

            new Chart(document.getElementById("chart"), {
                type: 'line',
                data: {
                    labels: <?php echo $monthsLabel; ?>,
                    datasets: [{
                            data: <?php echo $monthlyRevenues; ?>,
                            label: "Receitas totais",
                            borderColor: "#3e95cd",
                            fill: false
                        }, {
                            data: <?php echo $monthlyCategory[0]; ?>,
                            label: "Serviços",
                            borderColor: "#ffff00",
                            fill: false
                        }, {
                            data: <?php echo $monthlyCategory[1]; ?>,
                            label: "Produtos",
                            borderColor: "#8e5ea2",
                            fill: false
                        }, {
                            data: <?php echo $monthlyCategory[2]; ?>,
                            label: "Produtos digitais",
                            borderColor: "#3cba9f",
                            fill: false
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'World population per region (in millions)'
                    }
                }
            });


        </script>

    </body>
</html>