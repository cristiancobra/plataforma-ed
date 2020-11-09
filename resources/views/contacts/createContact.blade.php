@extends('layouts/master')

@section('title','NOVO CONTATO')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('contact.index')}}">VER CONTATOS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('contact.store') }} " method="post" style="padding: 40px;color: #874983">
	@csrf
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
	<label for="" >Primeiro nome: </label>
	<input type="text" name="first_name">
	<br>
	<label for="" >Sobrenome: </label>
	<input type="text" name="last_name">
	<br>
	<br>
	<label for="" >CPF: </label>
	<input type="text" name="cpf">
	<br>
	<br>
	<label for="" >Data de Nascimento: </label>
	<input type="date" name="date_birth">
	<br>
	<br>
	<label for="" >Email: </label>
	<input type="text" name="email">
	<br>
	<label for="">Telefone: </label>
	<input type="text" name="phone">   
	<br>
	<br>
	<label for="">Site: </label>
	<input type="text" name="site">   
	<br>
	<label for="">Instagram: </label>
	<input type="text" name="instagram">   
	<br>
	<label for="">Facebook: </label>
	<input type="text" name="facebook">   
	<br>
	<label for="">Linkedin: </label>
	<input type="text" name="linkedin">   
	<br>
	<label for="">Twitter: </label>
	<input type="text" name="twitter">   
	<br>
	<label for="">Empresa: </label>
	<input type="text" name="company">   
	<br>
	<label for="">Cargo: </label>
	<input type="text" name="job_position">   
	<br>
		<br>
	<label for="">Profissão: </label>
	<input type="text" name="profession">   
	<br>
	<br>
	<label for="">Escolaridade: </label>
	<input type="text" name="schollarity">   
	<br>
	<br>
	<label for="">Estado Civil: </label>
	<input type="text" name="civil_state">   
	<br>
	<br>
	<label for="">Filhos: </label>
	<input type="text" name="kids">   
	<br>
	<br>
	<label for="">hobbie: </label>
	<input type="text" name="hobbie">   
	<br>
	<label for="">renda: </label>
	<input type="text" name="income">   
	<br>
		<br>
	<label for="">Religião: </label>
	<input type="text" name="religion">   
	<br>
	<br>
	<label for="">Etinia: </label>
	<input type="text" name="etinicity">   
	<br>
	<br>
	<label for="">Naturalidade: </label>
	<input type="text" name="naturality">   
	<br>
	<br>
	<label for="">Orientação Sexual: </label>
	<input type="text" name="sexual_orientation">   
	<br>
	<br>
	<label for="">Endereço: </label>
	<input type="text" name="address">   
	<br>
		<br>
	<label for="address_city">Cidade: </label>
	<input type="text" name="address_city">   
	<br>
	<label for="">Bairro: </label>
	<input type="text" name="neighborhood">   
	<br>
	<label for="">País: </label>
	<input type="text" name="address_country" value="Brasil">   
	<br>
	<br>
	<label for="">Tipo: </label>
	<input type="text" name="type">   
	<br>
	<br>
	<label for="">Origem do Lead: </label>
	<input type="text" name="lead_source">   
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" value="CRIAR">
</form>
</div>     
@endsection

		
		

	
				
			