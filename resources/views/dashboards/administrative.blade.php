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
    <div class='col' style='
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
    <div class='col' style='
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

    
    <!--     começo bloco de METAS-->
    <div class='col' style='
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
                <a style='text-decoration:none' href='{{route('planning.index')}}'>
                    <i class='fas fa-dollar-sign ps-2 pe-2' title='planejamento financeiro'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de METAS-->

    

    <!--     começo bloco de CONCORRENTES-->
    <div class='col' style='
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

    
    
       <!--     começo bloco de RELATÓRIOS DE FINANCEIROS-->
    <div class='col' style='
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
                RELATÓRIOS DE FINANCEIROS
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
                <a style='text-decoration:none' href='{{route('transaction.report')}}'>
                    <i class='fas fa-expand-alt ps-2 pe-2' title='fluxo de caixa presente (pagamentos)'></i>
                </a>
                <a style='text-decoration:none' href='{{route('invoice.report')}}'>
                    <i class='fas fa-chart-area ps-2 pe-2' title='faturamento e previsão de gastos'></i>
                </a>
                <a style='text-decoration:none' href='{{route('journey.reportUsers')}}'>
                    <i class='fas fa-users ps-2 pe-2' title='relatórios de produtividade'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de RELATÓRIOS DE FINANCEIROS-->
    
    
       <!--     começo bloco de RELATÓRIOS DE VENDAS-->
    <div class='col' style='
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
                RELATÓRIOS DE VENDAS
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
                <a style='text-decoration:none' href='{{route('proposal.report')}}'>
                    <i class='fas fa-shopping-basket ps-2 pe-2' title='totais de vendas'></i>
                </a>
                <a style='text-decoration:none' href='{{route('product.report')}}'>
                    <i class='fas fa-trophy ps-2 pe-2' title='vendas por produto'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de RELATÓRIOS DE VENDAS-->
 
    
    
    <!--fim da LINHA 2 de blocos-->    
</div>


@endsection