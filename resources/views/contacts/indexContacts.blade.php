@extends('layouts/master')

@section('title','CONTATOS')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalContacts }} </span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contact.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				<b>Nome</b>
			</td>
			<td   class="table-list-header">
				<b>Email</b>
			</td>
			<td   class="table-list-header">
				<b>Telefone</b>
			</td>
			<td   class="table-list-header">
				<b>Cidade </b>
			</td>
			<td   class="table-list-header">
				<b>Dono</b>
			</td>
		</tr>

		@foreach ($contacts as $contact)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<a class="white" href=" {{route('contact.show', ['contact' => $contact->id])}}">
					<button class="button-round">
						<i class='fa fa-eye'></i>
					</button>
				</a>
				<a class="white" href=" {{route('contact.edit', ['contact' => $contact->id])}}">
					<button class="button-round">
						<i class='fa fa-edit'></i>
					</button>
				</a>
				{{$contact->name}}
			</td>
			<td class="table-list-left">
				{{$contact->email}}
			</td>
			<td class="table-list-right">
				{{$contact->phone}}
			</td>
			<td class="table-list-center">
				{{$contact->city}}
			</td>
			<td class="table-list-center">
				{{$contact->account->name}}
			</td>
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{$contacts->links()}}
	</p>
	<br>
	@endsection