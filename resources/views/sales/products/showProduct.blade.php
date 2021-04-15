@extends('layouts/master')

@if($variation == 'receita')
@section('title','PRODUTOS')
@else
@section('title','ITENS DE DESPESA')
@endif

@section('image-top')
{{asset('imagens/products.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('product.index', ['variation' => $variation])}}">
    <i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('main')
<br>
<h1 class="name">
    {{$product->name}}
</h1>
<label class="labels" for="" >FOTO:</label>
<span class="fields">{{$product->image}}</span>
<br>
<label class="labels" for="" >DONO: </label>
<span class="fields">{{$product->account->name}}</span>
<br>
<label class="labels" for="" >CATEGORIA:</label>
<span class="fields">{{$product->category}}</span>
<br>
<label class="labels" for="" >DESCRIÇÃO:</label>
<span class="fields">{!!html_entity_decode($product->description )!!}</span>
<br>
<label class="labels" for="" >HORAS NECESSÁRIAS:</label>
<span class="fields">{{$product->work_hours}}</span>
<br>
<br>
<label class="labels" for="" >CUSTO 1:</label>
<span class="fields">R$ {{number_format($product->cost1, 2,",",".")}}</span>
<label class="labels" for="" >descrição:</label>
<span class="fields">{{$product->cost1_description}}</span>
<br>
<label class="labels" for="" >CUSTO 2:</label>
<span class="fields">R$ {{number_format($product->cost2, 2,",",".")}}</span>
<label class="labels" for="" >descrição:</label>
<span class="fields">{{$product->cost2_description}}</span>
<br>
<label class="labels" for="" >CUSTO 3:</label>
<span class="fields">R$ {{number_format($product->cost3, 2,",",".")}}</span>
<label class="labels" for="" >descrição:</label>
<span class="fields">{{$product->cost3_description}}</span>
<br>
<label class="labels" for="" >CUSTO TOTAL:</label>
<span class="fields">R$ {{number_format($product->cost1 + $product->cost2 +$product->cost3, 2,",",".")}}</span>
<br>
<br>
<label class="labels" for="" >MARGEM DE CONTRIBUIÇÃO (R$):</label>
<span class="fields">{{formatCurrencyReal(-$product->price * $product->tax_rate /100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price)}}</span>
<br>
<br>
<label class="labels" for="" >IMPOSTO:</label>
<span class="fields">{{$product->tax_rate}} %</span>
<br>
<label class="labels" for="" >IMPOSTO:</label>
<span class="fields">R$ {{number_format($product->price * $product->tax_rate / 100, 2,",",".")}}</span>
<br>
<label class="labels" for="" >PREÇO:</label>
<span class="fields">R$ {{number_format($product->price, 2,",",".")}}</span>
<br>
<br>
<label class="labels" for="" >PRAZO DE ENTREGA:</label>
<span class="fields">{{$product->due_date}}</span>
<br>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$product->status}}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{date('d/m/Y H:i', strtotime($product->created_at))}} </p>

<div style="text-align:right;padding: 2%">
    <form   style="text-decoration: none;display: inline-block" action="{{route('product.destroy', ['product' => $product->id])}}" method="post">
        @csrf
        @method('delete')
        <input class="btn btn-danger" type="submit" value="APAGAR">
    </form>
    <a class="button-secondary" href="{{route('product.edit', ['product' => $product->id, 'variation' => $variation])}}"  style="text-decoration: none;display: inline-block">
        <i class='fa fa-edit'></i>EDITAR
    </a>
    <a class="button-secondary"  href="{{route('product.index', ['variation' => $variation])}}">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<br>

@endsection