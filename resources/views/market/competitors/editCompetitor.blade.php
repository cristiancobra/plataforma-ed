@extends('layouts/master')

@section('title','CONCORRENTES')

@section('image-top')
{{ asset('imagens/competitors.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('competitor.index')}}">VER TODOS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
	<form action=" {{ route('competitor.update', ['competitor' =>$competitor->id]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			<option  class="fields" value="{{ $competitor->account->id }}">
				{{ $competitor->account->name }}
			</option>
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
		<input type="text" name="name" value="{{ $competitor->name }}">
		<br>
		<label class="labels" for="" >
			Descrição:
		</label>
		<input type="text" name="description"  value="{{ $competitor->description }}">
		<br>
		<label class="labels" for="" >
			Cidade:
		</label>
		<input type="text" name="address_city"  value="{{ $competitor->city }}">
		<br>
		<label class="labels" for="" >
			Estado:
		</label>
		<select class="fields" name="state">
			<option value="{{ $competitor->state }}">{{ $competitor->state }}</option>
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
		<br>
		<label class="labels" for="" >
			País:
		</label>
		<input type="text" name="address_country"  value="{{ $competitor->country }}">
		<br>
		<br>
		<label class="labels" for="" >
			Tipo:
		</label>
		<select class="fields" name="type">
			<option  value="{{ $competitor->type }}"> {{ $competitor->type }}</option>
			<option value="Agricultura">Agricultura</option>
			<option value="Aeroespacial">Aeroespacial</option>
			<option value="Alimentos e bebidas">Alimentos e bebidas</option>
			<option value="Biotecnologia">Biotecnologia</option>
			<option value="Computadores e hardware">Computadores e hardware</option>
			<option value="Construção">Construção</option>
			<option value="Consultoria">Consultoria</option>
			<option value="Educação">Educação</option>
			<option value="Eletrônica">Eletrônica</option>
			<option value="Esportes">Esportes</option>
			<option value="Estilo de vida">Estilo de vida</option>
			<option value="Indústria">Indústria</option>
			<option value="Internet/serviços da web">Internet/serviços da web</option>
			<option value="Imóveis">Imóveis</option>
			<option value="Jogos">Jogos</option>
			<option value="Jurídico">Jurídico</option>
			<option value="Marketing digital">Marketing digital</option>
			<option value="Moda">Moda</option>
			<option value="Marítimo">Marítimo</option>
			<option value="Marketing/publicidade">Marketing/publicidade</option>
			<option value="Mídias e entretenimento">Mídias e entretenimento</option>
			<option value="Mineração">Mineração</option>
			<option value="Petróleo e gás">Petróleo e gás</option>
			<option value="Produtos de consumo">Produtos de consumo</option>
			<option value="Química">Substâncias e produtos químicos</option>
			<option value="Serviços ao consumidor">Serviços ao consumidor</option>
			<option value="Serviços financeiros">Serviços financeiros</option>
			<option value="Serviços de saúde">Serviços de saúde</option>
			<option value="Serviços de TI">Serviços de TI</option>
			<option value="Segurança">Segurança</option>
			<option value="Software">Software</option>
			<option value="Telecomunicações">Telecomunicações</option>
			<option value="Transportes">Transportes</option>
			<option value="Turismo">Turismo</option>
			<option value="Varejo/distribuição">Varejo/distribuição</option>
			<option value="Outros">Outros</option>
		</select>
		<br>
		<br>
		<label class="labels" for="" >
			Site:
		</label>
		<input type="text" name="site"  value="{{ $competitor->site }}">
		<br>
		<br>
		<label class="labels" for="" >
			Google Meu Negócio*: 
		</label>
		<input type="text" name="google_business" value="{{ $competitor->google_business }}">
		<br>
		* Se não possui sede e/ou loja física, marque NÃO SE APLICA.
		<br>
		<label class="labels" for="" >
			Pontuação:
		</label>
		<input type="number" step="any" name="google_business_score"  value="{{ $competitor->google_business_score }}">
		<br>
		<label class="labels" for="" >
			Quantidade de comentários:
		</label>
		<input type="number" name="google_business_comments"  value="{{ $competitor->google_business_comments }}">
		<br>
		<br>
		<label class="labels" for="" >
			Ifood:
		</label>
		<input type="text" name="ifood"  value="{{ $competitor->ifood }}">
		<br>
		* Se não possui sede e/ou loja física, marque NÃO SE APLICA.
		<br>
		<label class="labels" for="" >
			Pontuação:
		</label>
		<input type="number" name="ifood_score"  value="{{ $competitor->ifood_score }}">
		<br>
		<label class="labels" for="" >
			Quantidade de comentários:
		</label>
		<input type="number" name="ifood_comments"  value="{{ $competitor->ifood_comments }}">
		<br>
		<br>
		<label class="labels" for="" >
			Spotfy:
		</label>
		<input type="text" name="spotfy"  value="{{ $competitor->spotfy }}">
		<br>
		<br>
		<label class="labels" for="" >
			Seguidores no Facebook:
		</label>
		<input type="number" name="facebook_followers"  value="{{ $competitor->facebook_followers }}">
		<br>
		<br>
		<label class="labels" for="" >
			Seguidores no Instagram:
		</label>
		<input type="number" name="instagram_followers"  value="{{ $competitor->instagram_followers }}">
		<br>
		<br>
		<label class="labels" for="" >
			Seguidores no LinkedIn:
		</label>
		<input type="number" name="linkedin_followers"  value="{{ $competitor->linkedin_followers }}">
		<br>
		<br>
		<label class="labels" for="" >
			Seguidores no Twitter:
		</label>
		<input type="number" name="twitter_followers"  value="{{ $competitor->twitter_followers }}">
		<br>
		<br>
		<label class="labels" for="" >
			Seguidores no Pinterest:
		</label>
		<input type="number" name="pinterest_followers"  value="{{ $competitor->pinterest_followers }}">
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection