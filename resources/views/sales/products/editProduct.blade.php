@extends('layouts/master')

@section('title','PRODUTOS')

@section('image-top')
{{ asset('images/products.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('product', 'variation', $variation)}}
@endsection

@section('main')
<div class='row'>
    <div class='product-image col-6'>
        @if($product->image)
        <img src='{{asset($product->image->path)}}' width='100%' height='100%'>
        @else
        <img src='{{asset('images/products.png')}}'  width='100%' heigh='100%'>
        @endif
    </div>
    <div class="col-6">
        <label class="labels" for="" >ADICIONAR NOVA IMAGEM:</label>
        <label class="switch">
            <input type="checkbox" id="slider">
            <span class="slider round"></span>
        </label>
        <br>
        <br>
        <div id="new" style="display:none">
            <form action="{{route('image.store')}}" method="post"  enctype='multipart/form-data'>
                @csrf
                <label class="labels" for="" >NOME DA IMAGEM:</label>
                <input type="text" name="name" id="name" size="20"><span class="fields"></span>
                <br>
                <label class="labels" for="" >DESCRIÇÃO DA IMAGEM:</label>
                <textarea id="alt" name="alt" id="alt" rows="3" cols="50">
                </textarea>
                <br>
                <br>
                <div class="p-2 flex-shrink-0 bd-highlight">
                    <input type='file' name='image'>
                    <button id="btn-save" class='circular-button primary' style="padding-top: 3px;padding-left: 2px" type="submit">
                        <i class="fas fa-cloud-upload-alt" aria-hidden='true'></i>
                    </button>
                </div>
                <input type="hidden" name="type" value="produto">
                <input type="hidden" name="status" value="disponível">
            </form>
        </div>
        <form action="{{route('product.update', ['product' => $product->id, 'variation' => $variation])}}" method="post">
            @csrf
            @method('put')
            <div id="change" style="display:inline">
                <label class="labels" for="" >SELECIONAR IMAGEM:</label>
                {{createSelectIdName('image_id', 'select', $images, 'Nenhuma', $product->image)}}
            </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="20" value="{{$product->name}}"><span class="fields"></span>
        <br>
        <label class="labels" for="" >CNAE:</label>
        <input type="text" name="cnae" size="20" value="{{$product->cnae}}"><span class="fields"></span>
        <br>
        @if($product->category == 'produto')
        <label class="labels" for="" >ESTOQUE INICIAL:</label>
        <input type='number' name='initial stock'>
        <br>
        @endif
        <br>
        <label class="labels" for="" >CATEGORIA:</label>
        {{createSimpleSelect('category', 'fields', $categories, $product->category)}}
        <br>
        @if($variation == 'despesa')
        <label class="labels" for="" >GRUPO:</label>
        {{createSimpleSelect('group', 'fields', $groups, $product->group)}}
        <br>
        @endif
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
        @if($product->category == 'serviço')
        <br>
        <label class="labels" for="" >PONTOS FUNCIONAIS:</label>
        <input type="decimal" name="points" size="5" value="{{$product->points}}"><span class="fields"></span>
        @endif
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
</div>
<br>
<br>
<script>
    // exibir form para adicionar nova imagem
    $("#slider").change(function () {
        if (this.checked) {
            $('#change').hide();
            $('#new').show();
        } else {
            $('#change').show();
            $('#new').hide();
        }
    });
    // formatar entrada do dinheiro
        $("[name=price]").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
</script>
@endsection