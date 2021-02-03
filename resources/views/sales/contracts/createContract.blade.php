@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contract.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{route('contract.store')}} " method="post" style="color: #874983">
		@csrf
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >RESPONSÁVEL NA MINHA EMPRESA: </label>
		<select name="user_id">
			@foreach ($users as $user)
			<option  class="fields" value="{{$user->id}}">
				{{$user->contact->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >OPORTUNIDADE: </label>
		<select name="opportunity_id">
			@foreach ($opportunities as $opportunity)
			<option  class="fields" value="{{$opportunity->id}}">
				{{$opportunity->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >FATURA: </label>
		{{createSelect('invoice_id', 'fields', $invoices)}}
		<br>
		<br>
		<label class="labels" for="" >EMPRESA CONTRATANTE: </label>
		<select name="company_id">
			@foreach ($companies as $company)
			<option  class="fields" value="{{ $company->id }}">
				{{$company->name}}
			</option>
			@endforeach
		</select>
		<a class="white" href=" {{route('company.create')}}">
			<button class="button-round">
				<i class='fa fa-plus'></i>
			</button>
		</a>
		<br>
		<label class="labels" for="" >CLIENTE RESPONSÁVEL: </label>
		<select name="contact_id">
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{ $contact->id }}">
				{{$contact->name}}
			</option>
			@endforeach
		</select>
		<button class="button-round">
			<a href=" {{route('contact.create')}}">
				<i class='fa fa-plus' style="color:white"></i></a>
		</button>
		<br>
		<label class="labels" for="" >PRIMEIRA TESTEMUNHA: </label>
		<select name="witness1">
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{$contact->id}}">
				{{$contact->name}}
			</option>
			@endforeach
		</select>
		<button class="button-round">
			<a href=" {{route('contact.create')}}">
				<i class='fa fa-plus' style="color:white"></i></a>
		</button>
		<br>
		<label class="labels" for="" >SEGUNDA TESTEMUNHA: </label>
		<select name="witness2">
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{$contact->id}}">
				{{$contact->name}}
			</option>
			@endforeach
		</select>
		<button class="button-round">
			<a href=" {{route('contact.create')}}">
				<i class='fa fa-plus' style="color:white"></i></a>
		</button>
		<br>
		<br>
		<label class="labels" for="" >DATA DE INICIO:</label>
		<input type="date" name="date_start" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DO VENCIMENTO:</label>
		<input type="date" name="date_due" size="20"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >MODELO DO CONTRATO: </label>
		<select name="contractTemplate_id">
			@foreach ($contractsTemplates as $contractTemplate)
			<option  class="fields" value="{{$contractTemplate->id}}">
				{{$contractTemplate->name}}
			</option>
			@endforeach
		</select>
		<button class="button-round">
			<a href=" {{route('contractTemplate.create')}}">
				<i class='fa fa-plus' style="color:white"></i></a>
		</button>
		<br>
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="20" value=""><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >OBSERVAÇÕES:</label>
		<p>Informações internas, não aparecerão no contrato final (PDF).</p>
		<textarea id="observations" name="observations" rows="20" cols="90">
{{$contract->observations}}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('observations');
		</script>
		<br>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		{{createSelect('status','fields', returnContractStatus())}}
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
</div>
<br>
<br>
@endsection