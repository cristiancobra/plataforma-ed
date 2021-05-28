@extends('layouts/master')

@section('title','CONTAS BANCÁRIAS')

@section('image-top')
{{asset('imagens/bankAccount.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('bankAccount')}}
@endsection

@section('main')
<br>
<div>
    <h1 class="name">
        <b> Nome: </b> {{$bankAccount->name}}
    </h1>
    <label class="labels" for="" >
        Dono:
    </label>
    {{$bankAccount->account->name}}
    <br>
    <br>
    <label class="labels"  for="" >BANCO: </label> {{$bankAccount->bank->name}} - código {{$bankAccount->bank->bank_code}}
    <br>
    <label class="labels"  for="" >DATA DE ABERTURA: </label> {{date('d/m/Y', strtotime($bankAccount->date_creation))}}
    <br>
    <label class="labels"  for="" >DATA DE FECHAMENTO: </label>
    @if($bankAccount->date_closing)
    {{date('d/m/Y', strtotime($bankAccount->date_closing))}}
    @else
    aberta
    @endif
    <br>
    <label class="labels"  for="" >TIPO DE CONTA: </label> {{$bankAccount->type}}
    <br>
    <label class="labels"  for="" >NÚMERO DA AGÊNCIA: </label> {{$bankAccount->agency}}
    <br>
    <label class="labels"  for="" >NÚMERO DA CONTA: </label> {{$bankAccount->account_number}}
    <br>
    <label class="labels"  for="" >CHAVE PIX: </label> {{$bankAccount->pix}}
    <br>
    <label class="labels"  for="" >SALDO INICIAL: </label> R$ {{$bankAccount->opening_balance}}
    <br>
    <br>
    <p class="labels">
        DESCRIÇÃO:<span class="fields"> {!!html_entity_decode($bankAccount->observations)!!} </span>
    </p>
    <br>
    <label for="">SITUAÇÃO: </label> {{$bankAccount->status}}
    <br>
    <br>
    <p class="labels"> <b>Criado em:</b> {{ date('d/m/Y H:i', strtotime($bankAccount->created_at)) }} </p>

    <div style="text-align:right;padding: 2%">
        <form   style="text-decoration: none;display: inline-block" action="{{route('bankAccount.destroy', ['bankAccount' => $bankAccount])}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="APAGAR">
        </form>
        <a class="btn btn-secondary" href="{{route('bankAccount.edit', ['bankAccount' => $bankAccount])}}"  style="text-decoration: none;color: white;display: inline-block">
            <i class='fa fa-edit'></i>EDITAR</a>
        <a class="btn btn-secondary" href="{{route('bankAccount.index')}}"><i class="fas fa-arrow-left"></i></a>
    </div>
    <br>
    <br>
    <div>
        <table class="table-list">
            <tr>
                <td   class="table-list-header" style="width: 10%">
                    DATA
                </td>
                <td   class="table-list-header" style="width: 20%">
                    OPORTUNIDADE
                </td>
                <td   class="table-list-header" style="width: 5%">
                    FATURA
                </td>
                <td   class="table-list-header" style="width: 15%">
                    CONTA BANCÁRIA
                </td>
                <td   class="table-list-header" style="width: 15%">
                    CONTA
                </td>
                <td   class="table-list-header" style="width: 15%">
                    ORIGEM / DESTINO
                </td>
                <td   class="table-list-header" style="width: 10%">
                    TIPO
                </td>
                <td   class="table-list-header" style="width: 10%">
                    VALOR
                </td>
            </tr>

            @foreach ($bankAccount->transactions as $transaction)
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
                <td class="table-list-center">
                        {{$transaction->type}}
                </td>
                @if($transaction->value < 0)
                <td class="table-list-right" style="color:red">
                    @else
                <td class="table-list-right">
                    @endif
                    {{formatCurrencyReal($transaction->value)}}
                </td>
            </tr>
            @endforeach
            <tr>
                <td   class="table-list-header text-right" colspan="7"">
                    SALDO
                </td>
                <td   class="table-list-header text-right">
                    {{formatCurrencyReal($bankAccount->balance)}}
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 20px;text-align: right">
        <a class="circular-button secondary"  href="{{route('transaction.create', ['typeTransactions' => 'despesa'])}}">
            <i class="fas fa-minus"></i>
        </a>
        <a class="circular-button primary"  href="{{route('transaction.create', ['typeTransactions' => 'receita'])}}">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    <br>
</div>
@endsection