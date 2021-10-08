@extends('layouts/master')

@if(app('request')->input('typeTransactions') == 'crédito')
@section('title','ENTRADAS')
@else
@section('title','SAÍDAS')
@endif

@section('image-top')
{{asset('images/transaction.png')}} 
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
    <form action=" {{route('transaction.update', [
                                                                            'transaction' => $transaction,
                                                                            'typeTransactions' => 'débito',
                                                                            ])}} " method="post" style="color: #874983">
        @csrf
        @method('put')
        <label class="labels" for="" >REGISTRADO POR:</label>
        <select name="user_id">
            <option  class="fields" value="{{$transaction->user_id}}">
                {{$transaction->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >CONTA: </label>
        <select name="bank_account_id">
            <option  class="fields" value="{{$transaction->bank_account_id}}">
                {{$transaction->bankAccount->name}}
            </option>
            @foreach ($bankAccounts as $bankAccount)
            <option  class="fields" value="{{$bankAccount->id}}">
                {{$bankAccount->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >FATURA: </label>
        <select name="invoice_id">
            <option  class="fields" value="{{$transaction->invoice_id}}">
                {{$transaction->invoice_id}}
            </option>
            @foreach ($invoices as $invoice)
            <option  class="fields" value="{{$invoice->id}}">
                {{$invoice->id}} -
                @if(isset($invoice->opportunity))
                {{$invoice->opportunity->company->name}}
                @else
                {{$invoice->company->name}}
                @endif
                - {{formatCurrencyReal($invoice->totalPrice)}}
                - {{dateBr($invoice->pay_day)}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >TIPO: </label>
        {{app('request')->input('typeTransactions')}}
        <br>
        <label class="labels" for="" >DATA:</label>
        <input type="date" name="pay_day" size="20" value="{{$transaction->pay_day}}"><span class="fields"></span>
        <br>
        <label class="labels" for="">VALOR: </label>
        <input type="decimal" name="value" size='12' style="text-align: right" value="{{formatCurrencyReal($transaction->value)}}">
        @if ($errors->has('value'))
        <span class="text-danger">{{$errors->first('value')}}</span>
        @endif
        <br>
        <label class="labels" for="" >MEIO DE PAGAMENTO: </label>
        {{createSimpleSelect('payment_method', 'fields', returnPaymentMethods(), $transaction->payment_method)}}
        <br>
        <br>
        <label class="labels" for="" >OBSERVAÇÕES:</label>
        <br>
        <textarea id="description" name="observations" rows="5" cols="90"  value="{{old('observations')}}">
		{{$transaction->observations}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
</div>
<br>
<br>
@endsection


@section('js-scripts')
    <script>
    // formatar entrada do dinheiro
        $("[name=value]").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    </script>
@endsection