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
<div class='alert alert-danger'>
    {{ Session::get('failed') }}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div class='col-6'>
    <label class='labels' for='' >ADICIONAR NOVA IMAGEM:</label>
    <label class='switch'>
        <input type='checkbox' id='slider'>
        <span class='slider round'></span>
    </label>
    <br>
    <br>
    <div id='new' style='display:none'>
        <form action='{{route('image.store')}}' method='post'  enctype='multipart/form-data'>
            @csrf
            <label class='labels' for='' >NOME DA IMAGEM:</label>
            <input type='text' name='name' id='name' size='20'>'
            <br>
            <label class='labels' for='' >DESCRIÇÃO DA IMAGEM:</label>
            <textarea id='alt' name='alt' id='alt' rows='3' cols='50'>
            </textarea>
            <br>
            <br>
            <div class='p-2 flex-shrink-0 bd-highlight'>
                <input type='file' name='image'>
                <button id='btn-save' class='circular-button primary' style='padding-top: 3px;padding-left: 2px' type='submit'>
                    <i class='fas fa-cloud-upload-alt' aria-hidden='true'></i>
                </button>
            </div>
            <input type='hidden' name='type' value='produto'>
            <input type='hidden' name='status' value='disponível'>
        </form>
    </div>
</div>
<div>
    <form action='{{route('product.store')}}' method='post'>
        @csrf
        @if($variation == 'receita')
        <input type='hidden' name='type' value='receita'>
        @else
        <input type='hidden' name='type' value='despesa'>
        @endif
        <div id='change' style='display:inline'>
            <label class='labels' for='' >SELECIONAR IMAGEM:</label>
            {{createSelectIdName('image_id', 'select', $images, 'Nenhuma')}}
        </div>
        <br>
        <br>
        <label class='labels' for='' >NOME:</label>
        <input type='text' name='name' size='20' style='width:90%' value='{{old('name')}}'>'
        @if ($errors->has('name'))
        <span class='text-danger'>{{ $errors->first('name') }}</span>
        @endif
        <br>
        <label class='labels' for='' >CNAE:</label>
        <input type='text' name='cnae' size='20' value='{{old('cnae')}}'>'
        <br>
        <label class='labels' for='' >ESTOQUE INICIAL:</label>
        * Apenas para produtos
        <input type='number' name='initial stock'>
        <br>
        <br>
        <label class='labels' for='' >CATEGORIA:</label>
        {{createSimpleSelect('category', 'fields', $categories)}}
        <br>
        @if($variation == 'despesa')
        <label class='labels' for='' >GRUPO:</label>
        {{createSimpleSelect('group', 'fields', $groups)}}
        <br>
        @endif
        <br>
        <br>
        <label class='labels' for='' >DESCRIÇÃO:</label>
        <textarea id='description' name='description' rows='20' cols='90'>
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        @if($variation == 'receita')
        <label class='labels' for='' >HORAS NECESSÁRIAS:</label>
        <input style="text-align:right" type='number' name='work_hours' size='5' min='0' max='999' step='0.1' value='{{old('work_hours')}}'>
        <br>
        <label class='labels' for='' >PONTOS FUNCIONAIS:</label>
        <input class='text-right' type='decimal' name='points' size='5' value='{{old('points')}}'>
        <br>
        <br>
        <label class='labels' for='' >CUSTO 1:</label>
        <input type='integer' name='cost1' size='5'>'
        <label class='labels' for='' >descrição:</label>
        <input type='decimal' name='cost1_description' size='40'>'
        <br>
        <label class='labels' for='' >CUSTO 2:</label>
        <input type='integer' name='cost2' size='5'>'
        <label class='labels' for='' >descrição:</label>
        <input type='decimal' name='cost2_description' size='40'>'
        <br>
        <label class='labels' for='' >CUSTO 3:</label>
        <input type='integer' name='cost3' size='5''>'
        <label class='labels' for='' >descrição:</label>
        <input type='decimal' name='cost3_description' size='40'>'
        <br>
        <br>
        <label class='labels' for='' >IMPOSTO (%):</label>
        <input class='text-right' type='decimal' name='tax_rate' size='5' value='{{old('tax_rate')}}'>'
        <br>
        <br>
        @endif
        <label class='labels' for='' >PREÇO:</label>
        <input class='text-right' type='decimal' name='price' value='{{old('price')}}' style='text-align: right' size='6'>
        @if ($errors->has('price'))
        <span class='text-danger'>{{ $errors->first('price') }}</span>
        @endif
        <br>
        <br>
        <label class='labels' for='' >PRAZO DE ENTREGA:</label>
        <input class='text-right' type='integer' name='due_date' size='5' value='{{old('due_date')}}'>'
        <br>
        <br>
        <label class='labels' for=''>SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', returnProductStatus())}}
        <br>
        <br>
        <input class='btn btn-secondary' type='submit' value='CRIAR PRODUTO'>
    </form>
</div>
<script>
    // exibir form para adicionar nova imagem
    $('#slider').change(function () {
        if (this.checked) {
            $('#change').hide();
            $('#new').show();
        } else {
            $('#change').show();
            $('#new').hide();
        }
    });
        // formatar entrada do dinheiro
//        $('[name=price]').maskMoney({
//            prefix:'R$ ',
//            allowNegative: true,
//            thousands:'.',
//            decimal:',',
//            affixesStay: false
//        });
//        $('[name=work_hours]').on("input", ".decimal-number", function (e) {
//    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
//});

        // formatar entrada para decimal
//        $('[name=work_hours]').inputmask({
//  alias: 'numeric', 
//  allowMinus: false,  
//  digits: 2, 
//  max: 999.99
//});

</script>
@endsection