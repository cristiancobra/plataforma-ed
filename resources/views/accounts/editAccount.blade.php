@extends('layouts/master')

@section('title','EDITAR EMPRESA')

@section('image-top')
{{ asset('imagens/empresa.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('account.index')}}">VER EMPRESAS</a>
@endsection

@section('main')
<form action=" {{ route('account.update', ['account' =>$account->id]) }} " method="post" style="padding: 40px;color: white">
	@csrf
	@method('put')
	<label class="labels" for="">Nome: </label>
	<input type="text" name="name"  value="{{ $account->name }}">
	<br>
	<br>
	<label  class="labels" for="" >CNPJ: </label>
	<input type="text" name="cnpj"  value="{{ $account->cnpj}}">
	<br>
	<label class="labels" for="">Email: </label>
	<input type="text" name="email" value="{{ $account->email }}">
	<br>
	<label class="labels" for="">Telefone: </label>
	<input type="text" name="phone" value="{{ $account->phone }}">   
	<br>
	<label class="labels" for="">Site: </label>
	<input type="text" name="site" value="{{ $account->site }}">   
	<br>
	<br>
	<label class="labels" for="">Endereço: </label>
	<input type="text" name="address"  value="{{ $account->address }}">   
	<br>
	<label class="labels" for="">Cidade: </label>
	<input type="text" name="address_city" value="{{ $account->address_city }}">   
	<br>
	<label class="labels" for="">Estado: </label>
	<input type="text" name="address_state" value="{{ $account->address_state }}">   
	<br>
	<label class="labels" for="">País: </label>
	<input type="text" name="address_country" value="{{ $account->address_country }}">   
	<br>
	<br>
	<label class="labels" for="">Segmento: </label>
	<select name="type">
			<option value="{{ $account->type }}">{{ $account->type }}</option>
			<option value="agricultura">Agricultura</option>
			<option value="biotecnologia">Biotecnologia</option>
			<option value="química">Substâncias e produtos químicos</option>
			<option value="aeroespacial">Aeroespacial</option>
			<option value="hardware">Computadores e hardware</option>
			<option value="construção">Construção</option>
			<option value="consultoria">Consultoria</option>
			<option value="produtos de consumo">Produtos de consumo</option>
			<option value="serviços ao consumidor">Serviços ao consumidor</option>
			<option value="marketing digital">Marketing digital</option>
			<option value="educação">Educação</option>
			<option value="eletrônica">Eletrônica</option>
			<option value="moda">Moda</option>
			<option value="serviços financeiros">Serviços financeiros</option>
			<option value="alimentos e bebidas">Alimentos e bebidas</option>
			<option value="jogos">Jogos</option>
			<option value="serviços de saúde">Serviços de saúde</option>
			<option value="indústria">Indústria</option>
			<option value="internet/serviços da web">Internet/serviços da web</option>
			<option value="serviços de TI">Serviços de TI</option>
			<option value="jurídico">Jurídico</option>
			<option value="estilo de vida">Estilo de vida</option>
			<option value="marítimo">Marítimo</option>
			<option value="marketing/publicidade">Marketing/publicidade</option>
			<option value="mídias e entretenimento">Mídias e entretenimento</option>
			<option value="mineração">Mineração</option>
			<option value="petróleo e gás">Petróleo e gás</option>
			<option value="política">Política</option>
			<option value="imóveis">Imóveis</option>
			<option value="varejo/distribuição">Varejo/distribuição</option>
			<option value="segurança">Segurança</option>
			<option value="software">Software</option>
			<option value="esportes">Esportes</option>
			<option value="telecomunicações">Telecomunicações</option>
			<option value="transportes">Transportes</option>
			<option value="turismo">Turismo</option>
			<option value="outros">Outros</option>
		</select>
	<br>
	<label class="labels" for="">Qtde empregados: </label>
	<input type="text" name="employees" value="{{ $account->employees }}">
	<br>
	<br>
	<label class="labels" for="">Logomarca: </label>
	<input type="text" name="logo" value="{{ $account->logo }}">   
	<br>
	<label class="labels" for="">Cor principal: </label>
	<input type="text" name="principal_color" value="{{ $account->principal_color }}">   
	<br>
	<label class="labels" for="">Cor complementar: </label>
	<input type="text" name="complementary_color" value="{{ $account->complementary_color }}">   
	<br>
	<label class="labels" for="">Cor oposta: </label>
	<input type="text" name="opposite_color" value="{{ $account->opposite_color }}">   
	<br>
	<br>
	<label class="labels" for="" >DESCRIÇÃO:</label>
	<textarea id="description" name="description" rows="20" cols="90">
		{{ $account->description }}
	</textarea>
	<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
	<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script>
CKEDITOR.replace('description');
	</script>
	<br>
	<label class="labels" for="status">SITUAÇÃO: </label>
	<select class="fields" name="status">
		<option value="{{ $account->status }}">{{ $account->status}}</option>
		@if ($account->status == "desativado")
		<option value="ativo">ativo</option>
		<option value="pendente">pendente</option>
		@elseif  ($account->status == "ativo")
		<option value="desativado">desativado</option>
		<option value="pendente">pendente</option>
		@elseif  ($account->status == "pendente")
		<option value="ativo">ativo</option>
		<option value="desativado">desativado</option>
		@endif
	</select>
	<br>
	<br>
	<label class="labels" for="" >Colaboradores: </label>
	<br>
	@foreach ($users as $user)
	<p class="fields">
		<input type="checkbox" name="users[]" value="{{ $user->id}}"
			   @if (in_array($user->id, $usersChecked))
		<br
			checked
			@endif
			>
		{{ $user->name }}
	</p>
	@endforeach
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" value="ATUALIZAR">

</form>
@endsection