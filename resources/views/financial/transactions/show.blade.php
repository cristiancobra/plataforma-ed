@extends('layouts/master')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('images/transaction.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('transaction')}}
@endsection

@section('main')
<br>
<div>
    <p class="labels">
        RESPONSÁVEL:<span class="fields">{{$transaction->user->contact->name}}</span>
    </p>
    <br>
    <p class="labels">
        DATA:<span class="fields">  {{date('d/m/Y', strtotime($transaction->pay_day))}} </span>
    </p>
    <p class="labels">
        @if($transaction->bankAccount)
        CONTA:<span class="fields">{{$transaction->bankAccount->name}}</span>
        @else
        CONTA:<span class="fields">conta excluída</span>
        @endif
    </p>
    <p class="labels">
        @if(isset($transaction->invoice->opportunity))
        OPORTUNIDADE:<span class="fields">{{$transaction->invoice->opportunity->name}}</span>
        <a class="white" href=" {{route('opportunity.show', ['opportunity' => $transaction->invoice->opportunity->id])}}">
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        @else
        OPORTUNIDADE:<span class="fields">Não possui</span>
        @endif
    </p>
    <br>
    <br>
    <p class="labels">
        FATURA:
        @if($transaction->invoice)
        <span class="fields">{{$transaction->invoice->identifier}}</span>
        <a class="white" href=" {{route('invoice.show', ['invoice' => $transaction->invoice_id])}}">
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        @else
        Não possui
        @endif
    </p>
    <p class="labels">
        TIPO:<span class="fields">{{$transaction->type}}</span>
    </p>
    <p class="labels">
        VALOR:<span class="fields">{{formatCurrencyReal($transaction->value)}}</span>
    </p>
    <p class="labels">
        MEIO DE PAGAMENTO:<span class="fields">{{$transaction->payment_method}}</span>
    </p>
    <br>
    <div class='row' style='margin-top: 30px'>
    <div class='col-12' style='text-align: left'>
        <div class='show-label-large'>
            DESCRIÇÃO
        </div>
        <div class='description-field'>
            {!!html_entity_decode($transaction->observations)!!}
        </div>
    </div>
</div>
    <br>
    <br>
    <p class="labels">
        SITUAÇAO:<span class="fields">  {{$transaction->status}} </span>
    </p>
    <br>
    <p class="fields">Criado em:  {{date('d/m/Y H:i', strtotime($transaction->created_at))}}
    </p>

    <div style="text-align:right;padding: 2%">
        <form   style="text-decoration: none;color: black;display: inline-block" action="{{route('transaction.destroy', ['transaction' => $transaction->id])}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="APAGAR">
        </form>            
        <a class="btn btn-secondary" href=" {{ route('transaction.edit', [
						'transaction' => $transaction->id,
						'typeTransactions' => $transaction->type,
						]) }}">
            <i class='fa fa-edit'></i>EDITAR
        </a>
        <a class="btn btn-secondary" href="{{route('transaction.index')}}"><i class="fas fa-arrow-left"></i>
        </a>
    </div>
</div>
@endsection