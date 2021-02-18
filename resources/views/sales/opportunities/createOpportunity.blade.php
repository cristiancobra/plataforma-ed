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
	<form action=" {{route('opportunity.store')}} " method="post" style="color: #874983">
		@csrf
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="60" value="{{old('name')}}"><span class="fields"></span>
		@if ($errors->has('name'))
		<span class="text-danger">{{$errors->first('name') }}</span>
		@endif
		<br>
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id }}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >RESPONSÁVEL: </label>
		<select name="user_id">
			<option  class="fields" value="{{Auth::user()->id}}">
				Eu
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{$user->id}}">
				{{$user->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >EMPRESA CONTRANTE: </label>
		<select name="company_id">
			@foreach ($companies as $company)
			<option  class="fields" value="{{$company->id }}">
				{{$company->name}}
			</option>
			@endforeach
		</select>
		{{createButtonAdd('company.create', 'typeCompanies', 'cliente')}}
		<br>
		<label class="labels" for="" >CONTATO: </label>
		<select name="contact_id">
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{$contact->id}}">
				{{$contact->name}}
			</option>
			@endforeach
		</select>
		{{createButtonAdd('contact.create')}}
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20"  value="{{old('date_start')}}"><span class="fields"></span>
		@if ($errors->has('date_start'))
		<span class="text-danger">{{$errors->first('date_start')}}</span>
		@endif
		<br>
		<label class="labels" for="" >DATA DE FECHAMENTO:</label>
		<input type="date" name="date_conclusion" size="20" value="{{old('date_conclusion')}}"><span class="fields"></span>
		@if ($errors->has('date_conclusion'))
		<span class="text-danger">{{$errors->first('date_conclusion')}}</span>
		@endif
		<br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		@if ($errors->has('description'))
		<span class="text-danger">{{$errors->first('description')}}</span>
		@endif
		<textarea id="description" name="description" rows="20" cols="90" value="{{old('description')}}">

		{{$opportunity->description}}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<label class="labels" for="">ETAPA DA VENDA:</label>
		{{createSelect('stage', 'fields', $stages)}}
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR OPORTUNIDADE">
	</form>
</div>
<br>
<br>
@endsection