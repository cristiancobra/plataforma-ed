@extends('layouts/master')

@if($typeTransactions == 'crédito')
@section('title','ENTRADAS')
@elseif($typeTransactions == 'débito')
@section('title','SAÍDAS')
@elseif($typeTransactions == 'transferência')
@section('title','TRANSFERÊNCIAS')
@endif

@section('image-top')
{{asset('images/transaction.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('transaction')}}
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action=" {{route('transaction.store')}} " method="post">
        @csrf

        @if(!empty(app('request')->input('invoiceType')))
        <input type='hidden' name='type' value='{{app('request')->input('invoiceType')}}'>
        @elseif($typeTransactions == 'crédito')
        <input type='hidden' name='type' value='crédito'>
        @elseif($typeTransactions == 'débito')
        <input type='hidden' name='type' value='débito'>
        @elseif($typeTransactions == 'transferência')
        <input type='hidden' name='type' value='transferência'>
        @endif

        <label class="labels" for="">REGISTRADO POR:</label>
        <select name="user_id">
            <option  class="fields" value="{{auth()->user()->id}}">
                Eu
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
        @if($typeTransactions == 'transferência')
        <label class="labels" for="">CONTA DE DESTINO:</label>
        <select name="bank_account_destiny_id">
            @foreach ($bankAccounts as $bankAccount)
            <option  class="fields" value="{{$bankAccount->id}}">
                {{$bankAccount->name}}
            </option>
            @endforeach
        </select>
        @endif
        <br>
        @if($typeTransactions != 'transferência')
        @if(!empty(app('request')->input('invoiceId')))
        <input type="hidden" name='invoice_id' value="{{app('request')->input('invoiceId')}}">
        @else
        <label class="labels" for="">FATURA: </label>
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
        {{createButtonAdd('invoice.create')}}
        @endif
        @endif
        <br>
        <label class="labels" for="">DATA:</label>
        @if(!empty(app('request')->input('pay_day')))
        <input type="date" name="pay_day" value="{{app('request')->input('pay_day')}}">
        @else
        <input type="date" name="pay_day" value="{{date('d-m-y')}}">
        @endif
        @if ($errors->has('pay_day'))
        <span class="text-danger">{{$errors->first('pay_day')}}</span>
        @endif
        <br>
        <label class="labels" for="">VALOR: </label>
        @if ($errors->has('value'))
        <span class="text-danger">{{$errors->first('value')}}</span>
        @endif
        <input type="decimal" name="value" style="text-align: right" size='12' value="{{formatCurrencyReal($invoiceTotalPrice)}}">
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

@section('js-scripts')
    <script>
        $("[name=value]").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    </script>
@endsection