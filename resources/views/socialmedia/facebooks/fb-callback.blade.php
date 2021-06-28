@extends('layouts/master')

@section('title','LOGAR NO FACEBOOK')

@section('image-top')
{{ asset('images/email.png') }} 
@endsection

@section('description')

Meus relatórios
<a href="/relatorios/novo"><br><br>
	<button type="button" class="button-header">CRIAR RELATÓRIO MATURIDADE DIGITAL</button> </a>

@endsection

@section('main')

<img src=" {{$me['picture'] ['url']}}"> <br>
Nome: {{$me['name']}}<br>
Nome: {{$me['first_name']}}<br>
Nome: {{$me['about']}}<br>




@endsection