@extends('layouts/master')

@section('title','FINANCEIRO')

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3 ms-2 me-2'>

    <div class='financial-display col-lg-3'>
        <div style='display: inline-block;float: left;width: 20%'>
            <img class='financial-image' src="{{asset('images/financial-planning.png')}}">
        </div>
        <div style='display: inline-block;float:left;width: 40%;padding-left: 10px'>
            <p style="color:white;font-size: 15px;text-align: left">
                VENDIDO:
                <br>
                COMPROMETIDO:
                <br>
                SALDO:
            </p>
        </div>
        <div style='display: inline-block;float:right;width: 30%'>
            <p style="color:white;font-size: 15px;text-align: right">
                {{formatCurrency($estimatedRevenueMonthly)}}
                <br>
                {{formatCurrency($estimatedExpenseMonthly)}}
                <br>
                {{formatCurrency($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
        </div>
    </div>

    <div class='financial-display col-lg-3'>
        <div style='display: inline-block;float: left;width: 20%'>
            <img class='financial-image' src="{{asset('images/invoice.png')}}" style='width:100%'>
        </div>
        <div style='display: inline-block;float:left;width: 40%;padding-left: 10px'>
            <p style="color:white;font-size: 15px;text-align: left">
                <a href='{{route('transaction.index')}}' style="color:white">
                    ENTRADAS:
                </a>
                <br>
                SAÍDAS:
                <br>
                SALDO:
            </p>
        </div>
        <div style='display: inline-block;float:right;width: 30%'>
            <p style="color:white;font-size: 15px;text-align: right">
                {{formatCurrency($revenueMonthly)}}
                <br>
                {{formatCurrency($expenseMonthly)}}
                <br>
                {{formatCurrency($revenueMonthly + $expenseMonthly)}}
            </p>
        </div>
    </div>

    <div class='financial-display col-lg-3'>
        <div style='display: inline-block;float: left;width: 20%'>
            <img class='financial-image' src="{{asset('images/financeiro.png')}}" style='width:100%'>
        </div>
        <div style='display: inline-block;float:left;width: 40%;padding-left: 10px'>
            <p style="color:white;font-size: 15px;text-align: left">
                @foreach($bankAccounts as $bankAccount)
                <a href="{{route('bankAccount.show', ['bankAccount' => $bankAccount])}}" style="color: white">
                    {{$bankAccount->name}}
                </a>
                <br>
                @endforeach
        </div>
        <div style='display: inline-block;float:right;width: 30%'>
            <p style="color:white;font-size: 15px;text-align: right">
                @foreach($bankAccounts as $bankAccount)
                <a href="{{route('bankAccount.show', ['bankAccount' => $bankAccount])}}" style="color: white">
                    {{formatCurrency($bankAccount->balance)}}
                </a>
                <br>
                @endforeach
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('invoice.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-money-bill" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                FATURAS
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('transaction.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-sync-alt" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                FLUXO DE CAIXA
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('proposal.index', ['type' => 'despesa'])}}'>
            <p class='panel-text'>
                <i class="fas fa-donate" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                DESPESAS
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('product.index', ['variation' => 'despesa'])}}'>
            <p class='panel-text'>
                <i class="fas fa-boxes" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                ITENS DE DESPESA
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('company.index', ['typeCompanies' => 'fornecedor'])}}'>
            <p class='panel-text'>
                <i class="fas fa-boxes" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                FORNECEDORES
            </p>
        </a>
    </div>
    <div class='col-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('bankAccount.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-piggy-bank" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                CONTAS BANCÁRIAS
            </p>
        </a>
    </div>
</div>
@endsection