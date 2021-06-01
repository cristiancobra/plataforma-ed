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
<div class='row'>
    <div class='product-image col-6'>
        @if($product->image_id != null)
        <img src='{{asset($product->image->path)}}' width='100%' height='100%'>
        @else
        <img src='{{asset('imagens/products.png')}}'  width='100%' heigh='100%'>
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
        <div id="change" style="display:inline">
            <label class="labels" for="" >SELECIONAR IMAGEM:</label>
            {{createSelectIdName('image_id', 'select', $images, $product->image_id, 'Nenhuma')}}
        </div>
        <div id="new" style="display:none">
            <label class="labels" for="" >NOME DA IMAGEM:</label>
            <input type="text" name="name" id="name" size="20"><span class="fields"></span>
            <br>
            <label class="labels" for="" >DESCRIÇÃO DA IMAGEM:</label>
            <textarea id="alt" name="alt" id="alt" rows="3" cols="50">
            </textarea>
            <br>
            <br>
            <input type='file' name='image'>
            <div class="p-2 flex-shrink-0 bd-highlight">
                <button class="btn btn-primary" id="btn-save">
                    Add Todo
                </button>
            </div>
            <input type="hidden" name="image_type" value="produto"><span class="fields"></span>
        </div>
    </div>
    <form action="{{route('product.update', ['product' => $product->id, 'variation' => $variation])}}" method="post"  enctype='multipart/form-data'>
        @csrf
        @method('put')
        <div class="row" style="margin-top: 20px">
            <label class="labels" for="" >NOME:</label>
            <input type="text" name="name" size="20" value="{{$product->name}}"><span class="fields"></span>
            <br>
            <label class="labels" for="" >CNAE:</label>
            <input type="text" name="cnae" size="20" value="{{$product->cnae}}"><span class="fields"></span>
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

            // requisicao ajax para salvar dados de nova imagem
            jQuery(document).ready(function ($) {

                //----- Open model CREATE -----//
                jQuery('#btn-add').click(function () {
                    jQuery('#btn-save').val("add");
                    jQuery('#myForm').trigger("reset");
                    jQuery('#formModal').modal('show');
                });
                // CREATE
                $("#btn-save").click(function (e) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    e.preventDefault();
                    var formData = {
                        name: jQuery('#name').val(),
                        alt: jQuery('#alt').val(),
                    };
                    var state = jQuery('#btn-save').val();
                    var type = "POST";
                    var todo_id = jQuery('#todo_id').val();
                    var ajaxurl = '{{route('image.store')}}';
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: formData,
                        dataType: 'json',
                        success: function (data) {
                            var todo = '<tr id="todo' + data.id + '"><td>' + data.id + '</td><td>' + data.title + '</td><td>' + data.description + '</td>';
                            if (state == "add") {
                                jQuery('#todo-list').append(todo);
                            } else {
                                jQuery("#todo" + todo_id).replaceWith(todo);
                            }
                            jQuery('#myForm').trigger("reset");
                            jQuery('#formModal').modal('hide')
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
            });
        </script>
        @endsection