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
	<label for="">Origem do Lead: </label>
	<select name="lead_source">
		<option  class="fields" value="site">
			site
		</option>
		<option  class="fields" value="pesquisa paga">
			pesquisa paga
		</option>
		<option  class="fields" value="pesquisa orgânica">
			pesquisa orgânica
		</option>
		<option  class="fields" value="email marketing">
			email marketing
		</option>
		<option  class="fields" value="indicação">
			indicação
		</option>
		<option  class="fields" value="mídia social">
			mídia social
		</option>
		<option  class="fields" value="outbound">
			outbound
		</option>
		<option  class="fields" value="desconhecida">
			desconhecida
		</option>
		<option  class="fields" value="outros">
			outros
		</option>
	</select>
	<br>
	<br>
	<br>
	<h2 class="name" for="">PESSOAL</h2>
	<label for="" >Primeiro nome: </label>
	<input type="text" name="first_name">
	<br>
	<label for="" >Sobrenome: </label>
	<input type="text" name="last_name">
	<br>
	<label for="" >Data de Nascimento: </label>
	<input type="date" name="date_birth">
	<br>
	<label for="" >CPF: </label>
	<input type="text" name="cpf">
	<br>
	<br>
	<br>

	<h2 class="name" for="">PROFISSIONAL</h2>
	<label for="">Profissão: </label>
	<input type="text" name="profession">   
	<br>
	<label for="">Empresa: </label>
	<input type="text" name="company">   
	<br>
	<label for="">Cargo: </label>
	<input type="text" name="job_position">   
	<br>
	<label for="">Escolaridade: </label>
	<select name="schollarity">
		<option  class="fields" value="fundamental">
			ensino fundamental
		</option>
		<option  class="fields" value="médio">
			ensino médio
		</option>
		<option  class="fields" value="superior incompleto">
			superior incompleto
		</option>
		<option  class="fields" value="superior completo">
			superior completo
		</option>
		<option  class="fields" value="pós-graduação">
			pós-graduação
		</option>
		<option  class="fields" value="sem escolaridade">
			sem escolaridade
		</option>
	</select>
	<br>
	<br>
	<br>

	<h2 class="name" for="">CONTATOS</h2>
	<label for="" >Email: </label>
	<input type="text" name="email">
	<br>
	<label for="">Telefone: </label>
	<input type="text" name="phone">   
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
	<br>
	<br>

	<h2 class="name" for="">LOCALIZAÇÃO</h2>
	<label for="">Endereço: </label>
	<input type="text" name="address">   
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
	<br>

	<h2 class="name" for="">PERFIL</h2>
	<p>Utilize esses dados apenas com permissão dos contatos e se você for importante para seu modelo de negócio, obedecendo o previsto na
		<a href="http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/L13709.htm">
			Lei Geral de Proteção de Dados
		</a>.
		<br>
		<br>	
		<label for="">Estado Civil: </label>
		<input type="text" name="civil_state">   
		<br>
		<label for="">Naturalidade: </label>
		<input type="text" name="naturality">
		<br>
		<label for="">Filhos: </label>
		<input type="text" name="kids">   
		<br>
		<label for="">Hobbie: </label>
		<input type="text" name="hobbie">   
		<br>
		<label for="">Renda: </label>
		<input type="text" name="income">   
		<br>
		<label for="">Religião: </label>
		<input type="text" name="religion">   
		<br>
		<label for="">Etinia: </label>
		<input type="text" name="etinicity">   
		<br>
		<label for="">Orientação Sexual: </label>
		<input type="text" name="sexual_orientation">   
		<br>
		<br>
		<label for="">Tipo: </label>
		<input type="text" name="type">
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
</form>
</div>     
@endsection