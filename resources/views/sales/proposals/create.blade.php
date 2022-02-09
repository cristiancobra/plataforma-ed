@extends('layouts/master')

@if($type == 'receita')
@section('title','PROPOSTAS')
@else
@section('title','DESPESAS')
@endif

@section('image-top')
{{asset('images/proposal.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('proposal', 'type', $type)}}
@endsection

@section('main')

@if(Session::has('failed'))
<div class='alert alert-danger'>
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div class="container">
    <form action=' {{route('proposal.store')}} ' method='post'>
        @csrf
        <input type='hidden' name='type' value='{{$type}}'>
        @if($type == 'receita')
        <label class='labels' for='' >VENDEDOR: </label>
        @else
        <label class='labels' for='' >REGISTRADO POR: </label>
        @endif
        <select name='user_id'>
            <option  class='fields' value='{{Auth::user()->id}}'>
                Eu
            </option>
            @foreach ($users as $user)
            <option  class='fields' value='{{$user->id}}'>
                {{$user->contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class='labels' for='' >
            NOME:
        </label>
        <input type="text" name='name' value='{{old('name')}}'>
        @if ($errors->has('name'))
        <span class='text-danger'>
            {{$errors->first('name')}}
        </span>
        @endif
        <br>

        <label class='labels' for='' >
            OPORTUNIDADE:
        </label>
        @if($opportunity)
        {{$opportunity->name}}
        <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
        @elseif($type == 'despesa')
        não possui
        @else
        <select name='opportunity_id'>
            <option  class='fields' value=''>
                Não possui
            </option>
            @foreach ($opportunities as $opportunity)
            <option  class='fields' value='{{$opportunity->id}}'>
                {{$opportunity->name}}
            </option>
            @endforeach
        </select>
        {{createButtonAdd('opportunity.create')}}
        @endif
        @if ($errors->has('opportunity_id'))
        <span class='text-danger'>{{$errors->first('opportunity_id')}}</span>
        @endif
        <br>

        @if($type == 'receita')
        <label class='labels' for='' >
            EMPRESA:
        </label>
        @else
        <label class='labels' for='' >
            FORNECEDOR:
        </label>
        @endif


        <select name='company_id'>
            <option  class='fields' value=''>
                Não possui
            </option>
            @foreach ($companies as $company)
            <option  class='fields' value='{{$company->id}}'>
                {{$company->name}}
            </option>
            @endforeach
        </select>

        @if($type == 'despesa')
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        @else        
        {{createButtonAdd('company.create', 'typeCompanies','cliente')}}
        @endif


        <br>

        <label class='labels' for='' >
            CONTATO: 
        </label>
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts, 'Não possui')}}
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}


        <br>
        <br>
        <label class='labels' for='' >
            DATA DE CRIAÇÃO:
        </label>
        <input type='date' name='date_creation' size='20' value='{{old('date_creation') ? old('date_creation') : date('Y-m-d')}}'>
        @if ($errors->has('date_creation'))
        <span class='text-danger'>{{$errors->first('date_creation')}}</span>
        @endif
        <br>
        <label class='labels' for='' >
            VALIDADE DA PROPOSTA:
        </label>
        <input type='number' name='expiration_date' size='3' min='1' max='365' value='30'> dias
        <br>
        <label class='labels' for='' >
            DATA DO PAGAMENTO:
        </label>
        <input type='date' name='pay_day' size='20' value='{{old('pay_day')}}'>
        @if ($errors->has('pay_day'))
        <span class='text-danger'>{{$errors->first('pay_day')}}</span>
        @endif
        <br>
        <br>
        <label class='labels' for='' >
            NÚMERO DE PARCELAS: 
        </label>
        <input type='number'  class='fields' style='text-align: right' name='installment' value='1' max='12'>
        <br>
        <br>
        <label class='labels' for='' >DETALHAMENTO:</label>
        @if(!empty(app('request')->input('opportunityDescription')))
        <span class='fields'>{!!html_entity_decode(app('request')->input('opportunityDescription'))!!}</span>
        @else
        <textarea id='description' name='description' rows='20' cols='90'>
{{old('description')}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
        <script>
CKEDITOR.replace('description');
        </script>
        @endif

        <br>
        <label class='labels' for='' >
            PRODUTOS:
        </label>
        @if($type == 'receita')
        {{createButtonAdd('product.create', 'variation', 'receita')}}
        @else
        {{createButtonAdd('product.create', 'variation', 'despesa')}}
        @endif
        <div class='row mt-3'>
            <div   class='tb-header col-1'>
                FOTO 
            </div>
            <div   class='tb-header-start col-1'>
                QTDE 
            </div>
            <div   class='tb-header col-6'>
                NOME 
            </div>
            <div   class='tb-header col-1'>
                HORAS
            </div>
            <div   class='tb-header col-1'>
                ENTREGA
            </div>
            <div   class='tb-header col-1'>
                IMPOSTO
            </div>
            <div   class='tb-header-end col-1'>
                PREÇO
            </div>
        </div>

        @php
        $counter = 0;
        @endphp
        @foreach ($products as $product)
        <div class='row'>
            <input type='hidden' name='product_id[]' value='{{$product->id}}'>
            <div class='tb col-1'>
                <image src='{{$product->image}}' style='width:50px;height:50px; margin: 5px'>
            </div>
            <div class='tb col-1'>
                <input type='number' name='product_amount[]' size='4' value='{{old('product_amount.'.$counter)}}'>
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
                <input type='hidden' name='product_name[]' size='16' value='{{$product->name}}'>
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
                @if($type == 'receita')
                <input type='decimal' name='product_price[]' size='7' value='{{formatCurrency($product->price)}}' style='text-align: right'>
                @else
                <input type='decimal' name='product_price[]' size='7' value='{{formatCurrency($product->price * -1)}}' style='text-align: right'>
                @endif
            </div>
        </div>
        @php
        $counter++;
        @endphp
        @endforeach

        <div class='row mt-5'>
            <div class='col-2'>
                <label class='labels' for='' >
                    DESCONTO:
                </label>
                <span style='margin-left:20px'>
                    R$
                </span>
            </div>
            <div class='col-2'>
                <input type='text' name='discount' id='discount' step='any' style='text-align: right' size='6'  onkeyup="formatCurrencyReal('discount')">
            </div>
        </div>

        <div class='row mt-4'>
            <div class='col-2'>
                <label class='labels' for=''>
                    SITUAÇÃO:
                </label>
            </div>
            <div class='col-2'>
                @if(!empty(app('request')->input('proposalStatus')))
                <input type='hidden' name='status' value='{{app('request')->input('proposalStatus')}}'>
                {{app('request')->input('proposalStatus')}}
                @else
                {{createSimpleSelect('status', 'fields', $status)}}
                @endif
            </div>
        </div>

        <div class='row mt-5'>
            <div class='col'>
                <button class='btn btn-secondary' type='submit'>
                    CRIAR
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
