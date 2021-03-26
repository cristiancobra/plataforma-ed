@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{asset('imagens/socialmedia.png')}} 
@endsection

@section('description')
Total: <span class="labels">{{$total}}</span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('socialmedia.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div style="text-align: right">
	<form action="{{route('socialmedia.index')}}" method="post" style="color: #874983;display: inline-block">
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
			<td   class="table-list-header" style="width: 20%">
				NOME
			</td>
			<td   class="table-list-header" style="width: 25%">
				EMPRESA
			</td>
			<td   class="table-list-header" style="width: 25%">
				EMAIL
			</td>
			<td   class="table-list-header" style="width: 15%">
				TELEFONE
			</td>
			<td   class="table-list-header" style="width: 15%">
				DONO
			</td>
		</tr>

		@foreach($socialmedias as $socialmedia)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<a class="white" href=" {{route('socialmedia.show', ['socialmedia' => $socialmedia->id])}}">
					<button class="button-round">
						<i class='fa fa-eye'></i>
					</button>
				</a>
				<a class="white" href=" {{route('socialmedia.edit', ['socialmedia' => $socialmedia->id])}}">
					<button class="button-round">
						<i class='fa fa-edit'></i>
					</button>
				</a>
				{{$socialmedia->name}}
			</td>
			<td class="table-list-left">
				@if($socialmedia->companies)
				@foreach ($socialmedia->companies as $company)
				<a class="white" href=" {{route('company.show', ['company' => $company->id])}}">
					<button class="button-round">
						<i class='fa fa-eye'></i>
					</button>
				</a>
				<a class="white" href=" {{route('company.edit', ['company' => $company->id])}}">
					<button class="button-round">
						<i class='fa fa-edit'></i>
					</button>
				</a>
				{{$company->name}}
				<br>
				@endforeach
				@else
				Não possui
				@endif
			</td>
			<td class="table-list-left">
				{{$socialmedia->email}}
				<a class="white" href="">
					<button class="button-round">
						<i class='fa fa-envelope'></i>
					</button>
				</a>
			</td>
			<td class="table-list-right">
				{{$socialmedia->phone}}
			</td>
			<td class="table-list-center">
				{{$socialmedia->account->name}}
			</td>
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{$socialmedias->links()}}
	</p>
	<br>
	@endsection