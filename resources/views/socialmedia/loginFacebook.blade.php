@extends('layouts/master')

@section('title','LOGAR NO FACEBOOK')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Meus relatórios
<a href="/relatorios/novo"><br><br>
	<button type="button" class="button-header">CRIAR RELATÓRIO MATURIDADE DIGITAL</button> </a>

@endsection

@section('main')
<br>
<br>
<br>
<br>
<center>
	
<a href=" {{ $loginUrl }} ">
	<button type="button" class="button-header">
		LOGAR COM FACEBOOK
	</button> </a>
</center>
@endsection