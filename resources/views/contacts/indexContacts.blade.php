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
<div style="text-align: right">
	<form action="{{route('contact.index')}}" method="post" style="color: #874983;display: inline-block">
		@csrf
		<input type="text" name="name" placeholder="nome do contato" value="">
		<select class="select" name="account_id">
			<option  class="select" value="">
				Qualquer empresa
			</option>
			@foreach ($accounts as $account)
			<option  class="select" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
			<option  class="select" value="">
				todas
			</option>
		</select>
		<input class="btn btn-secondary" type="submit" value="FILTRAR">
	</form>
</div>
<br>
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