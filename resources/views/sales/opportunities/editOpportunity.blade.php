@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('opportunity.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
	{{ Session::get('failed') }}
	@php
	Session::forget('failed');
	@endphp
</div>
@endif
<div>
	<form action=" {{route('opportunity.update', ['opportunity' =>$opportunity->id])}} " method="post" style="color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="20" value="{{$opportunity->name}}"><span class="fields"></span>
		@if ($errors->has('name'))
		<span class="text-danger">{{$errors->first('name')}}</span>
		@endif
		<br>
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			<option  class="fields" value="{{$opportunity->account->id}}">
				{{$opportunity->account->name}}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >RESPONSÁVEL: </label>
		<select name="user_id">
			<option  class="fields" value="{{$opportunity->user_id}}">
				{{$opportunity->user->contact->name}}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{$user->id}}">
				{{$user->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >EMPRESA CONTRATANTE: </label>
		<select name="company_id">
			<option  class="fields" value="{{$opportunity->company_id}}">
				{{$opportunity->company->name}}
			</option>
			@foreach ($companies as $company)
			<option  class="fields" value="{{$company->id}}">
				{{$company->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >CONTATO: </label>
		<select name="contact_id">
			<option  class="fields" value="{{$opportunity->contact_id}}">
				{{$opportunity->contact->name}}
			</option>
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{ $contact->id }}">
				{{ $contact->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20" value="{{$opportunity->date_start}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		{{ $opportunity->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>

		<br>
		<label class="labels" for="">ETAPA DA VENDA:</label>
		{{editSelect('stage', 'fields', $stages, $opportunity->stage)}}
		<br>
		<label class="labels" for="" >PRÓXIMO CONTATO:</label>
		<input type="date" name="date_conclusion" size="20" value="{{$opportunity->date_conclusion}}"><span class="fields"></span>
		<br>
		<br>
		<div style="display: inline-block">
			{{submitFormButton('SALVAR')}}
			</form>
			<a class="button-secondary" href=" {{route('opportunity.index')}} "  style="text-decoration: none;color: white;display: inline-block">
				<i class='fas fa-arrow-alt-circle-left'></i>  VOLTAR
			</a>
			<form   style="text-decoration: none;display: inline-block" action="{{ route('opportunity.destroy', ['opportunity' => $opportunity->id]) }}" method="post">
				@csrf
				@method('delete')
				<input class="btn btn-danger" type="submit" value="APAGAR">
			</form>
		</div>
		<br>
		</div>
		<br>
		<br>
		@endsection