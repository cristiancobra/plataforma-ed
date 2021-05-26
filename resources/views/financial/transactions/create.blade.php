@extends('layouts/master')

@if($typeTransactions == 'receita')
@section('title','ENTRADAS')
@elseif($typeTransactions == 'despesa')
@section('title','SAÍDAS')
@elseif($typeTransactions == 'transferência')
@section('title','TRANSFERÊNCIAS')
@endif

@section('image-top')
{{asset('imagens/transaction.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('transaction')}}
@endsection

@section('main')
<br>

@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action=" {{route('transaction.store')}} " method="post" style="color: #874983">
        @csrf
        <label class="labels" for="">EMPRESA: </label>
        @if(!empty(app('request')->input('accountId')))
        <input type="hidden" name='account_id' value="{{app('request')->input('accountId')}}">
        {{app('request')->input('accountName')}}
        @else
        <select name="account_id">
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
        </select>
        @endif
        <br>
        <label class="labels" for="">REGISTRADO POR:</label>
        <select name="user_id">
            <option  class="fields" value="{{Auth::user()->id}}">
                {{Auth::user()->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        @if($typeTransactions == 'transferência')
        <label class="labels" for="">CONTA DE ORIGEM:</label>
        @else
        <label class="labels" for="">CONTA:</label>
        @endif
        <select name="bank_account_id">
            @foreach ($bankAccounts as $bankAccount)
            <option  class="fields" value="{{$bankAccount->id}}">
                {{$bankAccount->name}}
            </option>
            @endforeach
        </select>
        <br>
        @if($typeTransactions == 'transferência')
        <label class="labels" for="">CONTA DE DESTINO:</label>
        <select name="bank_account_destiny_id">
            @foreach ($bankAccounts as $bankAccount)
            <option  class="fields" value="{{$bankAccount->id}}">
                {{$bankAccount->name}}
            </option>
            @endforeach
        </select>
        <br>
        @endif
        <br>
        @if($typeTransactions != 'transferência')
        <label class="labels" for="">FATURA: </label>
        @if(!empty(app('request')->input('invoiceId')))
        <input type="hidden" name='invoice_id' value="{{app('request')->input('invoiceId')}}">
        {{app('request')->input('invoiceIdentifier')}}
        @else
        <select name="invoice_id">
            @foreach ($invoices as $invoice)
            <option  class="fields" value="{{$invoice->id}}" style="max-width:600px">
                {{$invoice->id}} -
                @if(isset($invoice->opportunity->company->name))
                {{$invoice->opportunity->company->name}}
                @endif
                @if(isset($invoice->company))
                {{$invoice->company->name}}
                @endif
                - {{formatCurrencyReal($invoice->totalPrice)}}
                - {{dateBr($invoice->pay_day)}}
            </option>
            @endforeach
        </select>
        @endif
        {{createButtonAdd('invoice.create')}}
        @endif
        <br>
        <label class="labels" for="">TIPO: </label>
        @if(!empty(app('request')->input('invoiceType')))
        <input type='hidden' name='type' value='{{app('request')->input('invoiceType')}}'>
        {{app('request')->input('invoiceType')}}
        @elseif($typeTransactions == 'receita')
        crédito
        <input type='hidden' name='type' value='crédito'>
        @elseif($typeTransactions == 'despesa')
        débito
        <input type='hidden' name='type' value='débito'>
        @elseif($typeTransactions == 'transferência')
        transferência
        <input type='hidden' name='type' value='transferência'>
        @endif
        <br>
        <br>
        <label class="labels" for="">DATA:</label>
        <input type="date" name="pay_day" value="{{date('d-m-y')}}">
        @if ($errors->has('pay_day'))
        <span class="text-danger">{{$errors->first('pay_day')}}</span>
        @endif
        <br>
        <label class="labels" for="">VALOR: </label><span style='margin-left:20px'>R$</span>
        @if ($errors->has('value'))
        <span class="text-danger">{{$errors->first('value')}}</span>
        @endif
        @if(!empty(app('request')->input('invoiceTotalPrice')))
        <input type="decimal" name="value" style="text-align: right" size='6' value="{{formatCurrency(app('request')->input('invoiceTotalPrice'))}}">
        @else
        <input type="decimal" name="value" style="text-align: right" size='6' value="{{formatCurrency(0)}}">
        @endif
              <br>
        <label class="labels" for="" >MEIO DE PAGAMENTO: </label>
        {{createSimpleSelect('payment_method', 'fields', returnPaymentMethods())}}
        <br>
        <br>
        <label class="labels" for="">Observações: </label>
        <textarea id="observations" name="observations" rows="5" cols="90" value="{{old('observations')}}">
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('observations');
        </script>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
</div>
<br>
<br>
@endsection