@extends('layouts/master')

@section('title','DOMÍNIOS')

@section('image-top')
{{ asset('imagens/domain.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('domain.index')}}">VER PRODUTOS</a>
@endsection

@section('main')
<br>
<h1 class="name">
	{{ $domain->name }}
</h1>
<label class="labels" for="" >FOTO:</label>
<span class="fields">{{$domain->image}}</span>
<br>
<label class="labels" for="" >DONO: </label>
<span class="fields">{{$domain->account->name }}</span>
<br>
<label class="labels" for="" >TIPO:</label>
<span class="fields">{{$domain->type }}</span>
<br>
<label class="labels" for="" >CATEGORIA:</label>
<span class="fields">{{$domain->category }}</span>
<br>
<label class="labels" for="" >DESCRIÇÃO:</label>
<span class="fields">{!!html_entity_decode($domain->description )!!}</span>
<br>
<label class="labels" for="" >HORAS NECESSÁRIAS:</label>
<span class="fields">{{$domain->work_hours }}</span>
<br>
<br>
<label class="labels" for="" >CUSTO 1:</label>
<span class="fields">R$ {{ number_format($domain->cost1, 2,",",".") }}</span>
<label class="labels" for="" >descrição:</label>
<span class="fields">{{$domain->cost1_description }}</span>
<br>
<label class="labels" for="" >CUSTO 2:</label>
<span class="fields">R$ {{ number_format($domain->cost2, 2,",",".") }}</span>
<label class="labels" for="" >descrição:</label>
<span class="fields">{{$domain->cost2_description }}</span>
<br>
<label class="labels" for="" >CUSTO 3:</label>
<span class="fields">R$ {{ number_format($domain->cost3, 2,",",".") }}</span>
<label class="labels" for="" >descrição:</label>
<span class="fields">{{$domain->cost3_description }}</span>
<br>
<label class="labels" for="" >CUSTO TOTAL:</label>
<span class="fields">R$ {{ number_format($domain->cost1 + $domain->cost2 +$domain->cost3, 2,",",".") }}</span>
<br>
<br>
<label class="labels" for="" >MARGEM DE CONTRIBUIÇÃO (R$):</label>
<span class="fields">R$ {{ number_format(-$domain->price * $domain->tax_rate /100 - $domain->cost1 - $domain->cost2 - $domain->cost3 + $domain->price, 2,",",".") }}</span>
<br>
<br>
<label class="labels" for="" >IMPOSTO:</label>
<span class="fields">{{$domain->tax_rate }} %</span>
<br>
<label class="labels" for="" >IMPOSTO:</label>
<span class="fields">R$ {{ number_format($domain->price * $domain->tax_rate / 100, 2,",",".") }}</span>
<br>
<label class="labels" for="" >PREÇO:</label>
<span class="fields">R$ {{ number_format($domain->price, 2,",",".") }}</span>
<br>
<br>
<label class="labels" for="" >PRAZO DE ENTREGA:</label>
<span class="fields">{{$domain->due_date }}</span>
<br>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$domain->status }}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($domain->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('domain.destroy', ['domain' => $domain->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('domain.edit', ['domain' => $domain->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('domain.index')}}">VOLTAR</a>
</div>
<br>

@endsection