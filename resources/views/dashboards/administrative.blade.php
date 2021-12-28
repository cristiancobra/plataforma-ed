@extends('layouts/master')

@section('title','ADMINISTRATIVO')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<!--     linha 1 de blocos-->
<div class='row'>

    <!--     começo bloco de MINHA EMPRESA-->
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
                <i class='fas fa-store' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                MINHA EMPRESA
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
                <a style='text-decoration:none' href='{{route('account.show', ['account' => auth()->user()->account_id])}}'>
                    <i class='fas fa-eye ps-2 pe-2' title='ver informaçoes da emrpesa'></i>
                </a>
                <a style='text-decoration:none' href='{{route('account.dashboard', ['account' => auth()->user()->account_id])}}'>
                    <i class='fas fa-th-large ps-2 pe-2' title='modelo de negócio'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de MINHA EMPRESA-->

    
    <!--     começo bloco de USUÁRIOS-->
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
                <i class='fas fa-id-card-alt' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                USUÁRIOS
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
                <a style='text-decoration:none' href='{{route('user.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo usuário'></i>
                </a>
                <a style='text-decoration:none' href='{{route('user.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos os usuários'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de USUÁRIOS-->

    
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
                <i class='fas fa-bullseye' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                METAS
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
                <a style='text-decoration:none' href='{{route('goal.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova proposta'></i>
                </a>
                <a style='text-decoration:none' href='{{route('goal.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas as metas'></i>
                </a>
                <a style='text-decoration:none' href='{{route('goal.index', [
                                                                                                                            'user_id' => auth()->user()->id
                                                                                                                            ])}}'>
                    <i class='fas fa-paperclip ps-2 pe-2' title='minhas metas'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de PROPOSTAS-->

    

    <!--     começo bloco de CONCORRENTES-->
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
                <i class='fas fa-trophy' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                CONCORRENTES
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
                <a style='text-decoration:none' href='{{route('company.create', ['typeCompanies' => 'concorrente'])}}''>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo concorrente'></i>
                </a>
                <a style='text-decoration:none' href='{{route('company.index', ['typeCompanies' => 'concorrente'])}}''>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos os concorrentes'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de CONCORRENTES-->

    
    

    <!--fim da LINHA 1 de blocos-->    
</div>


<!--     linha 2 de blocos-->
<div class='row mt-5'>

    <!--     começo bloco de RELATÓRIOS-->
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
                <i class='fas fa-chart-bar' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                RELATÓRIOS
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
                <a style='text-decoration:none' href='{{route('invoice.report')}}'>
                    <i class='fas fa-money-bill ps-2 pe-2' title='relatórios financeiros'></i>
                </a>
                <a style='text-decoration:none' href='{{route('journey.reportUsers')}}'>
                    <i class='fas fa-users ps-2 pe-2' title='relatórios de produtividade'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de RELATÓRIOS-->

    
    
    

    <!--fim da LINHA 2 de blocos-->    
</div>




<div class='row mt-5 mb-3 ms-1 me-1'>


    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('journey.reportUsers')}}'>
            <p class='panel-text'>
                <i class="fas fa-chart-bar" style="font-size:36px; color:white; margin-top: -15px;padding-bottom: 10px "></i>
                <br>
                RELATÓRIO DE PRODUTIVIDADE
            </p>
        </a>
    </div>

    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('invoice.report')}}'>
            <p class='panel-text'>
                <i class='fas fa-chart-line' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                RELATÓRIOS FINANCEIROS
            </p>
        </a>
    </div>

    
    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('planning.index')}}'>
            <p class='panel-text'>
                <i class='fas fa-chart-pie ' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                PLANEJAMENTO FINANCEIRO
            </p>
        </a>
    </div>


</div>

@endsection