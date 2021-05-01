@extends('layouts/master')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('imagens/transaction.png') }} 
@endsection

@section('description')
Total: <span class="labels"></span>
@endsection

@section('buttons')
<a class="circular-button secondary" href="{{route('transaction.create', ['typeTransactions' => 'despesa'])}}">
    <i class="fas fa-minus"></i>
</a>
<a class="circular-button primary"  href="{{route('transaction.create', ['typeTransactions' => 'receita'])}}">
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
            <td   class="table-list-header" style="width: 10%">
                DATA
            </td>
            <td   class="table-list-header" style="width: 25%">
                OPORTUNIDADE
            </td>
            <td   class="table-list-header" style="width: 5%">
                FATURA
            </td>
            <td   class="table-list-header" style="width: 15%">
                CONTA BANCÁRIA
            </td>
            <td   class="table-list-header" style="width: 20%">
                CONTA
            </td>
            <td   class="table-list-header" style="width: 15%">
                ORIGEM / DESTINO
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
                {{dateBr($transaction->pay_day)}}
                </a>
            </td>
            <td class="table-list-left">
                @if(isset($transaction->invoice->opportunity))
                <a href=" {{route('opportunity.show', ['opportunity' => $transaction->invoice->opportunity_id])}}">
                {{$transaction->invoice->opportunity->name}}
                </a>
                @else
                não possui
                @endif
            </td>
              <td class="table-list-center">
                @if($transaction->invoice_id != null)
                <a class="white" href=" {{route('invoice.show', ['invoice' => $transaction->invoice_id])}}">
                {{$transaction->invoice_id}}
                </a>
                @else
                excluida
                @endif
            </td>
            <td class="table-list-center">
                @if($transaction->bankAccount)
                <a class="white" href=" {{route('bankAccount.show', ['bankAccount' => $transaction->bankAccount->id])}}">
                {{$transaction->bankAccount->name}}
                </a>
                @else
                conta excluída
                @endif
            </td>
            <td class="table-list-center">
                <a class="white" href=" {{route('account.show', ['account' => $transaction->account->id])}}">
                {{$transaction->account->name}}
                </a>
            </td>
            <td class="table-list-center">
                @if(isset($transaction->invoice->company->name))
                <a class="white" href=" {{route('company.show', ['company' => $transaction->invoice->company->id])}}">
                {{$transaction->invoice->company->name}}
                </a>
                @elseif(isset($transaction->invoice->contact->name))
                <a class="white" href=" {{route('contact.show', ['contact' => $transaction->invoice->contact->id])}}">
                {{$transaction->invoice->contact->name}}
                </a>
                @else
                Não possui
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