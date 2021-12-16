@extends('layouts/master')

@section('title','FINANCEIRO')

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
@endsection

@section('main')

<!--     linha 1 de blocos-->
<div class='row'>

    <!--     começo bloco FORNECEDORES-->
    <!--coluna 1-->
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
                <i class='fas fa-truck' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                FORNECEDORES
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
                <a style='text-decoration:none' href='{{route('company.create', ['typeCompanies' => 'fornecedor'])}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova oportunidade'></i>
                </a>
                <a style='text-decoration:none' href='{{route('company.index', ['typeCompanies' => 'fornecedor'])}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos os fornecedores'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de FORNECEDORES-->



    <!--     começo bloco DESPESAS-->
    <!--coluna 1-->
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
                <i class='fas fa-boxes' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                DESPESAS
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
                <a style='text-decoration:none' href='{{route('proposal.create', ['type' => 'despesa'])}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo item de despesa'></i>
                </a>
                <a style='text-decoration:none' href='{{route('proposal.index', ['type' => 'despesa'])}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas os itens de desepsas'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de DESPESAS-->


    <!--     começo bloco ITENS DE DESPESA-->
    <!--coluna 1-->
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
                <i class='fas fa-boxes' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                ITENS DE DESPESA
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
                <a style='text-decoration:none' href='{{route('product.create', ['variation' => 'despesa'])}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo item de despesa'></i>
                </a>
                <a style='text-decoration:none' href='{{route('product.index', ['variation' => 'despesa'])}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas os itens de desepsas'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de ITENS DE DESPESA-->



    <!--     começo bloco CONTAS BANCÁRIAS-->
    <!--coluna 1-->
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
                <i class='fas fa-piggy-bank' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                CONTAS BANCÁRIAS
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
                <a style='text-decoration:none' href='{{route('bankAccount.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova conta bancária'></i>
                </a>
                <a style='text-decoration:none' href='{{route('bankAccount.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas as contas bancárias'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de CONTAS BANCÁRIAS-->




    <!--fim da LINHA 1 de blocos-->    
</div>



<!--     linha 2 PAGAMENTOS-->
<div class='row mt-5'>

    <!--     começo bloco PAGAMENTOS-->
    <!--coluna 1-->
    <div class='col-1' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 0px;
         margin-top: 10px;
         padding-top: 30px;
         border-radius: 10px 0px 0px 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-check-square' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3' style='
                 font-size: 14px;
                 margin-left: -8px;
                 '>
                PAGAMENTOS
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
             margin-top: 15px;
             margin-bottom: 15px;
             text-align: center;
             border-radius: 10px 10px 10px 10px;
             '>
            <div class="col">
                <a style='text-decoration:none;color: #0088ff' href='{{route('transaction.create', ['typeTransactions' => 'crédito'])}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='registrar nova entrada'></i>
                </a>
                <a style='text-decoration:none;color: #0088ff' href='{{route('transaction.index', ['type' => 'crédito'])}}'>
                    <i class='fas fa-list ps-2 pe-2' title='todas as entradas'></i>
                </a>
                <a style='text-decoration:none;color: #c40233' href='{{route('transaction.create', ['typeTransactions' => 'débito'])}}'>
                    <i class='fas fa-minus-circle ps-2 pe-2 pt-4' title='registrar nova saída'></i>
                </a>
                <a style='text-decoration:none;color: #c40233' href='{{route('transaction.index', ['type' => 'débito'])}}'>
                    <i class='fas fa-list ps-2 pe-2' title='todas as saídas'></i>
                </a>
                <a style='text-decoration:none' href='{{route('transaction.createTransfer', ['typeTransactions' => 'transferência'])}}'>
                    <i class='fas fa-sync-alt ps-2 pe-2 pt-4' title='registrar nova transferência'></i>
                </a>
            </div>
        </div>
    </div>

    <!--coluna 2-->
    <div class='col-10' style='
         border-color:{{$complementaryColor}};
         border-style: solid;
                           border-left-style: none;
         border-width: 4px;
         margin-left: 0px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 0px 10px 10px 0px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         font-weight: 600;
         '>


        <!--linha das últimas transações-->
        @foreach ($transactions as $transaction)
        @php
        if($transaction->type == 'crédito') {
        $typeColor = '#0088ff';
        } else {
        $typeColor = '#c40233';
        }
        @endphp
        <div class='container'>
            <div class='row table2 position-relative' style="
                 color: {{$principalColor}};
                 border-left-color: {{$typeColor}};
                 ">
                <a class='stretched-link' href=' {{route('transaction.show', ['transaction' => $transaction->id])}}'>
                </a>
                <div class='cel col-1' style="color: {{$typeColor}}">
                    {{dateBr($transaction->pay_day)}}
                </div>
                <div class='cel col-3 justify-content-start'>
                    @if($transaction->bankAccount)
                    <a class='white' href=' {{route('bankAccount.show', ['bankAccount' => $transaction->bankAccount->id])}}'>
                        {{$transaction->bankAccount->name}}
                    </a>
                    @else
                    conta excluída
                    @endif
                </div>
                <div class='cel col-6 justify-content-start'>
                    @if(isset($transaction->invoice->proposal->company->name))
                    <a class='white' href=' {{route('company.show', ['company' => $transaction->invoice->proposal->company->id])}}'>
                        {{$transaction->invoice->proposal->company->name}}
                    </a>
                    @elseif(isset($transaction->invoice->proposal->contact->name))
                    <a class='white' href=' {{route('contact.show', ['contact' => $transaction->invoice->proposal->contact->id])}}'>
                        {{$transaction->invoice->proposal->contact->name}}
                    </a>
                    @elseif($transaction->type == 'transferência')
                    {{$transaction->account->name}}
                    @else
                    Não possui
                    @endif
                </div>
                <div class='cel col-2 justify-content-end' style='color:{{$typeColor}}'>
                    {{formatCurrencyReal($transaction->value)}}
                </div>

            </div>
        </div>
        @endforeach
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 0px 0px;
             '>
            <div class="col">

            </div>
        </div>

        <!--linha VER TODAS transações-->
        <div class='row d-flex justify-content-center' style='
             font-size: 16px;
             font-weight: 600;
             color: {{$complementaryColor}};
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 0px 0px;
             '>
            <div class="col">
                <a href="{{route('transaction.index')}}">
                    ver todas as movimentações
                </a>
            </div>
        </div>


    </div>        
    <!--fim do bloco de PAGAMENTOS-->

    <!--fim da LINHA PAGAMENTOS-->    
</div>


<!--     linha 2 FATURAS-->
<div class='row mt-5'>

    <!--     começo bloco FATURAS-->
    <!--coluna 1-->
    <div class='col-1' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 0px;
         margin-top: 10px;
         padding-top: 30px;
         border-radius: 10px 0px 0px 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-calendar-times' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3' style='
                 font-size: 14px;
                 margin-left: -3px;
                 '>
                FATURAS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row  justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             margin-top: 15px;
             margin-bottom: 15px;
             text-align: center;
             border-radius: 10px 10px 10px 10px;
             '>
            <div class="col">
                <a style='text-decoration:none;color: #0088ff' href='{{route('invoice.create', ['typeInvoices' => 'receita'])}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='registrar nova entrada'></i>
                </a>
                <a style='text-decoration:none;color: #0088ff' href='{{route('invoice.index', ['type' => 'receita'])}}'>
                    <i class='fas fa-list ps-2 pe-2' title='todas as entradas'></i>
                </a>
                <a style='text-decoration:none;color: #c40233' href='{{route('invoice.create', ['typeInvoices' => 'despesa'])}}'>
                    <i class='fas fa-minus-circle ps-2 pe-2 pt-4' title='registrar nova saída'></i>
                </a>
                <a style='text-decoration:none;color: #c40233' href='{{route('invoice.index', ['type' => 'despesa'])}}'>
                    <i class='fas fa-list ps-2 pe-2' title='todas as saídas'></i>
                </a>
            </div>
        </div>
    </div>

    <!--coluna 2-->
    <div class='col-10' style='
         border-color:{{$complementaryColor}};
         border-style: solid;
                  border-left-style: none;
         border-width: 4px;
         margin-left: 0px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 0px 10px 10px 0px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         font-weight: 600;
         '>


        <!--linha das últimas FATURAS-->
        @foreach ($invoices as $invoice)
        @php
        if($invoice->type == 'receita') {
        $typeColor = '#0088ff';
        } else {
        $typeColor = '#c40233';
        }
        @endphp

        <div class='container'>
            <div class='row table2 position-relative' style="
                 color: {{$principalColor}};
                 border-left-color: {{$typeColor}};
                 ">
                <a class='stretched-link' href=' {{route('invoice.show', ['invoice' => $invoice])}}'>
                </a>
                <div class='cel col-1' style="color: {{$typeColor}}">
                    {{dateBr($invoice->pay_day)}}
                </div>
                <div class='cel col-3 justify-content-start'>
                    @if($invoice->proposal)
                    <a class='white' href=' {{route('proposal.show', ['proposal' => $invoice->proposal])}}'>
                        {{$invoice->proposal->name}}
                    </a>
                    @else
                    não possui
                    @endif
                </div>
                <div class='cel col-4 justify-content-start'>
                    @if($invoice->proposal->company)
                    {{$invoice->proposal->company->name}}
                    @elseif($invoice->proposal->contact)
                    {{$invoice->proposal->contact->name}}
                    @elseif($invoice->type == 'transferência')
                    {{$invoice->account->name}}
                    @else
                    Não possui
                    @endif
                </div>
                <div class='cel col-2 justify-content-end' style='color:{{$typeColor}}'>
                    {{formatCurrencyReal($invoice->totalPrice)}}
                </div>
                <div class='cel col-2 justify-content-end' style='color:{{$typeColor}}'>
                    {{formatCurrencyReal($invoice->value)}}
                </div>
            </div>
        </div>

        @endforeach
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 0px 0px;
             '>
            <div class="col">

            </div>
        </div>

        <!--linha VER TODAS faturas-->
        <div class='row d-flex justify-content-center' style='
             font-size: 16px;
             font-weight: 600;
             color: {{$complementaryColor}};
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 0px 0px;
             '>
            <div class="col">
                <a href="{{route('invoice.index')}}">
                    ver todas as faturas
                </a>
            </div>
        </div>


    </div>        
    <!--fim do bloco de FATURAS-->

    <!--fim da LINHA FATURAS-->    
</div>


<!--linha com paines antigos-->

<div class='row mt-5 mb-3 ms-1 me-1'>
    <div class='financial-display col-3'>
        <div>
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
    </div>


    <div class='financial-display ms-5 me-5 col-3'>
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


    <div class='financial-display col-3'>
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
@endsection