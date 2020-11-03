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
		<label class="labels" for="" >CATEGORIA: </label>
		<select name="category">
			<option value="Agricultura">Agricultura</option>
			<option value="Biotecnologia">Biotecnologia</option>
			<option value="Química">Substâncias e produtos químicos</option>
			<option value="Aeroespacial">Aeroespacial</option>
			<option value="Computadores e hardware">Computadores e hardware</option>
			<option value="Construção">Construção</option>
			<option value="Consultoria">Consultoria</option>
			<option value="Produtos de consumo">Produtos de consumo</option>
			<option value="Serviços ao consumidor">Serviços ao consumidor</option>
			<option value="Marketing digital">Marketing digital</option>
			<option value="Educação">Educação</option>
			<option value="Eletrônica">Eletrônica</option>
			<option value="Moda">Moda</option>
			<option value="Serviços financeiros">Serviços financeiros</option>
			<option value="Alimentos e bebidas">Alimentos e bebidas</option>
			<option value="Jogos">Jogos</option>
			<option value="Serviços de saúde">Serviços de saúde</option>
			<option value="Indústria">Indústria</option>
			<option value="Internet/serviços da web">Internet/serviços da web</option>
			<option value="Serviços de TI">Serviços de TI</option>
			<option value="Jurídico">Jurídico</option>
			<option value="Estilo de vida">Estilo de vida</option>
			<option value="Marítimo">Marítimo</option>
			<option value="Marketing/publicidade">Marketing/publicidade</option>
			<option value="Mídias e entretenimento">Mídias e entretenimento</option>
			<option value="Mineração">Mineração</option>
			<option value="Petróleo e gás">Petróleo e gás</option>
			<option value="Política">Política</option>
			<option value="Imóveis">Imóveis</option>
			<option value="Varejo/distribuição">Varejo/distribuição</option>
			<option value="Segurança">Segurança</option>
			<option value="Software">Software</option>
			<option value="Esportes">Esportes</option>
			<option value="Telecomunicações">Telecomunicações</option>
			<option value="Transportes">Transportes</option>
			<option value="Turismo">Turismo</option>
			<option value="Outros">Outros</option>
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
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DE FECHAMENTO:</label>
		<input type="date" name="date_conclusion" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DE PAGAMENTO:</label>
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
		<label class="labels" for="">ETAPA DA VENDA:</label>
		<select class="fields" name="stage">
			<option value="prospecção">prospecção</option>
			<option value="apresentação">apresentação</option>
			<option value="proposta">proposta</option>
			<option value="ganhamos">ganhamos</option>
			<option value="perdemos">perdemos</option>
		</select>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="pendente">pendente</option>
			<option value="desativado">desativado</option>
			<option value="ativo">ativo</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR OPORTUNIDADE">
	</form>
</div>     
@endsection