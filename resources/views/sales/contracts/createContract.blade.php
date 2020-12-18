@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contract.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('contract.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="60" value="{{$contract->name}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DONO: </label>
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
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DE FECHAMENTO:</label>
		<input type="date" name="date_conclusion" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DO PAGAMENTO:</label>
		<input type="date" name="pay_day" size="20"><span class="fields"></span>
		<br>
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
		<br>
		<label class="labels" for="" >PRODUTOS: </label>
		@foreach ($products as $product)
		<p class="fields">
			<input type="checkbox" name="users[]" value="{{ $product->id }}">
			{{ $product->name }}
		</p>
		@endforeach
		<br>
		<br>
		<label class="labels" for="" >PREÇO:</label>
		<input type="integer" name="price" size="5" value="{{$contract->price}}"><span class="fields"></span>
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