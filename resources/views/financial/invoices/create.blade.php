@extends('layouts/master')

@if($typeInvoices == 'receita')
@section('title','RECEITA')
@else
@section('title','DESPESA')
@endif

@section('image-top')
{{asset('images/invoice.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('invoice', 'typeInvoices', $typeInvoices)}}
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
    <form action=" {{route('invoice.store')}} " method="post">
        @csrf
        <input type="hidden" name="type" value="{{$typeInvoices}}">
        @if($typeInvoices == 'receita')
        <label class="labels" for="" >VENDEDOR: </label>
        @else
        <label class="labels" for="" >REGISTRADO POR: </label>
        @endif
        <select name="user_id">
            <option  class="fields" value="{{Auth::user()->id}}">
                Eu
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >PROPOSTA:</label>
        <select name="proposal_id">
            @foreach ($proposals as $proposal)
            <option  class="fields" value="{{$proposal->id}}">
                {{$proposal->name}}
            </option>
            @endforeach
        </select>
        {{createButtonAdd('proposal.create')}}
        <br>
        <label class="labels" for="" >OPORTUNIDADE:</label>
        @if(!empty(app('request')->input('opportunityName')))
        {{app('request')->input('opportunityName')}}
        <input type="hidden" name="opportunity_id" value="{{app('request')->input('opportunityId')}}">
        @elseif($typeInvoices == 'despesa')
        não possui
        @else
        <select name="opportunity_id">
            @foreach ($opportunities as $opportunity)
            <option  class="fields" value="{{$opportunity->id}}">
                {{$opportunity->name}}
            </option>
            @endforeach
        </select>
        {{createButtonAdd('opportunity.create')}}
        @endif
        @if ($errors->has('opportunity_id'))
        <span class="text-danger">{{$errors->first('opportunity_id')}}</span>
        @endif
        <br>
        @if(!empty(app('request')->input('opportunityCompanyName')))
        <label class="labels" for="" >EMPRESA:</label>
        {{app('request')->input('opportunityCompanyName')}}
        <input type="hidden" name="company_id" value="{{app('request')->input('opportunityCompanyId')}}">
        @elseif($typeInvoices == 'despesa')
        <label class="labels" for="" >FORNECEDOR:</label>
        <select name="company_id">
            @foreach ($companies as $company)
            <option  class="fields" value="{{$company->id}}">
                {{$company->name}}
            </option>
            @endforeach
        </select>
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        @else
        <label class="labels" for="" >EMPRESA:</label>
        <select name="company_id">
            <option  class="fields" value="">
                Não possui
            </option>
            @foreach ($companies as $company)
            <option  class="fields" value="{{$company->id}}">
                {{$company->name}}
            </option>
            @endforeach
        </select>
        {{createButtonAdd('company.create', 'typeCompanies','cliente')}}
        @endif
        <br>
         <label class="labels" for="" >CONTATO: </label>
        @if(!empty(app('request')->input('contact_id')))
        <input type="hidden" name="contact_id" value="{{app('request')->input('contact_id')}}">
                {{app('request')->input('contact_name')}}
        @else
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts)}}
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        @endif
        <br>
        <br>
        <label class="labels" for="" >DATA DE CRIAÇÃO:</label>
        <input type="date" name="date_creation" size="20" value="{{old('date_creation')}}"><span class="fields"></span>
        @if ($errors->has('date_creation'))
        <span class="text-danger">{{$errors->first('date_creation')}}</span>
        @endif
        <br>
        <label class="labels" for="" >VALIDADE DA PROPOSTA:</label>
             <input type="number" name="expiration_date" size="3" min='1' max='365' value="30"> dias
        <br>
        <label class="labels" for="" >DATA DO PAGAMENTO:</label>
        <input type="date" name="pay_day" size="20" value="{{old('pay_day')}}"><span class="fields"></span>
        @if ($errors->has('pay_day'))
        <span class="text-danger">{{$errors->first('pay_day')}}</span>
        @endif
        <br>
        <br>
        @if(isset($invoice->opportunity_id))
        <label class="labels" for="">DESCRIÇÃO DA OPORTUNIDADE:</label>
        @if(!empty(app('request')->input('opportunityDescription')))
        <span class="fields">{!!html_entity_decode(app('request')->input('opportunityDescription'))!!}</span>
        @else
        <label class="labels" for="" >OBSERVAÇÕES:</label>
        <textarea id="description" name="description" rows="20" cols="90">
{{old('description')}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        @endif
        <br>
        <br>
        @endif
        <label class="labels" for="" >OBSERVAÇÕES:</label>
        <textarea id="description" name="description" rows="20" cols="90">
		{{old('description')}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <label class="labels" for="" >PRODUTOS: </label>
        @if($typeInvoices == 'receita')
        {{createButtonAdd('product.create', 'variation', 'receita')}}
        @else
        {{createButtonAdd('product.create', 'variation', 'despesa')}}
        @endif
        <table class="table-list">
            <tr>
                <td   class="table-list-header" style="width: 5%">
                    QTDE 
                </td>
                <td   class="table-list-header" style="width: 5%">
                    FOTO 
                </td>
                <td   class="table-list-header" style="width: 50%">
                    NOME 
                </td>
                <td   class="table-list-header" style="width: 10%">
                    HORAS
                </td>
                <td   class="table-list-header" style="width: 10%">
                    ENTREGA
                </td>
                <td   class="table-list-header" style="width: 10%">
                    IMPOSTO
                </td>
                <td   class="table-list-header" style="width: 10%">
                    PREÇO
                </td>
            </tr>

            @php
            $counter = 0;
            @endphp
            @foreach ($products as $product)
            <tr>
            <input type="hidden" name="product_id[]" value="{{$product->id}}"><span class="fields"></span>
            <td class="table-list-center">
                <input type="number" name="product_amount[]" size="4" value="{{old('product_amount.'.$counter)}}">
            </td>

            <td class="table-list-right">
                <image src="{{$product->image}}" style="width:50px;height:50px; margin: 5px"></a>
            </td>

            <td class="table-list-left">
                <button class="button-round">
                    <a href=" {{route('product.show', ['product' => $product->id])}}">
                        <i class='fa fa-eye' style="color:white"></i>
                    </a>
                </button>
                <button class="button-round">
                    <a href=" {{route('product.edit', ['product' => $product->id])}}">
                        <i class='fa fa-edit' style="color:white"></i>
                    </a>
                </button>
                <input type="hidden" name="product_name[]" size="16" value="{{$product->name}}"><span class="fields"></span>
                {{$product->name}}
            </td>

            <td class="table-list-center">
                <input type="hidden" name="product_due_date[]" size="4" value="{{$product->due_date}}">
                {{number_format($product->due_date)}}
            </td>
            <td class="table-list-center">
                <input type="hidden" name="product_work_hours[]" size="4" value="{{$product->work_hours}}">
                {{number_format($product->work_hours)}} dia(s)
            </td>

            <input type="hidden" name="product_cost[]" size="7" value="{{$product->cost1 + $product->cost2 + $product->cost3}}" >

            <td class="table-list-right">
                <input type="hidden" name="product_tax_rate[]" size="7" value="{{$product->price * $product->tax_rate / 100}}" >
                {{formatCurrencyReal($product->price * $product->tax_rate / 100)}}
            </td>

            <input type="hidden" name="product_margin[]" size="7" value="{{-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price}}" >

            <td class="table-list-right" style='color:white;background-color: #c28dbf'>
                <input type="decimal" name="product_price[]" size="7" value="{{formatCurrency($product->price)}}" >
            </td>
            </tr>
            @php
            $counter++;
            @endphp
            @endforeach
        </table>
        <br>
        <br>
        <label class="labels" for="" >DESCONTO:</label><span style='margin-left:20px'>R$</span>
        <input type="number" name="discount"  step='any' style="text-align: right" size='6' value="{{formatCurrency(0)}}"><span class="fields"></span>
        <br>
        <br>
        <label class="labels" for="" >NÚMERO DE PARCELAS: </label>
        <input type="number"  class="fields" style="text-align: right" name="number_installment_total" value="1" max="12">
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        @if(!empty(app('request')->input('invoiceStatus')))
        <input type="hidden" name="status" value="{{app('request')->input('invoiceStatus')}}">
        {{app('request')->input('invoiceStatus')}}
        @else
        {{createSimpleSelect('status', 'fields', returnInvoiceStatus())}}
        @endif
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR FATURA">
    </form>
</div>
<br>
<br>
@endsection