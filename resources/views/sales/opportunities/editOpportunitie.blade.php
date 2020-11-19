@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('opportunitie.index')}}">VER TODOS</a>
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
<div style="padding-left: 6%">
	<form action=" {{ route('opportunitie.update', ['opportunitie' =>$opportunitie->id]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="20" value="{{$opportunitie->name}}"><span class="fields"></span>
		@if ($errors->has('name'))
		<span class="text-danger">{{ $errors->first('name') }}</span>
		@endif
		<br>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			<option  class="fields" value="{{ $opportunitie->account->id }}">
				{{ $opportunitie->account->name }}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >CONTATO: </label>
		<select name="contact_id">
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{ $contact->id }}">
				{{ $contact->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20" value="{{$opportunitie->date_start}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DO PAGAMENTO:</label>
		<input type="date" name="pay_day" size="20" value="{{$opportunitie->pay_day}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		{{ $opportunitie->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>

		<br>
		<label class="labels" for="">ETAPA DA VENDA:</label>
		<select class="fields" name="stage">
			<option value="{{$opportunitie->stage}}">{{$opportunitie->stage}}</option>
			<option value="prospecção">prospecção</option>
			<option value="apresentação">apresentação</option>
			<option value="proposta">proposta</option>
			<option value="ganhamos">ganhamos</option>
			<option value="perdemos">perdemos</option>
		</select>
		<br>
		<label class="labels" for="" >PRÓXIMO CONTATO:</label>
		<input type="date" name="date_conclusion" size="20" value="{{$opportunitie->date_conclusion}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="{{$opportunitie->status}}">{{$opportunitie->status}}</option>
			<option value="pendente">pendente</option>
			<option value="fazendo agora">fazendo agora</option>
			<option value="cancelada">cancelada</option>
			<option value="concluida">concluida</option>
		</select>
		<br>
		<br>
		<div style="text-align: right">
			<input class="btn btn-secondary" style="display:inline-block" type="submit" value="SALVAR">	
			<a class="btn btn-secondary" href=" {{route('opportunitie.index')}} "  style="text-decoration: none;color: white;display: inline-block">
				<i class='fas fa-arrow-alt-circle-left'></i>  VOLTAR
			</a>
		</div>
	</form>
	<div style="text-align:right">
		<form   style="text-decoration: none;display: inline-block" action="{{ route('opportunitie.destroy', ['opportunitie' => $opportunitie->id]) }}" method="post">
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