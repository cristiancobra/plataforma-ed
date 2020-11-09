@extends('layouts/master')

@section('title','CONTATOS')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('contact.create')}}"">NOVO CONTATO</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalContacts }} contatos </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Nome</b></td>
			<td   class="table-list-header"><b>Email </b></td>
			<td   class="table-list-header"><b>Cidade </b></td>
			<td   class="table-list-header"><b>Dono</b></td>
			<td   class="table-list-header"><b>Status</b></td>
		</tr>

		@foreach ($contacts as $contact)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('contact.show', ['contact' => $contact->id]) }}">
						<i class='fa fa-eye'></i></a>
				</button>
				{{ $contact->name }}
			</td>

			<td class="table-list-left">
				{{ $contact->email }}
			</td>

			<td class="table-list-left">
				{{ $contact->address_city }}
			</td>

			<td class="table-list-left">
				{{ $contact->account->name }}
			</td>

			<td class="table-list-left">
				{{ $contact->status }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $contacts->links() }}
	</p>
	<br>
	@endsection