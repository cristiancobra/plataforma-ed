@extends('layouts/master')

@if($variation == 'receita')
@section('title','PRODUTOS')
@else
@section('title','ITENS DE DESPESA')
@endif

@section('image-top')
{{ asset('images/products.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('product', 'variation', $variation)}}
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
    <form action="{{route('product.store')}}" method="post">
        @csrf
        @if($variation == 'receita')
        <input type="hidden" name="type" value="receita">
        @else
        <input type="hidden" name="type" value="despesa">
        @endif
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="20" style="width:90%" value="{{old('name')}}"><span class="fields"></span>
        @if ($errors->has('name'))
        <span class="text-danger">{{ $errors->first('name') }}</span>
        @endif
        <br>
        <label class="labels" for="" >CNAE:</label>
        <input type="text" name="cnae" size="20" value="{{old('cnae')}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >CATEGORIA:</label>
        {{createSimpleSelect('category', 'fields', returnProductCategory())}}
        <br>
        <br>
        <label class="labels" for="" >DESCRIÇÃO:</label>
        <textarea id="description" name="description" rows="20" cols="90">
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        @if($variation == 'receita')
        <label class="labels" for="" >HORAS NECESSÁRIAS:</label>
        <input class="text-right" type="decimal" name="work_hours" size="5" value="{{old('work_hours')}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >PONTOS FUNCIONAIS:</label>
        <input class="text-right" type="decimal" name="points" size="5" value="{{old('points')}}"><span class="fields"></span>
        <br>
        <br>
            <label class="labels" for="" >CUSTO 1:</label>
            <input type="integer" name="cost1" size="5"><span class="fields"></span>
            <label class="labels" for="" >descrição:</label>
            <input type="decimal" name="cost1_description" size="40"><span class="fields"></span>
            <br>
            <label class="labels" for="" >CUSTO 2:</label>
            <input type="integer" name="cost2" size="5"><span class="fields"></span>
            <label class="labels" for="" >descrição:</label>
            <input type="decimal" name="cost2_description" size="40"><span class="fields"></span>
            <br>
            <label class="labels" for="" >CUSTO 3:</label>
            <input type="integer" name="cost3" size="5""><span class="fields"></span>
            <label class="labels" for="" >descrição:</label>
            <input type="decimal" name="cost3_description" size="40"><span class="fields"></span>
            <br>
        <br>
        <label class="labels" for="" >IMPOSTO (%):</label>
        <input class="text-right" type="decimal" name="tax_rate" size="5" value="{{old('tax_rate')}}"><span class="fields"></span>
        <br>
        <br>
        @endif
        <label class="labels" for="" >PREÇO:</label>
        <input class="text-right" type="decimal" name="price" value="{{old('price')}}" style="text-align: right" size='6'>
        @if ($errors->has('price'))
        <span class="text-danger">{{ $errors->first('price') }}</span>
        @endif
        <br>
        <br>
        <label class="labels" for="" >PRAZO DE ENTREGA:</label>
        <input class="text-right" type="integer" name="due_date" size="5" value="{{old('due_date')}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', returnProductStatus())}}
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR PRODUTO">
    </form>
</div>

@endsection