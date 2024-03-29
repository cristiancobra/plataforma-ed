@extends('layouts/master')

@section('title','TRANSFERÊNCIA')

@section('image-top')
{{asset('images/transaction.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')

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
    <form action=" {{route('transaction.storeTransfer')}} " method="post">
        @csrf
        <label class="labels" for="">REGISTRADO POR:</label>
        <select name="user_id">
            <option  class="fields" value="{{auth()->user()->id}}">
                Eu
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="offset-2 col-3 text-center pt-4 pb-4 rounded white" style="background-color: red">
                    <label class="labels" for="" style="color: white">CONTA DE ORIGEM:</label>
                    <br>
                    <br>
                    <select name="bank_account_id">
                        @foreach ($bankAccounts as $bankAccount)
                        <option  class="fields" value="{{$bankAccount->id}}">
                            {{$bankAccount->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="offset-2 col-3 text-center pt-4 pb-4 rounded" style="background-color: blue">
                    <label class="labels" for="" style="color: white">CONTA DE DESTINO:</label>
                    <br>
                    <br>
                    <select name="bank_account_destiny_id">
                        @foreach ($bankAccounts as $bankAccount)
                        <option  class="fields" value="{{$bankAccount->id}}">
                            {{$bankAccount->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
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
        <input type="decimal" name="value" style="text-align: right" size='12'>
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
    $("[name=value]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
</script>
@endsection