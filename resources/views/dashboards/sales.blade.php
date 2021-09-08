@extends('layouts/master')

@section('title','VENDAS')

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class="row pt-5 pb-5">
    <div class="col-2 pt-5" style="
         background-color: #fff6ff;
         border-radius: 20px 0 0 20px;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-right-style: none;
         ">
        <p class="mt-2 text-center" style="color:#8B2485">
            <i class="fas fa-user-plus" style="font-size:40px; color:#8B2485"></i>
            <br>
            CONTATOS
            <br>
            <a class="text-button btn-info mt-2" name="new_contacts" href="{{route('contact.index', ['created_at' => date("Y-m-d", strtotime("-7 days"))])}}">
                +{{$contactsNewsTotal}} esta semana
            </a>
        </p>
        @foreach($contactsNews as $contactNew)
        <a class="white" href=" {{route('contact.show', ['contact' => $contactNew->id])}}">
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        {{$contactNew->name}}
        <br>
        @endforeach
    </div>
    <div class="col-4" style="
         background-color: #fff6ff;
         border-radius: 0 20px 20px 0;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-left-style: none;
         padding: 15px;
         ">
        <canvas id="contactsChart" width="400" height="250"></canvas>
    </div>
    <div class="col-2 pt-5" style="
         background-color: #fff6ff;
         border-radius: 20px 0 0 20px;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-right-style: none;
         ">
        <p class="mt-2 text-center" style="color:#8B2485">
            <i class="fas fa-funnel-dollar" style="font-size:40px; color:#8B2485"></i>
            <br>
            OPORTUNIDADES
            <a class="text-button btn-info mt-2" name="new_contacts" href="{{route('opportunity.index', [
                                                                                                                                                                    'status' => 'ganhamos',
                                                                                                                                                                    'updated_at' => date("Y-m-d", strtotime("-7 days"))
                                                                                                                                                                   ])}}">
                +{{$opportunitiesWon}} esta semana
            </a>
            <a class="text-button btn-danger mt-2" name="new_contacts" href="{{route('opportunity.index', [
                                                                                                                                                                    'status' => 'perdemos',
                                                                                                                                                                    'updated_at' => date("Y-m-d", strtotime("-7 days"))
                                                                                                                                                                   ])}}">
                +{{$opportunitiesLost}} esta semana
            </a>
        </p>
    </div>
    <div class="col-4" style="
         background-color: #fff6ff;
         border-radius: 0 20px 20px 0;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-left-style: none;
         padding: 15px;
         ">
        <canvas id="opportunitiesChart" width="400" height="250"></canvas>
    </div>
</div>
<div class="row">
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('contact.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-user-plus" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                CONTATOS
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('contact.target')}}'>
            <p class='panel-text'>
                <i class="fas fa-user-plus" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
               PÚBLICO-ALVO
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('company.index', ['typeCompanies' => 'cliente'])}}'>
            <p class='panel-text'>
                <i class="fas fa-store" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                EMPRESAS
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('product.index', ['variation' => 'receita'])}}'>
            <p class='panel-text'>
                <i class="fas fa-shopping-basket" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                PRODUTOS
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('opportunity.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-donate" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                OPORTUNIDADES
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('proposal.index', ['type' => 'receita'])}}'>
            <p class='panel-text'>
                <i class="fas fa-donate" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                PROPOSTAS
            </p>
        </a>
    </div>
</div>
@endsection


@section('js-scripts')
<script>

//Cria o gráfico para contatos
    var ctx = document.getElementById('contactsChart');
    var contactsChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: ['Curiosos', 'Interessados', 'Qualificados'],
                    datasets: [{
                    label: 'FUNIL DE MARKETING',
                            data: {!! json_encode($contacts) !!},
                            backgroundColor: [
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 2,
                    }]
            },
            options: {
            indexAxis: 'y',
            }
    });
//Cria o gráfico para oportunidades
    var ctx = document.getElementById('opportunitiesChart');
    var contactsChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: ['Prospectar', 'Apresentar', 'Proposta', 'Contrato', 'Cobrança', 'Produção', 'Concluídas'],
                    datasets: [{
                    label: 'FUNIL DE VENDAS',
                            data: {!! json_encode($opportunities) !!},
                            backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 2,
                    }]
            },
            options: {
            indexAxis: 'y',
            }
    });
</script>
@endsection