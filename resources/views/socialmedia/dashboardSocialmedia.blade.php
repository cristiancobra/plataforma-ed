@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{ asset('imagens/control-panel.png') }} 
@endsection

@section('description')
@endsection

@section('main')
<div class="grid-dashboard">
    <div class="facebook">
        <img class="grid-image" src="{{ asset('imagens/socialmedia/facebook.png') }}" style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($facebooks as $facebook)
		<a class="button-round"  href=" {{ $facebook->URL_name}}" target="_blank" >
			<i class='fab fa-facebook'></i>
		</a>
		<a class="button-round"  href=" {{ route('facebook.show', ['facebook' => $facebook->id]) }}" >
			<i class='fa fa-eye'></i>
		</a>
        {{$facebook->page_name}}
        <br>
        @endforeach
        <a href=" {{ route('facebook.create' ) }}"style=" color: white" >
			Adicionar nova conta
		</a> 
    </div>

    <div class="instagram">
        <img class="grid-image" src="{{ asset('imagens/socialmedia/instagram.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($instagrams as $instagram)
		<a class="button-round" href=" {{ $instagram->URL_name}}" target="_blank" >
			<i class='fab fa-instagram-square'></i>
		</a>
		<a class="button-round" href=" {{ route('instagram.show', ['instagram' => $instagram->id]) }}">
			<i class='fa fa-eye'></i>
		</a>
        {{$instagram->page_name}}
        <br>
        @endforeach
        <a href=" {{ route('instagram.create' ) }}"style=" color: white" >
			Adicionar nova conta
		</a> 
    </div>

    <div class="linkedin">
        <img class="grid-image" src="{{ asset('imagens/socialmedia/linkedin.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($linkedins as $linkedin)
		<a class="button-round" href=" {{ $linkedin->URL_name}}" target="_blank" >
			<i class='fab fa-linkedin-in'></i>
		</a>
		<a class="button-round"  href=" {{ route('linkedin.show', ['linkedin' => $linkedin->id]) }}" >
			<i class='fa fa-eye'></i>
		</a>
        {{$linkedin->page_name}}
        <br>
        @endforeach
		<a href=" {{ route('linkedin.create' ) }}"style=" color: white" >
			Adicionar nova conta
		</a> 
    </div>

    <div class="twitter">
        <img class="grid-image" src="{{ asset('imagens/socialmedia/twitter.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($twitters as $twitter)
		<a class="button-round"  href=" {{ $twitter->URL_name}}" target="_blank" >
			<i class='fab fa-twitter'></i></a>
		<a  class="button-round" href=" {{ route('twitter.show', ['twitter' => $twitter->id]) }}">
			<i class='fa fa-eye'></i></a>
        {{$twitter->page_name}}
        <br>
        @endforeach
        <a href=" {{ route('twitter.create' ) }}"style=" color: white" > Adicionar nova conta</a> 
    </div>

    <div class="pinterest">
        <img class="grid-image" src="{{ asset('imagens/socialmedia/pinterest.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($pinterests as $pinterest)
		<a class="button-round" href=" {{ $pinterest->URL_name}}" target="_blank" >
			<i class='fab fa-pinterest'></i>
		</a>
		<a  class="button-round" href=" {{ route('pinterest.show', ['pinterest' => $pinterest->id]) }}" >
			<i class='fa fa-eye'></i>
		</a>
        {{$pinterest->page_name}}
        <br>
        @endforeach
		<a  href="{{route('pinterest.create')}}" style=" color: white" >
			Adicionar nova conta
		</a> 
    </div>

    <div class="youtube">
        <img class="grid-image" src="{{ asset('imagens/socialmedia/youtube.png') }} " style="width: 80px;height: 80px;text-align: center">
        <br>
        @foreach ($youtubes as $youtube)
		<a class="button-round"  href=" {{ $youtube->URL_name}}" target="_blank" >
			<i class='fab fa-youtube'></i>
		</a>
		<a  class="button-round" href=" {{ route('youtube.show', ['youtube' => $youtube->id]) }}" >
			<i class='fa fa-eye'></i>
		</a>
        {{$youtube->page_name}}
        <br>
        @endforeach
        <a href=" {{ route('youtube.create' ) }}" style=" color: white" >
			Adicionar nova conta
		</a> 
    </div>
</div>
<br>
<br>
<div class="spotify">
    <img class="grid-image" src="{{ asset('imagens/socialmedia/spotify.png') }}" style="width: 80px;height: 80px;text-align: center">
    <br>
    @foreach ($spotifys as $spotify)
	<a class="button-round"  href=" {{ $spotify->URL_name}}" target="_blank" >
		<i class='fab fa-spotify'></i>
	</a>
	<a class="button-round"  href=" {{ route('spotify.show', ['spotify' => $spotify->id]) }}" >
		<i class='fa fa-eye'></i></a>
</button>
{{$spotify->page_name}}
<br>
@endforeach
<a href="{{route('spotify.create')}}"style=" color: white" >
	Adicionar nova conta
</a> 
</div>
<br>
<br>
@endsection