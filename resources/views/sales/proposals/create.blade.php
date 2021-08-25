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
{{createButtonBack()}}
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
<div>
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
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class='labels' for='' >NOME:</label>
        <input type="text" name='name'>
        <br>
        <label class='labels' for='' >OPORTUNIDADE:</label>
        @if(!empty(app('request')->input('opportunityName')))
        {{app('request')->input('opportunityName')}}
        <input type='hidden' name='opportunity_id' value='{{app('request')->input('opportunityId')}}'>
        @elseif($type == 'despesa')
        não possui
        @else
        <select name='opportunity_id'>
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
        @if(!empty(app('request')->input('opportunityCompanyName')))
        <label class='labels' for='' >EMPRESA:</label>
        {{app('request')->input('opportunityCompanyName')}}
        <input type='hidden' name='company_id' value='{{app('request')->input('opportunityCompanyId')}}'>
        @elseif($type == 'despesa')
        <label class='labels' for='' >FORNECEDOR:</label>
        <select name='company_id'>
            @foreach ($companies as $company)
            <option  class='fields' value='{{$company->id}}'>
                {{$company->name}}
            </option>
            @endforeach
        </select>
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        @else
        <label class='labels' for='' >EMPRESA:</label>
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
        {{createButtonAdd('company.create', 'typeCompanies','cliente')}}
        @endif
        <br>
        <label class='labels' for='' >CONTATO: </label>
        @if(!empty(app('request')->input('contact_id')))
        <input type='hidden' name='contact_id' value='{{app('request')->input('contact_id')}}'>
        {{app('request')->input('contact_name')}}
        @else
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts, 'Não possui')}}
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        @endif
        <br>
        <br>
        <label class='labels' for='' >DATA DE CRIAÇÃO:</label>
        <input type='date' name='date_creation' size='20' value='{{old('date_creation')}}'>
        @if ($errors->has('date_creation'))
        <span class='text-danger'>{{$errors->first('date_creation')}}</span>
        @endif
        <br>
        <label class='labels' for='' >VALIDADE DA PROPOSTA:</label>
        <input type='number' name='expiration_date' size='3' min='1' max='365' value='30'> dias
        <br>
        <label class='labels' for='' >DATA DO PAGAMENTO:</label>
        <input type='date' name='pay_day' size='20' value='{{old('pay_day')}}'>
        @if ($errors->has('pay_day'))
        <span class='text-danger'>{{$errors->first('pay_day')}}</span>
        @endif
        <br>
        <br>
        <label class='labels' for='' >NÚMERO DE PARCELAS: </label>
        <input type='number'  class='fields' style='text-align: right' name='installment' value='1' max='12'>
        <br>
        <br>
        @if(isset($proposal->opportunity_id))
        <label class='labels' for=''>DESCRIÇÃO DA OPORTUNIDADE:</label>
        @if(!empty(app('request')->input('opportunityDescription')))
        <span class='fields'>{!!html_entity_decode(app('request')->input('opportunityDescription'))!!}</span>
        @else
        <label class='labels' for='' >OBSERVAÇÕES:</label>
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
        <br>
        @endif
        <label class='labels' for='' >OBSERVAÇÕES:</label>
        <textarea id='description' name='description' rows='20' cols='90'>
		{{old('description')}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <label class='labels' for='' >PRODUTOS: </label>
        @if($type == 'receita')
        {{createButtonAdd('product.create', 'variation', 'receita')}}
        @else
        {{createButtonAdd('product.create', 'variation', 'despesa')}}
        @endif
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
            <input type='hidden' name='product_id[]' value='{{$product->id}}'>
            <div class='tb col-1'>
                <input type='number' name='product_amount[]' size='4' value='{{old('product_amount.'.$counter)}}'>
            </div>

            <div class='tb col-1'>
                <image src='{{$product->image}}' style='width:50px;height:50px; margin: 5px'>
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
                <input type='decimal' name='product_price[]' size='7' value='{{formatCurrency($product->price)}}' style='text-align: right'>
            </div>
        </div>
        @php
        $counter++;
        @endphp
        @endforeach


        <br>
        <br>
        <label class='labels' for='' >DESCONTO:</label><span style='margin-left:20px'>R$</span>
        <input type='number' name='discount'  step='any' style='text-align: right' size='6' value='{{formatCurrency(0)}}'>
        <br>
        <br>
        <label class='labels' for=''>SITUAÇÃO:</label>
        @if(!empty(app('request')->input('proposalStatus')))
        <input type='hidden' name='status' value='{{app('request')->input('proposalStatus')}}'>
        {{app('request')->input('proposalStatus')}}
        @else
        {{createSimpleSelect('status', 'fields', returnInvoiceStatus())}}
        @endif
        <br>
        <br>
        <input class='btn btn-secondary' type='submit' value='CRIAR'>
    </form>
</div>
<br>
<br>
@endsection