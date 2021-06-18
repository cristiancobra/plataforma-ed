@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{asset('imagens/planning.png')}} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('planning.index')}}">VER PLANEJAMENTOS</a>
@endsection

@section('main')
<div>
    <form action=" {{route('planning.store')}} " method="post" style="padding: 40px;color: #874983">
        @csrf
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="20"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="" >PREVISÃO EM MESES:</label>
        <input type="integer" name="months" size="5""><span class="fields"></span>
        <br>
        <p class="fields" for="" >Escolha a extensão do seu planejamento pela quantidade de meses (1 ano = 12, trimestre = 3, etc))</p>
        <br>
        <label class="labels" for="" >DESPESAS MENSAIS: R$</label>
        <input type="integer" name="expenses" size="5"><span class="fields"></span>
        <br>
        <p class="fields" for="" >Todas as despesas fixas e variáveis (estimadas) mensais. (não incluir custos fixos de produtos)</p>
        <br>
        <br>
        <div>
            <label class="labels" for="" >PREVISÃO/META DE VENDAS:</label>
            <p class="subtitulo-roxo" style="text-align: left;padding-right: 6%">
                Indique sua previsão de venda de cada produto para descobrir seu  balanço mensal
            </p>
            <br>
            <table class="table-list">
                <tr>
                    <td class="table-list-header">Quantidade</td>
                    <td class="table-list-header">Foto </td>
                    <td class="table-list-header">Nome </td>
                    <td class="table-list-header">Horas previstas</td>
                    <td class="table-list-header">Custos</td>
                    <td class="table-list-header">Imposto</td>
                    <td class="table-list-header">Margem</td>
                    <td class="table-list-header">Preço</td>
                </tr>

                @foreach ($products as $product)
                <tr style="font-size: 14px">
                    <td class="table-list-center">
                        <input type="number" name="{{$amount++}}" size="4"><span class="fields"></span>
                    </td>

                    <td class="table-list-right">
                        <image src="{{$product->image}}" style="width:50px;height:50px; margin: 5px"></a>
                    </td>

                    <td class="table-list-left">
                        <button class="button">
                            <a href=" {{route('product.show', ['product' => $product->id])}}">
                                <i class='fa fa-eye' style="color:white"></i></a>
                        </button>
                        <button class="button">
                            <a href=" {{route('product.edit', ['product' => $product->id])}}">
                                <i class='fa fa-edit' style="color:white"></i></a>
                        </button>
                        <input type="hidden" name="{{$name++}}" size="16" value="{{$product->name}}"><span class="fields"></span>
                        {{$product->name}}
                    </td>

                    <td class="table-list-center">
                        <input type="hidden" name="{{$hours++}}" size="4" value="{{$product->work_hours}}">
                        {{number_format($product->work_hours)}}
                    </td>

                    <td class="table-list-right">
                        <input type="hidden" name="{{$cost++}}" size="7" value="{{$product->cost1 + $product->cost2 + $product->cost3}}" >
                        {{number_format($product->cost1 + $product->cost2 + $product->cost3, 2,",",".")}}
                    </td>

                    <td class="table-list-right">
                        <input type="hidden" name="{{$tax_rate++}}" size="7" value="{{$product->price * $product->tax_rate / 100}}" >
                        {{number_format($product->price * $product->tax_rate / 100, 2,",",".")}}
                    </td>

                    <td class="table-list-right">
                        <input type="hidden" name="{{$margin++}}" size="7" value="{{-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price}}" >
                        {{number_format(-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,",",".")}}
                    </td>

                    <td class="table-list-right">
                        <input type="hidden" name="{{$price++}}" size="8" value="{{$product->price}}" >
                        {{number_format($product->price,2,",",".")}}
                    </td>

                </tr>
                @endforeach
            </table>
            <br>
            <br>
            <label class="labels" for="">SITUAÇÃO:</label>
            <select class="fields" name="status">
                <option value="pendente">pendente</option>
                <option value="fazendo agora">fazendo agora</option>
                <option value="cancelada">cancelada</option>
                <option value="concluida">concluida</option>
            </select>
            <br>
            <br>
            <input class="btn btn-secondary" type="submit" value="CRIAR">
            </form>
        </div>     
        @endsection