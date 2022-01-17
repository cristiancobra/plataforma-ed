@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{asset('images/planning.png')}} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('planning.index')}}">VER PLANEJAMENTOS</a>
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action=" {{route('planning.store')}} " method="post">
        @csrf
        <label class="labels" for="" >
            NOME:
        </label>
        <input type="text" name="name" size="70" value='{{old('name')}}'>
        <br>
        <label class='labels' for='' >
            DATA DE CRIAÇÃO:
        </label>
        <input type='date' name='date_creation' size='20' value='{{old('date_creation')}}'>
        @if ($errors->has('date_creation'))
        <span class="text-danger">{{ $errors->first('date_creation') }}</span>
        @endif
        <br>
        <br>
        <label class="labels" for="" >
            PREVISÃO EM MESES:
        </label>
        <input type="integer" name="months" size="15" min="1" max="24" value='12' style="text-align: right">

        <div class='row mt-5'>
            <div class="cel col justify-content-start"  style='
                 color:white;
                 background-color: darkred;
                 font-weight: 600;
                 border-radius: 8px;
                 '>
                <label class="labels" for="" style='
                       color:white;
                       '>                    
                    DESPESAS MENSAIS: R$
                </label>
            </div>
            <div class='row mt-2'>
                <div class='col'>
                    <p class="fields" for="" >Previsao de todas as despesas fixas e variáveis (não incluir custos fixos de produtos)</p>
                </div>
            </div>
            <div class='row mt-4'>
                <div class='col-2 labels'>
                    PROLABORE
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_prolabore" id="expenses_prolabore" onkeyup="formatCurrencyReal('expenses_prolabore')" size="15" value='0' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    SALÁRIO
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_salary" id="expenses_salary" onkeyup="formatCurrencyReal('expenses_salary')" size="15" value='0' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    MARKETING
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_marketing"  id="expenses_marketing" onkeyup="formatCurrencyReal('expenses_marketing')"size="15" value='0' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    PRODUÇÃO
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_production" id="expenses_production" onkeyup="formatCurrencyReal('expenses_production')" size="15" value='0' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    CONTABILIDADE
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_accounting" id="expenses_accounting" onkeyup="formatCurrencyReal('expenses_accounting')" size="15" value='0' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    JURÍDICO
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_legal" id="expenses_legal" onkeyup="formatCurrencyReal('expenses_legal')" size="15" value='0' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    INFRAESTRUTURA
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_infrastructure" id="expenses_infrastructure" onkeyup="formatCurrencyReal('expenses_infrastructure')" size="15" value='0' style="text-align: right">
                </div>
            </div>           


            <div class='container mt-5'  style='
                 border-style: solid;
                 border-width: 1px;
                 border-color: darkred;
                 border-radius: 8px;
                 '>
                <div class='row mt-0 pt-3 pb-3'>
                    <div class="col-3 justify-content-start"  style='
                         font-weight: 600;
                         border-radius: 8px;
                         '>
                        <label class="labels" for="" style='
                               color:darkred;
                               '>      
                            CRESCIMENTO DA DESPESA:
                        </label>
                    </div>
                    <div class='col-1 justify-content-start'>
                        <input type="number" name="increased_expenses" size="3" max="24" value='1' style="text-align: right">
                    </div>
                </div>
                <div class='row mt-0'>
                    <div class='col'>
                        <p class="fields" for="" style='
                           color:darkred;
                           '>
                            Previsao do aumento mensal das depesas em percentual
                        </p>
                    </div>
                </div>
            </div>


            <div class='container mt-5 mb-5'  style='
                 border-style: solid;
                 border-width: 1px;
                 border-color: #4863A0;
                 border-radius: 8px;
                 '>
                <div class='row mt-0 pt-3 pb-3'>
                    <div class="col-3 justify-content-start"  style='
                         font-weight: 600;
                         border-radius: 8px;
                         '>
                        <label class="labels" for="" style='
                               color:#4863A0;
                               '>      
                            CRESCIMENTO DAS VENDAS %:
                        </label>
                    </div>
                    <div class='col-1 justify-content-start'>
                        <input type="number" name="growth_rate" size="3" max="24" value='1' style="text-align: right">
                    </div>
                </div>
                <div class='row mt-0'>
                    <div class='col'>
                        <p class="fields" for="" style='
                           color:#4863A0;
                           '>
                            Previsão de crescimento das vendas em percentual
                        </p>
                    </div>
                </div>
            </div>


            <label class="labels" for="" >
                PREVISÃO DE VENDAS MENSAL:
            </label>
            <p class="labels" style="text-align: left;padding-right: 6%">
                Indique sua previsão de venda de cada produto para descobrir seu  balanço mensal
            </p>
            <br>
            <div class='row mt-3'>
                <div   class='tb-header-start col-1'>
                    QTDE 
                </div>
                <div   class='tb-header col-1'>
                    FOTO 
                </div>
                <div   class='tb-header col-4'>
                    NOME 
                </div>
                <div   class='tb-header col-1'>
                    HORAS
                </div>
                <div   class='tb-header col-1'>
                    ENTREGA
                </div>
                <div   class='tb-header col-2'>
                    IMPOSTO
                </div>
                <div   class='tb-header-end col-2'>
                    PREÇO
                </div>
            </div>

            @php
            $counter = 0;
            @endphp
            @foreach ($products as $product)
            <div class='row'>
                <input type='hidden' name='product_id[]' value='{{$product->id}}'><span class='fields'></span>
                <div class='tb col-1'>
                    <input type='number' name='product_amount[]' size='4' value='{{old('product_amount.'.$counter)}}'>
                </div>

                <div class='tb col-1'>
                    <image src='{{$product->image}}' style='width:50px;height:50px; margin: 5px'></a>
                </div>

                <div class='tb col-6 justify-content-start'>
                    <button class='button-round'>
                        <a href=' {{route('product.show', ['product' => $product->id])}}'>
                            <i class='fa fa-eye' style='color:white'></i>
                        </a>
                    </button>
                    <button class='button-round'>
                        <a href=' {{route('product.edit', ['product' => $product->id])}}'>
                            <i class='fa fa-edit' style='color:white'></i>
                        </a>
                    </button>
                    <input type='hidden' name='product_name[]' size='16' value='{{$product->name}}'><span class='fields'></span>
                    {{$product->name}}
                </div>

                <div class='tb col-1'>
                    <input type='hidden' name='product_due_date[]' size='4' value='{{$product->due_date}}'>
                    {{number_format($product->due_date)}}
                </div>
                <div class='tb col-1'>
                    <input type='hidden' name='product_work_hours[]' size='4' value='{{$product->work_hours}}'>
                    {{number_format($product->work_hours)}} dia(s)
                </div>

                <input type='hidden' name='product_cost[]' size='7' value='{{$product->cost1 + $product->cost2 + $product->cost3}}' >

                <div class='tb col-1 justify-content-end'>
                    <input type='hidden' name='product_tax_rate[]' size='7' value='{{$product->price * $product->tax_rate / 100}}' >
                    {{formatCurrencyReal($product->price * $product->tax_rate / 100)}}
                </div>

                <input type='hidden' name='product_margin[]' size='7' value='{{-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price}}' >

                <div class='tb col-1 justify-content-end' style='color:white;background-color: #c28dbf;text-align: right'>
                    <input type='decimal' name='product_price[]' size='7' value='{{formatCurrency($product->price)}}' style='text-align: right'>
                </div>
            </div>
            @php
            $counter++;
            @endphp
            @endforeach
            <br>
            <br>
            <input class="btn btn-secondary" type="submit" value="CRIAR">
            </form>
        </div>     
        @endsection