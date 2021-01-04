@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalOpportunities}}</span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('opportunity.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<form action=" {{ route('opportunity.index') }} " method="post" style="text-align: right;color: #874983">
	@csrf
	<input type="text" name="name" placeholder="nome da oportunidade" value="">
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
	<select class="select" name="contact_id">
		<option  class="select" value="">
			Qualquer contato
		</option>
		@foreach ($contacts as $contact)
		<option  class="select" value="{{$contact->id}}">
			{{$contact->name}}
		</option>
		@endforeach
		<option  class="fields" value="">
			todas
		</option>
	</select>
	<select class="select"name="user_id">
		<option  class="select" value="">
			Qualquer funcionário
		</option>
		@foreach ($users as $user)
		<option  class="select" value="{{ $user->id }}">
			{{ $user->contact->name }}
		</option>
		@endforeach
	</select>
	<select class="select" name="stage">
		<option  class="select" value="">
			Todas etapas
		</option>
		<option  class="select" value="fazer">
			fazer
		</option>
		<option  class="select" value="aguardar">
			aguardar
		</option>
		<option  class="select" value="feito">
			feitas
		</option>
		<option  class="select" value="cancelado">
			canceladas
		</option>
	</select>
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header">
			<b>NOME </b>
		</td>
		<td   class="table-list-header">
			<b>CONTATO </b>
		</td>
		<td   class="table-list-header">
			<b>RESPONSÁVEL </b>
		</td>
		<td   class="table-list-header">
			<b>FAZER CONTATO </b>
		</td>
		<td   class="table-list-header">
			<b>ETAPA DA VENDA</b>
		</td>
	</tr>

	@foreach ($opportunities as $opportunity)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			<button class="button-round">
				<a href=" {{ route('opportunity.show', ['opportunity' => $opportunity->id]) }}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button-round">
				<a href=" {{ route('opportunity.edit', ['opportunity' => $opportunity->id]) }}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
			{{ $opportunity->name }}
		</td>
		<td class="table-list-center">
			{{ $opportunity->contact->name }}
		</td>
		<td class="table-list-center">
			{{ $opportunity->user->name }}
		</td>
		<td class="table-list-center">
			@isset($opportunity->date_conclusion)
			{{date('d/m/Y', strtotime($opportunity->date_conclusion))}}
			@else
			sem data
			@endisset
		</td>
		{{formatStage($opportunity)}}
	</tr>
	@endforeach
</table>
<p style="text-align: right">
	<br>
	{{ $opportunities->links() }}
</p>
<br>
@endsection