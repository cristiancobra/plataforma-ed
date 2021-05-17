@extends('layouts/master')

@if($variation == 'receita')
@section('title','PRODUTOS')
@else
@section('title','ITENS DE DESPESA')
@endif

@section('image-top')
{{asset('imagens/products.png')}} 
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class='fa fa-filter' aria-hidden='true'></i>
</a>
<a class='circular-button primary'  href='{{route('product.create', ['variation' => $variation])}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endsection

@section('main')
<form id='filter' action='{{route('product.filter', ['variation' => $variation])}}' method='post' style='text-align: right;display:none'>
    @csrf
    <input type='text' name='name' placeholder='nome do produto' value=''>
    {{createFilterSelectModels('account_id', 'select', $accounts, 'Minhas empresas')}}
    {{createFilterSelect('category', 'select', returnProductCategory())}}
    {{createFilterSelect('status', 'select', returnProductStatus(), 'Todas as situações')}}
    <a class='button-secondary' href='{{route('product.index', ['variation' => $variation])}}'>
        LIMPAR
    </a>
    <input class='button-secondary' type='submit' value='FILTRAR'>
</form>
<br>
<div>
    <div class='row'>
        <div class='tb tb-header-start col-2'>
            FOTO
        </div>
        <div class='tb tb-header col-2'>
            NOME
        </div>
        <div class='tb tb-header col-1'>
            CATEGORIA
        </div>
        <div class='tb tb-header col-1'>
            ENTREGA
        </div>
        <div class='tb tb-header col-1'>
            HORAS
        </div>
        <div class='tb tb-header col-1'>
            CUSTOS
        </div>
        <div class='tb tb-header col-1'>
            IMPOSTO
        </div>
        <div class='tb tb-header col-1'>
            MARGEM
        </div>
        <div class='tb tb-header col-1'>
            PREÇO
        </div>
        <div class='tb tb-header-end col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($products as $product)
    <div class='row'>
        <div class='tb col-2'>
            <div class='product-image-small'>
                <a href=' {{route('product.show', ['product' => $product->id, 'variation' => $variation])}}'>
                       @if($product->image)
                    <image src='{{$product->image}}' width='100%' heigh='100%'>
                    @else
                    <image src='{{asset('imagens/products.png')}}'>
                    @endif
                </a>
            </div>
        </div>
        <div class='tb col-2'>
            {{$product->name}}
        </div>
        <div class='tb col-1'>
            {{$product->category}}
        </div>
        @if ($product->due_date == 0)
        <div class='tb col-1'>
            imediata
        </div>
        @else
        <div class='tb col-1'>
            {{$product->due_date}} dias
        </div>
        @endif
        <div class='tb col-1'>
            {{number_format($product->work_hours)}}
        </div>
        <div class='tb col-1'>
            R$ {{number_format($product->cost1 + $product->cost2 + $product->cost3, 2,',','.')}}
        </div>
        <div class='tb col-1'>
            R$ {{number_format($product->price * $product->tax_rate / 100, 2,',','.')}}
        </div>
        <div class='tb col-1'>
            R$ {{number_format(-$product->price * $product->tax_rate /100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,',','.')}}
        </div>
        <div class='tb col-1'>
            R$ {{number_format($product->price,2,',','.')}}
        </div>
        {{formatTableStatus($product)}}
    </div>
    @endforeach
    <div class='row'>
        <div class='tb-footer'></div>
    </div>
</div>
<br>
<br>
<br>
<table class='table-list'>
    <tr>
        <td   class='table-list-header' style='width: 15%'>
            FOTO
        </td>
        <td   class='table-list-header' style='width: 25%'>
            NOIME
        </td>
        <td   class='table-list-header' style='width: 10%'>
            CATEGORIA
        </td>
        <td   class='table-list-header' style='width: 5%'>
            ENTREGA
        </td>
        <td   class='table-list-header' style='width: 5%'>
            HORAS
        </td>
        <td   class='table-list-header' style='width: 5%'>
            CUSTOS
        </td>
        <td   class='table-list-header' style='width: 10%'>
            IMPOSTO
        </td>
        <td   class='table-list-header' style='width: 10%'>
            MARGEM
        </td>
        <td   class='table-list-header' style='width: 10%'>
            PREÇO
        </td>
        <td   class='table-list-header' style='width: 5%'>
            SITUAÇÃO
        </td>
    </tr>

    @foreach ($products as $product)
    <tr style='font-size: 14px'>
        <td class='table-list-center'>
            <div class='profile-picture-small'>
                <a href=' {{route('product.show', ['product' => $product->id, 'variation' => $variation])}}'>
                    <image src='{{$product->image}}'>
                </a>
            </div>
        </td>

        <td class='table-list-left'>
            {{$product->name}}
        </td>

        <td class='table-list-center'>
            {{$product->category}}
        </td>

        @if ($product->due_date == 0)
        <td class='table-list-right'>
            imediata
        </td>
        @else
        <td class='table-list-center'>
            {{$product->due_date}} dias
        </td>
        @endif

        <td class='table-list-center'>
            {{number_format($product->work_hours)}}
        </td>

        <td class='table-list-right'>
            R$ {{number_format($product->cost1 + $product->cost2 + $product->cost3, 2,',','.')}}
        </td>

        <td class='table-list-right'>
            R$ {{number_format($product->price * $product->tax_rate / 100, 2,',','.')}}
        </td>

        <td class='table-list-right'>
            R$ {{number_format(-$product->price * $product->tax_rate /100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,',','.')}}
        </td>

        <td class='table-list-right'>
            R$ {{number_format($product->price,2,',','.')}}

            {{formatProductStatus($product)}}

    </tr>
    @endforeach
</table>
<p style='text-align: right'>
    <br>
    {{$products->links()}}
</p>
</div>
<br>
@endsection

@section('js-scripts')
<script>
    $(document).ready(function () {
        //botao de exibir filtro
        $('#filter_button').click(function () {
            $('#filter').slideToggle(600);
        });

    });
</script>
@endsection