@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('contract.index') }}">VER CONTRATOS</a>
@endsection

@section('main')
<div>
    <form action=" {{ route('contract.store') }} " method="post" style="padding: 40px;color: #874983">
        @csrf
        <label class="labels" for="" >EMPRESA: </label>
        <select name="account_id">
            @foreach ($accounts as $account)
            <option  class="fields" value="{{ $account->id }}">
                {{ $account->name }}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >OPORTUNIDADE: </label>
        <select name="opportunitie">
            @foreach ($opportunities as $opportunitie)
            <option  class="fields" value="{{ $opportunitie->id }}">
                {{ $opportunitie->name }}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >CONTATO: </label>
        <select name="contact_id">
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{ $contact->id }}">
                {{ $contact->name }}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >PRIMEIRA TESTEMUNHA: </label>
        <select name="witness1">
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{ $contact->id }}">
                {{ $contact->name }}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >SEGUNDA TESTEMUNHA: </label>
        <select name="witness2">
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{ $contact->id }}">
                {{ $contact->name }}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >DATA DE INICIO:</label>
        <input type="date" name="date_start" size="20"><span class="fields"></span>
        <br>
        <label class="labels" for="" >DATA DA ENTREGA FINAL:</label>
        <input type="date" name="date_conclusion" size="20"><span class="fields"></span>
        <br>
        <label class="labels" for="" >DATA DO PAGAMENTO:</label>
        <input type="date" name="pay_day" size="20"><span class="fields"></span>
        <br>
             <br>
        <label class="labels" for="" >OBRIGAÇÕES DA EMPRESA:</label>
>
        <textarea id="accountObrigation" name="accountObrigation" rows="20" cols="90">
		{{ $contract->observations }}
        </textarea>
<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('accountObrigation');
        </script>
        <br>
        <br>
            <br>
        <label class="labels" for="" >OBRIGAÇÕES DO CLIENTE:</label>
        <textarea id="contactObrigation" name="contactObrigation" rows="20" cols="90">
		{{ $contract->contactObrigation }}
        </textarea>
                   <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('contactObrigation');
        </script>
        <br>
        
        <label class="labels" for="" >OBSERVAÇÕES:</label>
        <textarea id="observations" name="observations" rows="20" cols="90">
		{{ $contract->observations }}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('observations');
        </script>
        <br>
    <label class="labels" for="" >PRODUTOS:</label>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 5%">
			<b>QTDE
			</b></td>
		<td   class="table-list-header" style="width: 55%">
			<b>NOME</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>PRAZO</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>IMPOSTO </b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>UNITÁRIO</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>TOTAL</b>
		</td>
	</tr>

	@foreach ($invoiceLines as $invoiceLine)
	<tr style="font-size: 14px">
		<td class="table-list-center">
			{{$invoiceLine->amount}}
		</td>
		<td class="table-list-left">
			{{$invoiceLine->product->name}}
		</td>
		<td class="table-list-center">
			{{$invoiceLine->subtotalDeadline}} dia(s)
		</td>
		<td class="table-list-right">
			{{ number_format($invoiceLine->subtotalTax_rate, 2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($invoiceLine->product->price,2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($invoiceLine->subtotalPrice,2,",",".") }}
		</td>
	</tr>

	<tr style="font-size: 12px">
		<td class="table-list-left" colspan="5">
			{!!html_entity_decode($invoiceLine->product->description)!!}
		</td>
	</tr>
	@endforeach

	<tr>
		<td   class="table-list-header-right" colspan="4">
		</td>
		<td   class="table-list-header-right">
			desconto: 
		</td>
		<td   class="table-list-header-right">
			<b>- {{number_format($invoice->discount, 2,",",".") }}</b>
		</td>
	</tr>
	<tr>
		<td   class="table-list-header-right" colspan="4">
			
		<td   class="table-list-header-right">
			TOTAL: 
		</td>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($invoice->totalPrice, 2,",",".") }}</b>
		</td>
	</tr>
</table>
<br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        <select class="fields" name="status">
            <option value="pending">pendente</option>
            <option value="disable">desativado</option>
            <option value="active">ativo</option>
        </select>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR CONTRATO">
    </form>
</div>     
@endsection