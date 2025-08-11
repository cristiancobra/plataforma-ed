<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <style>
            * {
                font-family: Nunito, helvetica, sans-serif;
            }
            .break{
                page-break-after: always;
            }
            .header2 {
                color:white;
                text-align: left;
                font-size: 25px;
                padding-top:0px;
                padding-left:25px;
                border-radius:20px;
                background-color: grey;
                height: 80px;
            }
            .table-list-header {
                color:white;
                font-size: 14px;
                padding:8px;
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .table-list {
                color:black;
                font-size: 14px;
                font-weight: 300;
                padding-top:20px;
                padding-bottom: 10px;
                margin-top: 10px;
                margin-bottom: 5px;
                margin-left: 10px;
                margin-right: 10px;
                border-style: solid;
                border-bottom-width: 1px;
            }
            .toDo{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #F2E28C;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }
            .done{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #A5D9CC;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }

            .doing{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #92C4D4;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }
            .description {
                color:black;
                font-size: 12px;
                padding:8px;
                padding-left:30px;
                margin-top: 0px;
                margin-bottom: 5px;
                margin-left: 40px;
                margin-right: 10px;
                border-radius:20px;
                border-style: solid;
                border-color: black;
                border-bottom: 1px;
                font-style: italic;
            }
            .right {
                text-align: right;
            }
            .left {
                text-align: left;
            }
            .center {
                text-align: center;
            }
        </style>

    </head>
    <body>
       
        <p>
            <br>
            <br>
            Relatório financeiro mensal e anual das receitas previsionadas (faturamento).
        </p>
        <table style="width: 98%;padding-top: 30px;margin-top: -38px">
            <tr>
                <td class="table-list-header center" style="width: 8%;background-color:{{$data['accountComplementaryColor']}}">
                    TIPO 
                </td>
                @foreach($data['months'] as $month)
                <td class="table-list-header center" style="width: 7%;background-color:{{$data['accountComplementaryColor']}}">
                    {{$month}}
                </td>
                @endforeach
                <td class="table-list-header center" style="width: 8%;background-color:{{$data['accountComplementaryColor']}}">
                    TOTAL 
                </td>
            </tr>

            @php
            $counterArray = 1;
            $counterMonth = 1;
            @endphp

            <tr>
                <td class="table-list-header left" style="width: 8%;font-weight: 600;background-color:#4863A0">
                    RECEITAS
                </td>

                @while($counterMonth <= 12)
                <td class="table-list right" style="width: 7%;background-color:lightblue;font-weight: 600;">
                    {{formatCurrency($data['monthlyRevenues'][$counterArray])}}
                </td>
                @php
                $counterMonth++;
                $counterArray++;    
                @endphp
                @endwhile

                <td class="table-list-header center" style="width: 8%;font-weight: 600;background-color:#4863A0">
                    {{formatCurrency($data['annualRevenues'])}}
                </td>
            </tr>

            @php
            $counterArray = 1;
            $counterMonth = 1;
            @endphp

            @foreach($data['categories'] as $category)
            <tr>
                <td class="table-list-header left" style="width: 8%;font-weight: 600;background-color:#4863A0">
                    {{$category['name']}}
                </td>
                @foreach($data['months'] as $key => $month)
                <td class="table-list right" style="width: 7%">
                    {{formatCurrency(floatval($category['monthlys'][$month]))}}
                </td>
                @endforeach
                <td class="table-list-header right" style="width: 8%;font-weight: 600;color:black;background-color:lightblue">
                    {{formatCurrency(floatval($category['year']))}}
                </td>
            </tr>
            @endforeach
        </table>
        <br>
        <p>
            Relatório financeiro mensal e anual das despesas previsionadas.
        </p>
        <table style="width: 98%;padding-top: 30px;margin-top: -38px">
            <tr>
                <td class="table-list-header left" style="width: 8%;font-weight: 600;background-color:red">
                    DESPESAS
                </td>
                @php
                $counterArray = 1;
                $counterMonth = 1;
                @endphp

                @while ($counterMonth <= 12)
                <td class="table-list right" style="width: 7%;background-color:#FDDBDD;font-weight: 600;">
                    {{formatCurrency($data['monthlyExpenses'][$counterArray])}}
                </td>
                @php
                $counterMonth++;
                $counterArray++;
                @endphp
                @endwhile
                <td class="table-list-header center" style="width: 8%;font-weight: 600;background-color:red">
                    {{formatCurrency($data['annualExpenses'])}}
                </td>
            </tr>


            @php
            $counterArray = 1;
            $counterMonth = 1;
            @endphp

            @foreach($data['groups'] as $group)
            <tr>
                <td class="table-list-header left" style="width: 8%;font-weight: 600;background-color:red">
                    {{$group['name']}}
                </td>
                @foreach($data['months'] as $key => $month)
                <td class="table-list right" style="width: 7%">
                    {{formatCurrency(floatval($group['monthlys'][$month]))}}
                    @endforeach
                <td class="table-list-header right" style="width: 8%;font-weight: 600;color:black;background-color:#FDDBDD">
                    {{formatCurrency(floatval($group['year']))}}
                </td>
            </tr>
            @endforeach
        </table>

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