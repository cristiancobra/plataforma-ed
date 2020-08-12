@extends('layouts/master')

@section('title','PÁGINAS DO FACEBOOK')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Acompanhe suas páginas do Face
<a href="{{ route('facebook.create') }}"><br><br>
	<button type="button" class="button-header">CADASTRAR NOVA PÁGINA</button> </a>

@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">Você possui <span class="labels">{{$totalFacebooks }} contas de email</span></p>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Nome da página</b></td>
		<td   class="table-list-header"><b>Dono </b></td>
		<td   class="table-list-header"><b>Empressa </b></td>
		<td   class="table-list-header"><b>Senha</b></td>
		<td   class="table-list-header"><b>Status</b></td>
	</tr>

	@foreach ($facebooks as $facebook)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button">
				<a href=" https://empresadigital.net.br/webmail" target="_blank"  style="text-decoration: none;color: black">
					<i class='fa fa-envelope'></i></a>
			</button>
			
			@if ($user->perfil == "administrador")
			<button class="button">
				<a href=" {{ route('facebook.show', ['facebook' => $facebook->id]) }}" style="text-decoration: none;color: black">
					<i class='fa fa-cogs'></i></a>
			</button>
			@endif
			{{ $facebook->email}}
		</td>
		
		
		<td class="table-list-left"> <b>{{ $facebook->page_name }} </b></td>
		<td class="table-list-center"><b>{{ $facebook->storage}}</b></td>
		<td class="table-list-center"><b>{{ $facebook->email_password }} </b></td>
		@if ($facebook->status == "desativado")
		<td class="button-disable"><b>{{ $facebook->status  }}</b></td>
		@elseif ($facebook->status == "ativo")
		<td class="button-active"><b>{{ $facebook->status  }}</b></td>
		@else ($facebook->status == "pendente")
		<td class="button-delete"><b>{{ $facebook->status  }}</b></td>
		@endif
	</tr>
	@endforeach
</table>
@endsection
