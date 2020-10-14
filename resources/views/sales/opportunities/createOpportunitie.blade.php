@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('opportunitie.index') }}">VER OPORTUNIDADES</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('opportunitie.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="60" value="{{$opportunitie->name}}"><span class="fields"></span>
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
		<label class="labels" for="" >CATEGORIA:</label>
		<select class="fields" name="category">
			<option value="desenvolvimento">desenvolvimento</option>
			<option value="financeiro">financeiro</option>
			<option value="marketing">marketing</option>
			<option value="planejamento">planejamento</option>
			<option value="serviço">serviço</option>
			<option value="suporte">suporte</option>
			<option value="venda">venda</option>
		</select>
		<br>
		<br>
		<label class="labels" for="" >CONTATO: </label>
		<select name="contact">
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
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		{{ $opportunitie->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
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
		<input type="integer" name="price" size="5" value="{{$opportunitie->price}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">ETAPA DA VENDA:</label>
		<select class="fields" name="stage">
			<option value="prospecting">prospecção</option>
			<option value="meeting">apresentação</option>
			<option value="proposal">proposta</option>
			<option value="won">ganhamos</option>
			<option value="lose">perdemos</option>
		</select>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="pendente">pendente</option>
			<option value="fazendo agora">fazendo agora</option>
			<option value="cancelada">cancelada</option>
			<option value="concluida">concluida</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR OPORTUNIDADE">
	</form>
</div>     
@endsection