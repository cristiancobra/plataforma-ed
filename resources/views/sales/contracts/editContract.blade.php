@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('contract')}}
@endsection

@section('main')
<div>
    <form action=" {{route('contract.update', ['contract' => $contract->id])}} " method="post">
        @csrf
        @method('put')
        <label class="labels" for="" >EMPRESA: </label>
        <select name="account_id">
            <option  class="fields" value="{{$contract->account_id}}">
                {{$contract->account->name}}
            </option>
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >RESPONSÁVEL NA MINHA EMPRESA: </label>
        <select name="user_id">
            <option  class="fields" value="{{$contract->user_id}}">
                {{$contract->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >OPORTUNIDADE: </label>
        <select name="opportunity_id">
            <option  class="fields" value="{{$contract->opportunity_id}}">
                {{$contract->opportunity->name}}
            </option>
            @foreach ($opportunities as $opportunity)
            <option  class="fields" value="{{$opportunity->id}}">
                {{$opportunity->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >FATURA: </label>
        <select name="invoice_id">
            <option  class="fields" value="{{$contract->invoice_id}}">
                {{$contract->invoice->identifier}} - {{$contract->company->name}} - {{formatCurrencyReal($contract->invoice->totalPrice)}}
            </option>
            @foreach ($invoices as $invoice)
            <option  class="fields" value="{{$invoice->id}}">
                {{$invoice->identifier}} - 
                @isset($invoice->company)
                {{$invoice->company->name}} - 
                @endisset
                {{formatCurrencyReal($invoice->totalPrice)}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >EMPRESA CONTRATANTE: </label>
        <select name="company_id">
            <option  class="fields" value="{{$contract->company_id}}">
                {{$contract->company->name}}
            </option>
            @foreach ($companies as $company)
            <option  class="fields" value="{{$company->id}}">
                {{$company->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >CLIENTE RESPONSÁVEL: </label>
        <select name="contact_id">
            <option  class="fields" value="{{$contract->contact_id}}">
                {{$contract->contact->name}}
            </option>
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{ $contact->id }}">
                {{$contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >PRIMEIRA TESTEMUNHA: </label>
        <select name="witness1">
            <option  class="fields" value="{{$contract->witness1}}">
                {{$witnessName1}}
            </option>
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{$contact->id}}">
                {{$contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >SEGUNDA TESTEMUNHA: </label>
        <select name="witness2">
            <option  class="fields" value="{{$contract->witness2}}">
                {{$witnessName2}}
            </option>
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{$contact->id}}">
                {{$contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >DATA DE INICIO:</label>
        <input type="date" name="date_start" size="20" value="{{$contract->date_start}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >DATA DO VENCIMENTO:</label>
        <input type="date" name="date_due" size="20" value="{{$contract->date_due}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="" >MODELO DO CONTRATO: </label>
        <select name="contractTemplate_id">
            @foreach ($contractsTemplates as $contractTemplate)
            <option  class="fields" value="{{ $contractTemplate->id }}">
                {{ $contractTemplate->name }}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="20" value="{{$contract->name}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="" >TEXTO DO CONTRATO:</label>
        <textarea id="text" name="text" rows="10" cols="90">
		{{$contract->text}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('text');
        </script>
        <br>
        <br>
        <label class="labels" for="" >OBSERVAÇÕES:</label>
        <textarea id="observations" name="observations" rows="10" cols="90">
		{!!html_entity_decode($contract->observations)!!}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('observations');
        </script>
        <br>
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status','fields', returnContractStatus(), $contract->status)}}
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
</div>
<br>
<br>
@endsection