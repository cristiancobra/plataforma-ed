@extends('layouts/master')

@section('title','INSTAGRAM')

@section('image-top')
{{ asset('imagens/instagram.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('report.create') }}">NOVO RELATÓRIO</a>
<a class="btn btn-primary" href="{{ route('instagram.create') }}">NOVA CONTA</a>
@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
	Você possui <span class="labels">{{$totalInstagrams }} contas de email</span>
</p>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Nome da página</b></td>
		<td   class="table-list-header"><b>Dono </b></td>
		<td   class="table-list-header"><b>Status</b></td>
	</tr>

	@foreach ($instagrams as $instagram)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button" >
				<a href=" {{ $instagram->URL_name}}"  target="_blank"  style="text-decoration: none;color: black">
					<i class='fab fa-instagram-square'></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('instagram.show', ['instagram' => $instagram->id]) }}" style="text-decoration: none;color: black">
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $instagram->page_name}}
		</td>
		<td class="table-list-center"><b>{{ $instagram->users()->first()->name}}</b></td>

		@if ($instagram->status == "desativado")
		<td class="button-disable"><b>{{ $instagram->status  }}</b></td>
		@elseif ($instagram->status == "ativo")
		<td class="button-active"><b>{{ $instagram->status  }}</b></td>
		@else ($instagram->status == "pendente")
		<td class="button-delete"><b>{{ $instagram->status  }}</b></td>
		@endif
	</tr>
	@endforeach
</table>
@endsection
