@extends('layouts/master')

@section('title','ADMINISTRATIVO')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3 ms-1 me-1'>

    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('account.show', ['account' => auth()->user()->account_id])}}'>
            <p class='panel-text'>
                <i class="fas fa-store" style="font-size:36px; ; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                MINHA EMPRESA
            </p>
        </a>
    </div>

    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('account.dashboard', ['account' => auth()->user()->account_id])}}'>
            <p class='panel-text'>
                <i class="fas fa-store" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                MODELO DE NEGÓCIO
            </p>
        </a>
    </div>

    <div class='col  sales-display'>
        <a style='text-decoration:none' href='{{route('user.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-id-card-alt" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                FUNCIONÁRIOS
            </p>
        </a>
    </div>


    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('company.index', ['typeCompanies' => 'concorrente'])}}'>
            <p class='panel-text'>
                <i class="fas fa-trophy" style="font-size:36px; color:white; margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                CONCORRENTES
            </p>
        </a>
    </div>

</div>


<div class='row mt-2 mb-3 ms-1 me-1'>

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
        <a style='text-decoration:none' href='{{route('goal.index')}}'>
            <p class='panel-text'>
                <i class='fas fa-bullseye' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                METAS
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