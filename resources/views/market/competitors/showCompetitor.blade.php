@extends('layouts/master')

@section('title','CONCORRENTES')

@section('image-top')
{{ asset('imagens/competitors.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('competitor.index')}}">VER CONCORRENTES</a>
@endsection

@section('main')
<br>
<h1 class="name">
	{{ $competitor->name }}
</h1>
<label class="labels" for="" >DONO: </label> {{ $competitor->account->name }}
<br>
<br>
<label class="labels" for="" >Descrição: </label> {{ $competitor->description }}
<br>
<label class="labels" for="" >Cidade: </label> {{ $competitor->city }}
<br>
<label class="labels" for="" >Estado: </label> {{ $competitor->state }}
<br>
<label class="labels" for="" >País: </label> {{ $competitor->country }}
<br>
<br>
<label class="labels" for="" >Tipo: </label> {{ $competitor->type }}
<br>
<br>
<label class="labels" for="" >Site: </label> {{ $competitor->site }}
<br>
<br>
<label class="labels" for="" >Google Meu Negócio*: </label> {{ $competitor->google_business }}
<br>
<label class="labels" for="" >Pontuação: </label> {{ $competitor->google_business_score }}
<br>
<label class="labels" for="" >Quantidade de comentários: </label> {{ $competitor->google_business_comments }}
<br>
<br>
<label class="labels" for="" >Ifood: </label> {{ $competitor->ifood }}
<br>
<label class="labels" for="" >Pontuação: </label> {{ $competitor->ifood_score }}
<br>
<label class="labels" for="" >Quantidade de comentários: </label> {{ $competitor->ifood_comments }}
<br>
<br>
<label class="labels" for="" >Spotfy: </label> <a href="{{ $competitor->spotfy }}">{{ $competitor->spotfy }}</a>
<br>
<br>
<h2>SEGUIDORES NAS REDES SOCIAIS:</h2>
<div class="grid-dashboard">
    <div class="facebook">
        <div style="display: inline-block">
            <img class="grid-image" src="{{ asset('imagens/facebook.png') }}" style="width: 100px;height: 100px;text-align: left">
        </div>
        <div style="display: inline-block">
            FACEBOOK
            <br>
			<p style="font-size: 36px;color: white">
            {{ $competitor->facebook_followers }}
			</p>
        </div>
    </div>
	<div class="instagram">
		<div style="display: inline-block">
			<img class="grid-image" src="{{ asset('imagens/instagram.png') }}" style="width: 100px;height: 100px;text-align: left">
		</div>
		<div style="display: inline-block">
			INSTAGRAM
			<br>
			<p style="font-size: 36px;color: white">
			{{ $competitor->instagram_followers }}
			</p>
		</div>
	</div>
	<div class="linkedin">
		<div style="display: inline-block">
			<img class="grid-image" src="{{ asset('imagens/linkedin.png') }}" style="width: 100px;height: 100px;text-align: left">
		</div>
		<div style="display: inline-block">
			LINKEDIN
			<br>
			<p style="font-size: 36px;color: white">
			{{ $competitor->linkedin_followers }}
			</p>
		</div>
	</div>
	<div class="twitter">
		<div style="display: inline-block">
			<img class="grid-image" src="{{ asset('imagens/twitter.png') }}" style="width: 100px;height: 100px;text-align: left">
		</div>
		<div style="display: inline-block">
			TWITTER
			<br>
			<p style="font-size: 36px;color: white">
			   {{ $competitor->twitter_followers }}
			   </p>
		</div>
	</div>
	<div class="pinterest">
		<div style="display: inline-block">
			<img class="grid-image" src="{{ asset('imagens/pinterest.png') }}" style="width: 100px;height: 100px;text-align: left">
		</div>
		<div style="display: inline-block">
			PINTEREST
			<br>
			<p style="font-size: 36px;color: white">
			{{ $competitor->pinterest_followers }}
			</p>
		</div>
	</div>
	<div class="spotfy">
		<div style="display: inline-block">
			<img class="grid-image" src="{{ asset('imagens/spotfy.png') }}" style="width: 100px;height: 100px;text-align: left">
		</div>
		<div style="display: inline-block">
			SPOTFY
			<br>
			<p style="font-size: 36px;color: white">
			<!--{{ $competitor->spotfy }}-->
			</p>
		</div>
	</div>
</div>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($competitor->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('competitor.destroy', ['competitor' => $competitor->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('competitor.edit', ['competitor' => $competitor->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('competitor.index')}}">VOLTAR</a>
</div>
<br>

@endsection