@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('imagens/planning.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('planning.index')}}">VER TODOS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
	<form action=" {{ route('planning.update', ['planning' =>$planning->id]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="20" value="{{$planning->name}}"><span class="fields"></span>
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
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		{{ $planning->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<label class="labels" for="" >HORAS NECESSÁRIAS:</label>
		<input type="decimal" name="work_hours" size="5" value="{{$planning->work_hours}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >CUSTO 1:</label>
		<input type="integer" name="cost1" size="5" value="{{$planning->cost1}}"><span class="fields"></span>
		<label class="labels" for="" >descrição:</label>
		<input type="decimal" name="cost1_description" size="40" value="{{$planning->cost1_description}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >CUSTO 2:</label>
		<input type="integer" name="cost2" size="5" value="{{$planning->cost1}}"><span class="fields"></span>
		<label class="labels" for="" >descrição:</label>
		<input type="decimal" name="cost2_description" size="40" value="{{$planning->cost2_description}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >CUSTO 3:</label>
		<input type="integer" name="cost3" size="5" value="{{$planning->cost1}}"><span class="fields"></span>
		<label class="labels" for="" >descrição:</label>
		<input type="decimal" name="cost3_description" size="40" value="{{$planning->cost3_description}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >IMPOSTO (%):</label>
		<input type="decimal" name="tax_rate" size="5" value="{{$planning->tax_rate}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >PREÇO:</label>
		<input type="decimal" name="price" size="5" value="{{$planning->price}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >PRAZO DE ENTREGA:</label>
		<input type="integer" name="due_date" size="5" value="{{$planning->due_date}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="{{$planning->status}}">{{$planning->status}}</option>
			<option value="pendente">pendente</option>
			<option value="fazendo agora">fazendo agora</option>
			<option value="cancelada">cancelada</option>
			<option value="concluida">concluida</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection