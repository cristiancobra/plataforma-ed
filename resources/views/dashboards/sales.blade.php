@extends('layouts/master')

@section('title','VENDAS')

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
@endsection

@section('main')

<!--     linha 1 de blocos-->
<div class='row'>

    <!--     começo bloco de propostas-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-donate' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                PROPOSTAS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('proposal.create', ['type' => 'receita'])}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova proposta'></i>
                </a>
                <a style='text-decoration:none' href='{{route('proposal.index', ['type' => 'receita'])}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas as propostas'></i>
                </a>
                <a style='text-decoration:none' href='{{route('proposal.index', [
                                                                                                                            'type' => 'receita',
                                                                                                                            'user_id' => auth()->user()->id
                                                                                                                            ])}}'>
                    <i class='fas fa-paperclip ps-2 pe-2' title='minhas propostas'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de PROPOSTAS-->

    <!--     começo bloco de CONTRATOS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-file-signature' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                CONTRATOS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('contract.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo contrato'></i>
                </a>
                <a style='text-decoration:none' href='{{route('contract.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos os contratos'></i>
                </a>
                <a style='text-decoration:none' href='https://painel.autentique.com.br/'>
                    <i class='fas fa-stamp ps-2 pe-2' title='autenticação digital'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de CONTRATOS-->

    <!--     começo bloco de CONTATOS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-user-plus' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                CONTATOS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('contact.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo contato'></i>
                </a>
                <a style='text-decoration:none' href='{{route('contact.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas os contatos'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de CONTATOS-->


    <!--     começo bloco de EMPRESAS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-building' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                EMPRESAS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('company.create', ['typeCompanies' => 'cliente'])}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova empresa'></i>
                </a>
                <a style='text-decoration:none' href='{{route('company.index', ['typeCompanies' => 'cliente'])}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas as empresas'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de EMPRESAS-->


    <!--     começo bloco de LOJA-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 10px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-store' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                LOJA
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                @if($shop == null)
                <a style='text-decoration:none' href='{{route('shop.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='criar loja'></i>
                </a>
                @else
                <a style='text-decoration:none' href='{{route('shop.edit', ['shop' => $shop])}}'>
                    <i class='fas fa-edit ps-2 pe-2' title='editar loja'></i>
                </a>
                @endif
                <a style='text-decoration:none' href='{{route('product.create', ['variation' => 'receita'])}}'>
                    <i class='fas fa-shopping-basket ps-2 pe-2' title='novo produto'></i>
                </a>
                <a style='text-decoration:none' href='{{route('product.index', ['variation' => 'receita'])}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos os produtos'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de LOJA-->

    <!--fim da LINHA 1 de blocos-->    
</div>


<!--linha de oportunidades-->
<div class="row mt-5">
    <!--     começo bloco de oportunidades-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-radius: 8px 0px 0px 8px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row pt-5'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-funnel-dollar' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                OPORTUNIDADES
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center mt-3' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 8px 8px 8px 8px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('opportunity.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova oportunidade'></i>
                </a>
                <a style='text-decoration:none' href='{{route('opportunity.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas as oportunidade'></i>
                </a>
                <a style='text-decoration:none' href='{{route('opportunity.index', ['user_id' => auth()->user()->id])}}'>
                    <i class='fas fa-paperclip ps-2 pe-2' title='minhas oportunidade'></i>
                </a>
            </div>
        </div>
        <div class='row d-flex justify-content-center mt-3' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 20px;
             text-align: center;
             border-radius: 8px 8px 8px 8px;
             '>
            <div class="row">
                <div class="col">
                    <p class="labels text-center">
                        esta semana
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-center">
                    <a class='text-button btn-info mt-2' name='new_contacts' href='{{route('opportunity.index', [
                                                                                                                                                                    'status' => 'ganhamos',
                                                                                                                                                                    'updated_at' => date('Y-m-d', strtotime('-7 days'))
                                                                                                                                                                   ])}}'>
                        {{$opportunitiesWon}} <i class="fas fa-thumbs-up"></i>
                    </a>

                    <a class='text-button btn-danger mt-2' name='new_contacts' href='{{route('opportunity.index', [
                                                                                                                                                                    'status' => 'perdemos',
                                                                                                                                                                    'updated_at' => date('Y-m-d', strtotime('-7 days'))
                                                                                                                                                                   ])}}'>
                        {{$opportunitiesLost}} <i class="fas fa-thumbs-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--fim do bloco de oportunidades-->

    <div class='col-5' style='
         border-radius: 0 8px 8px 0;
         border-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         border-left-style: none;
         padding: 15px;
         '>
        <canvas id='opportunitiesChart' width='400' height='250'></canvas>
    </div>


    <div class='col-5 p-5 pt-0' style='
         border-radius: 20px 0 0 20px;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-right-style: none;
         '>
        <div class='row'>
            <div class="col pb-2">
                <p class="labels text-center">
                    aguardando contato
                </p>
            </div>
        </div>
        @foreach($opportunitiesNews as $opportunity)
        <div class='row table2 position-relative' style="border-color: {{$oppositeColor}}">
                <a class='stretched-link' href=' {{route('opportunity.show', ['opportunity' => $opportunity->id])}}'>
                </a>
            <div class='col-8'>
                {{$opportunity->name}}
            </div>
            @if($opportunity->company)
            <div class='col-4'>
                {{$opportunity->company->name}}
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<!--fim da LINHA de oportunidades-->


<!--linha de CONTATOS-->
<div class="row mt-5 pb-5">
    <!--     começo bloco de CONTATOS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-radius: 8px 0px 0px 8px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row pt-5'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-user-plus' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                CONTATOS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center mt-3' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 8px 8px 8px 8px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('contact.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo contato'></i>
                </a>
                <a style='text-decoration:none' href='{{route('contact.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas os contatos'></i>
                </a>
            </div>
        </div>
        <div class='row d-flex justify-content-center mt-3' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 20px;
             text-align: center;
             border-radius: 8px 8px 8px 8px;
             '>
            <div class="row">
                <div class="col">
                    <p class="labels text-center">
                        contatos recentes
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-center">
                    <a class='text-button btn-info mt-2' name='new_contacts' href='{{route('contact.index', ['created_at' => date('Y-m-d', strtotime('-7 days'))])}}'>
                        {{$contactsNewsTotal}} <i class="fas fa-arrow-alt-circle-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--fim do bloco de CONTATOS-->

    <div class='col-5' style='
         border-radius: 0 8px 8px 0;
         border-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         border-left-style: none;
         padding: 15px;
         '>
         <canvas id='contactsChart' width='400' height='250'></canvas>
    </div>


    <div class='col-5 p-5 pt-0' style='
         border-radius: 20px 0 0 20px;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-right-style: none;
         '>
        <div class='row'>
            <div class="col pb-2">
                <p class="labels text-center">
                    novos contatos
                </p>
            </div>
        </div>
        @foreach($contactsNews as $contactNew)
        <div class='row table2 position-relative' style="border-color: {{$oppositeColor}}">
                <a class='stretched-link' href=' {{route('contact.show', ['contact' => $contactNew->id])}}'>
                </a>
            <div class='col-7'>
                {{$contactNew->name}}
            </div>
            <div class='col-5'>
            @if($contactNew->company)
                {{$opportunity->company->name}}
                @elseif($contactNew->email)
                {{$contactNew->email}}
            @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!--fim da LINHA de CONTATOS-->

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