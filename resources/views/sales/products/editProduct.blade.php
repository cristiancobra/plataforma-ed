@extends('layouts/master')

@section('title','PRODUTOS')

@section('image-top')
{{ asset('imagens/products.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('product', 'variation', $variation)}}
@endsection

@section('main')
<div>
    <form action="{{route('product.update', ['product' => $product->id, 'variation' => $variation])}}" method="post"  enctype='multipart/form-data'>
        @csrf
        @method('put')
        <div class='container text-center'>
            <div class='product-image'>
                @if($product->image_id != null)
                <img src='{{asset($product->image->path)}}' width='100%' height='100%'>
                @else
                <img src='{{asset('imagens/products.png')}}'  width='100%' heigh='100%'>
                @endif
            </div>
            {{createSelectIdName('image_id', 'select', $images, 'Nenhuma')}} ou 
            <input type='file' name='image'>
        </div>
        <br>
        <br>
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="20" value="{{$product->name}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >DONO: </label>
        <select name="account_id">
            <option  class="fields" value="{{$product->account->id}}">
                {{$product->account->name}}
            </option>
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >CATEGORIA:</label>
        {{createSimpleSelect('category', 'fields', returnProductCategory(), $product->category)}}
        <br>
        <br>
        <label class="labels" for="" >DESCRIÇÃO:</label>
        <textarea id="description" name="description" rows="20" cols="90">
		{{$product->description}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <label class="labels" for="" >HORAS NECESSÁRIAS:</label>
        <input type="decimal" name="work_hours" size="5" value="{{$product->work_hours}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="" >CUSTO 1:</label>
        <input type="integer" name="cost1" size="5" value="{{$product->cost1}}"><span class="fields"></span>
        <label class="labels" for="" >descrição:</label>
        <input type="decimal" name="cost1_description" size="40" value="{{$product->cost1_description}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >CUSTO 2:</label>
        <input type="integer" name="cost2" size="5" value="{{$product->cost2}}"><span class="fields"></span>
        <label class="labels" for="" >descrição:</label>
        <input type="decimal" name="cost2_description" size="40" value="{{$product->cost2_description}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >CUSTO 3:</label>
        <input type="integer" name="cost3" size="5" value="{{$product->cost3}}"><span class="fields"></span>
        <label class="labels" for="" >descrição:</label>
        <input type="decimal" name="cost3_description" size="40" value="{{$product->cost3_description}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >IMPOSTO (%):</label>
        <input type="decimal" name="tax_rate" size="5" value="{{$product->tax_rate}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="" >PREÇO:</label>
        <input type="decimal" name="price" size="5" value="{{$product->price}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="" >PRAZO DE ENTREGA:</label>
        <input type="integer" name="due_date" size="5" value="{{$product->due_date}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', returnProductStatus(), $product->status)}}
        <br>
        <br>
        <input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

    </form>
</div>
<br>
<br>
@endsection