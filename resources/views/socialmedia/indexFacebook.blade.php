@extends('layouts/master')

@section('title','VER RELATÓRIOS')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Meus relatórios
<a href="/relatorios/novo"><br><br>
	<button type="button" class="button-header">CRIAR RELATÓRIO MATURIDADE DIGITAL</button> </a>

@endsection

@section('main')

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '904299616735303',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>



@endsection