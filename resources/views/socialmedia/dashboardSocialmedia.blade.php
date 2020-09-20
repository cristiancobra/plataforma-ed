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
            <a href=" {{ $facebook->URL_name}}" target="_blank" >
                <i class='fab fa-facebook'></i></a>
        </button>
        <button class="button">
            <a href=" {{ route('facebook.show', ['facebook' => $facebook->id]) }}" >
                <i class='fa fa-eye'></i></a>
        </button>
        {{$facebook->page_name}}
        <br>
        @endforeach
           <a href=" {{ route('facebook.create' ) }}"style=" color: white" > Adicionar nova conta</a> 
    </div>

    <div class="instagram">
        <img class="grid-image" src="{{ asset('imagens/instagram.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($instagrams as $instagram)
        <button class="button">
            <a href=" {{ $instagram->URL_name}}" target="_blank" >
                <i class='fab fa-facebook'></i></a>
        </button>
        <button class="button">
            <a href=" {{ route('instagram.show', ['instagram' => $instagram->id]) }}">
                <i class='fa fa-eye'></i></a>
        </button>
        {{$instagram->page_name}}
        <br>
        @endforeach
           <a href=" {{ route('instagram.create' ) }}"style=" color: white" > Adicionar nova conta</a> 
    </div>

    <div class="linkedin">
        <img class="grid-image" src="{{ asset('imagens/linkedin.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($linkedins as $linkedin)
        <button class="button">
            <a href=" {{ $linkedin->URL_name}}" target="_blank" >
                <i class='fab fa-linkedin-in'></i>
            </a>
        </button>
        <button class="button">
            <a href=" {{ route('linkedin.show', ['linkedin' => $linkedin->id]) }}" >
                <i class='fa fa-eye'></i>
            </a>
        </button>
        {{$linkedin->page_name}}
        <br>
        @endforeach
           <a href=" {{ route('linkedin.create' ) }}"style=" color: white" > Adicionar nova conta</a> 
    </div>

    <div class="twitter">
        <img class="grid-image" src="{{ asset('imagens/twitter.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($twitters as $twitter)
        <button class="button">
            <a href=" {{ $twitter->URL_name}}" target="_blank" >
                <i class='fab fa-twitter'></i></a>
        </button>
        <button class="button">
            <a href=" {{ route('twitter.show', ['twitter' => $twitter->id]) }}">
                <i class='fa fa-eye'></i></a>
        </button>
        {{$twitter->page_name}}
        <br>
        @endforeach
           <a href=" {{ route('twitter.create' ) }}"style=" color: white" > Adicionar nova conta</a> 
    </div>

   	<div class="pinterest">
		<img class="grid-image" src="{{ asset('imagens/pinterest.png') }} " style="width: 80px;height: 80px;text-align: center">
		<br>
		@foreach ($pinterests as $pinterest)
		<button class="button">
			<a href=" {{ $pinterest->URL_name}}" target="_blank" >
				<i class='fab fa-pinterest'></i></a>
		</button>
		<button class="button">
			<a href=" {{ route('pinterest.show', ['pinterest' => $pinterest->id]) }}" >
				<i class='fa fa-eye'></i></a>
		</button>
		{{$pinterest->page_name}}
		<br>
		@endforeach
                   <a href=" {{ route('pinterest.create' ) }}" style=" color: white" > Adicionar nova conta</a> 
	</div>

    <div class="youtube">
		<img class="grid-image" src="{{ asset('imagens/youtube.png') }} " style="width: 80px;height: 80px;text-align: center">
		<br>
		@foreach ($youtubes as $youtube)
		<button class="button">
			<a href=" {{ $youtube->URL_name}}" target="_blank" >
				<i class='fab fa-youtube'></i></a>
		</button>
		<button class="button">
			<a href=" {{ route('youtube.show', ['youtube' => $youtube->id]) }}" >
				<i class='fa fa-eye'></i></a>
		</button>
		{{$youtube->page_name}}
		<br>
		@endforeach
                   <a href=" {{ route('youtube.create' ) }}" style=" color: white" > Adicionar nova conta</a> 
	</div>
</div>
 <div class="spotify">
        <img class="grid-image" src="{{ asset('imagens/spotify.png') }}" style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($spotify as $spotify)
        <button class="button">
            <a href=" {{ $spotify->URL_name}}" target="_blank" >
                <i class='fab fa-spotify'></i></a>
        </button>
        <button class="button">
            <a href=" {{ route('spotify.show', ['spotify' => $spotify->id]) }}" >
                <i class='fa fa-eye'></i></a>
        </button>
        {{$spotify->page_name}}
        <br>
        @endforeach
           <a href=" {{ route('spotify.create' ) }}"style=" color: white" > Adicionar nova conta</a> 
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