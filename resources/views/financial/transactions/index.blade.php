@extends('layouts/master')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('imagens/transaction.png') }} 
@endsection

@section('description')
Total: <span class="labels"></span>
@endsection

@section('buttons')
<a class="circular-button secondary" href="{{route('transaction.create', ['typeTransactions' => 'receita'])}}">
    <i class="fas fa-minus"></i>
</a>
<a class="circular-button primary"  href="{{route('transaction.create', ['typeTransactions' => 'despesa'])}}">
    <i class="fas fa-plus"></i>
</a>
@endsection

@section('main')
<div>
    <div  style="display: inline-block;text-align:right;vertical-align:top;width: 10%">
        <img src="{{asset('imagens/financial-planning.png')}}" style='display:block;margin:auto;width:80%'>
    </div>
    <div  style="display: inline-block;vertical-align:top;width: 20%">
        <p class="labels" style="text-align:center">
            FATURAS DE {{strtoupper(returnMonth(date('m')))}}:
        </p>
        <p style="text-align:right;font-size:14px">
            RECEITAS:	+ {{formatCurrencyReal($estimatedRevenueMonthly)}}
            <br>
            DESPESAS: - {{formatCurrencyReal($estimatedExpenseMonthly)}}
            <br>
            SALDO: {{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
            <br>
    </div>
    <div  style="display: inline-block;text-align:right;vertical-align:top;width: 10%">
        <img src="{{asset('imagens/invoice.png')}}" style='display:block;margin:auto;width:80%'>
    </div>
    <div  style="display: inline-block;vertical-align:top;width: 20%">
        <p class="labels" style="text-align:center">
            REALIZADO EM {{strtoupper(returnMonth(date('m')))}}:
        </p>
        <p style="text-align:right;font-size:14px">
            RECEITAS:	+ {{formatCurrencyReal($revenueMonthly)}}
            <br>
            DESPESAS: - {{formatCurrencyReal($expenseMonthly)}}
            <br>
            SALDO: {{formatCurrencyReal($revenueMonthly - $expenseMonthly)}}
            <br>
        </p>
    </div>
    <div  style="display: inline-block;text-align:right;vertical-align:top;width: 10%">
        <img src="{{asset('imagens/financeiro.png')}}" style='display:block;margin:auto;width:80%'>
    </div>
    <div  style="display: inline-block;vertical-align:top;width: 20%">
        <p class="labels" style="text-align:center">
            DISPONÍVEL EM CAIXA:
        </p>
        <p style="text-align:right;font-size:14px">
            @foreach($bankAccounts as $bankAccount)
            {{$bankAccount->name}}: {{formatCurrencyReal($bankAccount->revenueTotal)}}
            <br>
            @endforeach
        </p>
    </div>
</div>
<br>
<br>
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 20%">
                DATA
            </td>
            <td   class="table-list-header" style="width: 20%">
                CONTA BANCÁRIA
            </td>
            <td   class="table-list-header" style="width: 20%">
                CONTA
            </td>
            <td   class="table-list-header" style="width: 20%">
                ORIGEM
            </td>
            <td   class="table-list-header" style="width: 10%">
                FATURA
            </td>
            <td   class="table-list-header" style="width: 10%">
                VALOR
            </td>
        </tr>

        @foreach ($transactions as $transaction)
        <tr style="font-size: 14px">
            <td class="table-list-left">
                <a class="white" href=" {{route('transaction.show', ['transaction' => $transaction->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('transaction.edit', [
					'transaction' => $transaction->id,
					'typeTransactions' => $transaction->type,
				])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$transaction->pay_day}}
            </td>
            <td class="table-list-center">
                @if($transaction->bankAccount)
                {{$transaction->bankAccount->name}}
                @else
                conta excluída
                @endif
            </td>
            <td class="table-list-center">
                {{$transaction->account->name}}
            </td>
            <td class="table-list-center">
                @if(isset($transction->invoice->company->name))
                {{$transction->invoice->company->name}}
                @elseif(isset($transction->invoice->contact->name))
                {{$transction->invoice->contact->name}}
                @else
                Não possui
                @endif
            </td>
            <td class="table-list-center">
                @if($transaction->invoice_id == null)
                <a class="white" href=" {{route('invoice.show', ['invoice' => $transaction->invoice_id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                {{$transaction->invoice_id}}
                @else
                excluida
                @endif
            </td>
            @if($transaction->type == "débito")
            <td class="table-list-right" style="color:red">
                @else
            <td class="table-list-right">
                @endif
                {{formatCurrencyReal($transaction->value)}}
            </td>
        </tr>
        @endforeach
    </table>
</div>
<br>
@endsection