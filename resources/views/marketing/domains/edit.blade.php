@extends('layouts/master')

@section('title','DOMÍNIOS')

@section('image-top')
{{ asset('images/domain.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('domain')}}
@endsection

@section('main')
<div>
	<form action=" {{ route('domain.update', ['domain' =>$domain->id]) }} " method="post">
		@csrf
		@method('put')
		<label class="labels" for="" >DOMÍNIO:</label>
		<input type="text" name="name" size="60" value="{{$domain->name}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >SITE: </label>
		<select name="site_id">
			@foreach ($sites as $site)
			<option  class="fields" value="{{ $site->id }}">
				{{ $site->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >NOME DO TITULAR:</label>
		<select name="contact_id">
			<option  class="fields" value="{{$domain->contact_id}}">
				{{$domain->contact->name}}
			</option>
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{$contact->id}}">
				{{$contact->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >PROVEDOR DO DOMÍNIO:</label>
		<input type="text" name="provider" size="60" value="{{$domain->provider}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LINK DO PROVEDOR:</label>
		<input type="text" name="link_provider" size="60" value="{{$domain->link_provider}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >SENHA DO PROVEDOR:</label>
		<input type="text" name="provider_password" size="60" value="{{$domain->domain_password}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >DATA DE VENCIMENTO:</label>
		<input type="date" name="due_date" size="20" value="{{$domain->due_date}}"><span class="fields"></span>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		{{createSimpleSelect('status', 'fields', returnStatusActive())}}
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection