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
        
        <!--     começo bloco de oportunidades-->
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
        </div>
        <!--fim do bloco de oportunidades-->
        
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
                        <i class='fas fa-plus-circle ps-2 pe-2' title='nova oportunidade'></i>
                    </a>
                    <a style='text-decoration:none' href='{{route('proposal.index', ['type' => 'receita'])}}'>
                        <i class='fas fa-list-alt ps-2 pe-2' title='todas as oportunidade'></i>
                    </a>
                    <a style='text-decoration:none' href='{{route('proposal.index', [
                                                                                                                            'type' => 'receita',
                                                                                                                            'user_id' => auth()->user()->id
                                                                                                                            ])}}'>
                        <i class='fas fa-paperclip ps-2 pe-2' title='minhas oportunidade'></i>
                    </a>
                </div>
            </div>
        </div>
        <!--fim do bloco de PROPOSTAS-->
        
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
                    <a style='text-decoration:none' href='{{route('shop.edit', ['id' => $shop->id])}}'>
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
        <!--fim do bloco de EMPRESAS-->

<!--fim da LINHA 1 de blocos-->    
    </div>

    
        <div class='row pt-5 pb-0'>
            <div class='col-2 pt-5' style='
                 background-color: #fff6ff;
                 border-radius: 20px 0 0 20px;
                 border-color: white;
                 border-width: 5px;
                 border-style: solid;
                 border-right-style: none;
                 '>
                <p class='mt-2 text-center' style='color:#8B2485'>
                    <i class='fas fa-user-plus' style='font-size:40px; color:#8B2485'></i>
                    <br>
                    CONTATOS
                    <br>
                    <a class='text-button btn-info mt-2' name='new_contacts' href='{{route('contact.index', ['created_at' => date('Y-m-d', strtotime('-7 days'))])}}'>
                        +{{$contactsNewsTotal}} esta semana
                    </a>
                </p>
            </div>
            <div class='col-4' style='
                 background-color: #fff6ff;
                 border-radius: 0 20px 20px 0;
                 border-color: white;
                 border-width: 5px;
                 border-style: solid;
                 border-left-style: none;
                 padding: 15px;
                 '>
                <canvas id='contactsChart' width='400' height='250'></canvas>
            </div>

            <div class='col-2 pt-5' style='
                 background-color: #E5FFE5;
                 border-radius: 20px 0 0 20px;
                 border-color: white;
                 border-width: 5px;
                 border-style: solid;
                 border-right-style: none;
                 '>
                <p class='mt-2 text-center' style='color:#8B2485'>
                    <i class='fas fa-funnel-dollar' style='font-size:40px; color:#8B2485'></i>
                    <br>
                    OPORTUNIDADES
                    <a class='text-button btn-info mt-2' name='new_contacts' href='{{route('opportunity.index', [
                                                                                                                                                                    'status' => 'ganhamos',
                                                                                                                                                                    'updated_at' => date('Y-m-d', strtotime('-7 days'))
                                                                                                                                                                   ])}}'>
                        +{{$opportunitiesWon}} esta semana
                    </a>
                    <a class='text-button btn-danger mt-2' name='new_contacts' href='{{route('opportunity.index', [
                                                                                                                                                                    'status' => 'perdemos',
                                                                                                                                                                    'updated_at' => date('Y-m-d', strtotime('-7 days'))
                                                                                                                                                                   ])}}'>
                        +{{$opportunitiesLost}} esta semana
                    </a>
                </p>
            </div>
            <div class='col-4' style='
                 background-color: #E5FFE5;
                 border-radius: 0 20px 20px 0;
                 border-color: white;
                 border-width: 5px;
                 border-style: solid;
                 border-left-style: none;
                 padding: 15px;
                 '>
                <canvas id='opportunitiesChart' width='400' height='250'></canvas>
            </div>
        </div>

        <div class='row mt-0 pb-2'>
            <div class='col-6' style='
                 background-color: #fff6ff;
                 border-radius: 20px 0 0 20px;
                 border-color: white;
                 border-width: 5px;
                 border-style: solid;
                 border-right-style: none;
                 '>
                <div class='row'>
                    <div class="col pt-2 pb-2">
                        <p class="labels text-center">
                            ÚLTIMOS 7 DIAS
                        </p>
                    </div>
                </div>
                @foreach($contactsNews as $contactNew)
                <div class='row'>
                    <div class='col'>
                        <a class='white' href=' {{route('contact.show', ['contact' => $contactNew->id])}}'>
                            <button class='button-round'>
                                <i class='fa fa-eye'></i>
                            </button>
                        </a>
                        {{$contactNew->name}}
                    </div>
                    <div class='col'>
                        {{$contactNew->email}}
                    </div>
                    @if($contactNew->company)
                    <div class='col'>
                        {{$contactNew->company->name}}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class='col-6' style='
                 background-color: #E5FFE5;
                 border-radius: 20px 0 0 20px;
                 border-color: white;
                 border-width: 5px;
                 border-style: solid;
                 border-right-style: none;
                 '>
                <div class='row'>
                    <div class="col pt-2 pb-2">
                        <p class="labels text-center">
                            AGUARDANDO PRIMEIRO CONTATO
                        </p>
                    </div>
                </div>
                @foreach($opportunitiesNews as $opportunity)
                <div class='row'>
                    <div class='col-8'>
                        <a class='white' href=' {{route('opportunity.show', ['opportunity' => $opportunity->id])}}'>
                            <button class='button-round'>
                                <i class='fa fa-eye'></i>
                            </button>
                        </a>
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