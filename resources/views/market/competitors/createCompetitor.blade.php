@extends('layouts/master')

@section('title','CONCORRENTES')

@section('image-top')
{{ asset('imagens/competitors.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('competitor.index')}}">VER TODOS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('competitor.store') }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	<label class="labels" for="" >
		DONO:
	</label>
	<select name="account_id">
		@foreach ($accounts as $account)
		<option  class="fields" value="{{ $account->id }}">
			{{ $account->name }}
		</option>
		@endforeach
	</select>
	<br>
	<br>
	<label class="labels" for="" >
		Nome:
	</label>
	<input type="text" name="name">
	<br>
	<label class="labels" for="" >
		Descrição:
	</label>
	<input type="text" name="description">
	<br>
	<label class="labels" for="" >
		Cidade:
	</label>
	<input type="text" name="city">   
	<br>
	<label class="labels" for="" >
		Estado:
	</label>
	<select class="fields" name="state">
	<option value="Acre">Acre</option>
	<option value="Alagoas">Alagoas</option>
	<option value="Amapá">Amapá</option>
	<option value="Amazonas">Amazonas</option>
	<option value="Bahia">Bahia</option>
	<option value="Ceará">Ceará</option>
	<option value="Distrito Federal">Distrito Federal</option>
	<option value="Espírito Santo">Espírito Santo</option>
	<option value="Goiás">Goiás</option>
	<option value="Maranhão">Maranhão</option>
	<option value="Mato Grosso">Mato Grosso</option>
	<option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
	<option value="Minas Gerais">Minas Gerais</option>
	<option value="Pará">Pará</option>
	<option value="Paraíba">Paraíba</option>
	<option value="Paraná">Paraná</option>
	<option value="Pernambuco">Pernambuco</option>
	<option value="Piauí">Piauí</option>
	<option value="Rio de Janeiro">Rio de Janeiro</option>
	<option value="Rio Grande do Norte">Rio Grande do Norte</option>
	<option value="Rio Grande do Sul">Rio Grande do Sul</option>
	<option value="Rondônia">Rondônia</option>
	<option value="Roraima">Roraima</option>
	<option value="Santa Catarina">Santa Catarina</option>
	<option value="São Paulo">São Paulo</option>
	<option value="Sergipe">Sergipe</option>
	<option value="Tocantins">Tocantins</option>
	</select>
	<br>
	<label class="labels" for="" >
		País:
	</label>
	<input type="text" name="country" value="Brasil">   
	<br>
	<br>
	<label class="labels" for="" >
		Tipo:
	</label>
	<select class="fields" name="type">
	<option value="Agricultura">Agricultura</option>
	<option value="Biotecnologia">Biotecnologia</option>
	<option value="Química41">Substâncias e produtos químicos</option>
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
	<label class="labels" for="" >
		Site:
	</label>
	<input type="text" name="site">
	<br>
	<br>
	<label class="labels" for="" >
		Google Meu Negócio*:
	</label>
	<input type="text" name="google_business" value="não se aplica">
	<br>
	* Se não possui sede e/ou loja física, marque NÃO SE APLICA.
	<br>
	<label class="labels" for="" >
		Pontuação:
	</label>
	<input type="number" step='any' name="google_business_score" value="não se aplica">
	<br>
	<label class="labels" for="" >
		Quantidade de comentários:
	</label>
	<input type="number" name="google_business_comments" value="não se aplica">
	<br>
	<br>
	<label class="labels" for="" >
		Ifood:
	</label>
	<input type="text" name="ifood" value="não se aplica">
	<br>
	* Se não possui sede e/ou loja física, marque NÃO SE APLICA.
	<br>
	<label class="labels" for="" >
		Pontuação:
	</label>
	<input type="number" name="ifood_score" value="não se aplica">
	<br>
	<label class="labels" for="" >
		Quantidade de comentários:
	</label>
	<input type="number" name="ifood_comments" value="não se aplica">
	<br>
	<br>
	<label class="labels" for="" >
		Spotfy:
	</label>
	<input type="text" name="spotfy">
	<br>
	<br>
	<label class="labels" for="" >
		Seguidores no Facebook:
	</label>
	<input type="number" name="facebook_followers" value=0>
	<br>
	<br>
	<label class="labels" for="" >
		Seguidores no Instagram:
	</label>
	<input type="number" name="instagram_followers" value=0>
	<br>
	<br>
	<label class="labels" for="" >
		Seguidores no LinkedIn:
	</label>
	<input type="number" name="linkedin_followers" value=0>
	<br>
	<br>
	<label class="labels" for="" >
		Seguidores no Twitter:
	</label>
	<input type="number" name="twitter_followers" value=0>
	<br>
	<br>
	<label class="labels" for="" >
		Seguidores no Pinteres:
	</label>
	<input type="number" name="pinteres_followers" value=0>
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" value="Criar concorrente">
</form>
</div>     
@endsection