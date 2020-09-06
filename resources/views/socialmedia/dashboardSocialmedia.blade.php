@extends('layouts/master')

@section('title','PAINEL REDES SOCIAIS')

@section('image-top')
{{ asset('imagens/control-panel.png') }} 
@endsection

@section('description')
<span style="color: yellow;font-size: 22px">{{ $hoje }} </span>
@endsection

@section('main')
<div class="grid-dashboard">
    <div class="facebook">
        <img class="grid-image" src="{{ asset('imagens/facebook.png') }}" style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($facebooks as $facebook)
        <button class="button">
            <a href=" {{ $facebook->URL_name}}" target="_blank" style="text-decoration: none;color: black">
                <i class='fab fa-facebook'></i></a>
        </button>
        <button class="button">
            <a href=" {{ route('facebook.show', ['facebook' => $facebook->id]) }}" style="text-decoration: none;color: black">
                <i class='fa fa-eye'></i></a>
        </button>
        {{$facebook->page_name}}
        <br>
        @endforeach
    </div>

    <div class="instagram">
        <img class="grid-image" src="{{ asset('imagens/instagram.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($instagrams as $instagram)
        <button class="button">
            <a href=" {{ $instagram->URL_name}}" target="_blank" style="text-decoration: none;color: black">
                <i class='fab fa-facebook'></i></a>
        </button>
        <button class="button">
            <a href=" {{ route('instagram.show', ['instagram' => $instagram->id]) }}" style="text-decoration: none;color: black">
                <i class='fa fa-eye'></i></a>
        </button>
        {{$instagram->page_name}}
        <br>
        @endforeach
    </div>

    <div class="linkedin">
        <img class="grid-image" src="{{ asset('imagens/linkedin.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($linkedins as $linkedin)
        <button class="button">
            <a href=" {{ $linkedin->URL_name}}" target="_blank" style="text-decoration: none;color: black">
                <i class='fab fa-linkedin-in'></i>
            </a>
        </button>
        <button class="button">
            <a href=" {{ route('linkedin.show', ['linkedin' => $linkedin->id]) }}" style="text-decoration: none;color: black">
                <i class='fa fa-eye'></i>
            </a>
        </button>
        {{$linkedin->page_name}}
        <br>
        @endforeach
    </div>

    <div class="twitter">
        <img class="grid-image" src="{{ asset('imagens/twitter.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($twitters as $twitter)
        <button class="button">
            <a href=" {{ $twitter->URL_name}}" target="_blank" style="text-decoration: none;color: black">
                <i class='fab fa-twitter'></i></a>
        </button>
        <button class="button">
            <a href=" {{ route('twitter.show', ['twitter' => $twitter->id]) }}" style="text-decoration: none;color: black">
                <i class='fa fa-eye'></i></a>
        </button>
        {{$twitter->page_name}}
        <br>
        @endforeach
    </div>

   	<div class="pinterest">
		<img class="grid-image" src="{{ asset('imagens/pinterest.png') }} " style="width: 80px;height: 80px;text-align: center">
		<br>
		@foreach ($pinterests as $pinterest)
		<button class="button">
			<a href=" {{ $pinterest->URL_name}}" target="_blank" style="text-decoration: none;color: black">
				<i class='fab fa-pinterest'></i></a>
		</button>
		<button class="button">
			<a href=" {{ route('pinterest.show', ['pinterest' => $pinterest->id]) }}" style="text-decoration: none;color: black">
				<i class='fa fa-eye'></i></a>
		</button>
		{{$pinterest->page_name}}
		<br>
		@endforeach
	</div>

    <div class="area6">
        <img class="grid-image" src="{{ asset('imagens/twitter.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>

    </div>
</div>


<div style="padding-top: 3%;padding-left: 2%; padding-right: 4%;display: inline-block;text-align: left;vertical-align: top">
    <img src=" {{ asset('imagens/cao-astronauta-left.png') }} " width="150px" height="150px">
</div>

<div style="padding-top: 1%; padding-left: 4%; padding-right: 4%;display: inline-block">
    <br>	
    <p style="color:purple; font-weight: 400;line-height: 2;padding-top: 2%;font-size: 28px">
        <b>Olá {{$userAuth->name}}, já organizou seu dia?</b>
    </p>
    <p style="color:purple; font-weight: 400;line-height: 2;padding-top: 2%;font-size: 18px">
        Use os links do painel e não deixe suas tarefas acumularem. <br>Use o menu lateral para navegar através dos DEPARTAMENTOS.
    </p>
</div>
@endsection