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
Total: <span class="labels">{{$totalProducts}} </span>
@endsection

@section('buttons')
<button id='filter_button' class='button-secondary'>
<i class="fa fa-filter" aria-hidden="true"></i>
</button>
<a class="button-primary"  href="{{route('product.create', ['variation' => $variation])}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<form id="filter" action="{{route('product.filter', ['variation' => $variation])}}" method="post" style="text-align: right;display:none">
    @csrf
    <input type="text" name="name" placeholder="nome do produto" value="">
    {{createFilterSelectModels('account_id', 'select', $accounts, 'Minhas empresas')}}
    {{createFilterSelect('category', 'select', returnProductCategory())}}
    {{createFilterSelect('status', 'select', returnProductStatus())}}
    <a class="button-secondary" href='{{route('product.index', ['variation' => $variation])}}'>
        LIMPAR
    </a>
    <input class="button-secondary" type="submit" value="FILTRAR">
</form>
<br>
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 10%">
                FOTO
            </td>
            <td   class="table-list-header" style="width: 25%">
                NOIME
            </td>
            <td   class="table-list-header" style="width: 10%">
                CATEGORIA
            </td>
            <td   class="table-list-header" style="width: 5%">
                ENTREGA
            </td>
            <td   class="table-list-header" style="width: 10%">
                HORAS
            </td>
            <td   class="table-list-header" style="width: 5%">
                CUSTOS
            </td>
            <td   class="table-list-header" style="width: 10%">
                IMPOSTO
            </td>
            <td   class="table-list-header" style="width: 10%">
                MARGEM
            </td>
            <td   class="table-list-header" style="width: 10%">
                PREÇO
            </td>
            <td   class="table-list-header" style="width: 5%">
                SITUAÇÃO
            </td>
        </tr>

        @foreach ($products as $product)
        <tr style="font-size: 14px">
            <td class="table-list-right">
                <button class="button-round">
                    <a href=" {{route('product.show', ['product' => $product->id, 'variation' => $variation])}}">
                        <i class='fa fa-eye' style="color:white"></i></a>
                </button>
                <image src="{{$product->image}}" style="width:50px;height:50px; margin: 5px"></a>
            </td>

            <td class="table-list-left">
                {{$product->name}}
            </td>

            <td class="table-list-center">
                {{$product->category}}
            </td>

            @if ($product->due_date == 0)
            <td class="table-list-right">
                imediata
            </td>
            @else
            <td class="table-list-center">
                {{$product->due_date}} dias
            </td>
            @endif

            <td class="table-list-center">
                {{number_format($product->work_hours)}}
            </td>

            <td class="table-list-right">
                R$ {{number_format($product->cost1 + $product->cost2 + $product->cost3, 2,",",".")}}
            </td>

            <td class="table-list-right">
                R$ {{number_format($product->price * $product->tax_rate / 100, 2,",",".")}}
            </td>

            <td class="table-list-right">
                R$ {{number_format(-$product->price * $product->tax_rate /100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,",",".")}}
            </td>

            <td class="table-list-right">
                R$ {{number_format($product->price,2,",",".")}}

                {{formatProductStatus($product)}}

        </tr>
        @endforeach
    </table>
    <p style="text-align: right">
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
    $("#filter_button").click(function () {
        $("#filter").slideToggle(600);
    });

});
</script>
@endsection