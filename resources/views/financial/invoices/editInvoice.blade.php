@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('images/invoice.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='circular-button primary'  href='{{route('invoice.index')}}'>
    <i class='fas fa-arrow-left'></i>
</a>
@endsection

@section('main')
<div>
    <form action=' {{route('invoice.update', ['invoice' => $invoice])}} ' method='post'>
        @csrf
        @method('put')
        <label class='labels' for='' >IDENTIFICADOR:</label>
        <input type='number' span class='fields' style='width: 80px;text-align: right' value='{{$invoice->identifier}}'>
        <br>
        <label class='labels' for='' >VENDEDOR: </label>
        <select name='user_id'>
            <option  class='fields' value='{{$invoice->user->id}}'>
                {{$invoice->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class='fields' value='{{$user->id}}'>
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        @if(isset($invoice->opportunity_id))
        <label class='labels' for='' >OPORTUNIDADE: </label>
        <input type='hidden' name='opportunity_id' value='{{$invoice->opportunity_id}}'>
        <span class='fields'>{{$invoice->opportunity->name}}</span>
        <br>
        @endif
        
        @if(isset($invoice->company))
        <label class='labels' for=''>EMPRESA:</label>
        {{createDoubleSelectIdName('company_id', 'fields', $companies,'Não possui', $invoice->company)}}
        <button class='button-round'>
            <a href='{{route('company.show', ['company' => $invoice->company_id])}}'>
                <i class='fa fa-eye' style='color:white'></i>
            </a>
        </button>
        <br>
        @endif
        
        <label class='labels' for='' >CONTATO: </label>
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts,'Não possui', $invoice->contact, )}}
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        <br>
        @if(isset($invoice->opportunity_id))
        <label class='labels' for='' >CONTRATO: </label>
        <select name='contract_id'>
            <option  class='fields' value='{{$invoice->contract_id}}'>
                {{$invoice->contract_id}}
            </option>
            @foreach ($contracts as $contract)
            <option  class='fields' value='{{$contract->id}}'>
                {{$contract->id}} - {{$contract->name}}
            </option>
            @endforeach
        </select>
        @endif
        <br>
        <br>
        <label class='labels' for='' >DATA DE CRIAÇÃO:</label>
        <input type='date' name='date_creation' size='20' value='{{$invoice->date_creation}}'><span class='fields'></span>
        <br>
        <label class="labels" for="" >VALIDADE DA PROPOSTA:</label>
        <input type="number" name="expiration_date" size="3" min='1' max='365' value="{{$invoice->expiration_date}}"> dias
        <br>
        <label class='labels' for='' >DATA DO PAGAMENTO:</label>
        <input type='date' name='pay_day' size='20' value='{{$invoice->pay_day}}'><span class='fields'></span>
        <br>
        <br>
        <label class='labels' for='' >PRODUTOS ATUAIS:</label>
        <table class='table-list'>
            <tr>
                <td   class='table-list-header'>
                    QTDE
                </td>
                <td   class='table-list-header'>
                    FOTO
                </td>
                <td   class='table-list-header'>
                    NOME
                </td>
                <td   class='table-list-header'>
                    HORAS
                </td>
                <td   class='table-list-header'>
                    PONTOS
                </td>
                <td   class='table-list-header'>
                    PRAZO
                </td>
                <td   class='table-list-header'>
                    CUSTOS
                </td>
                <td   class='table-list-header'>
                    IMPOSTO
                </td>
                <td   class='table-list-header'>
                    MARGEM
                </td>
                <td   class='table-list-header'>
                    PREÇO
                </td>
            </tr>

            @foreach ($invoiceLines as $invoiceLine)
            <tr style='font-size: 14px'>
                <td class='table-list-center'>
                    <input type='hidden' name='invoiceLine_id[]' size='16' value='{{$invoiceLine->id}}'>
                    <input type='hidden' name='product_id[]' size='16' value='{{$invoiceLine->product->id}}'>
                    
                    <input type='number' name='product_amount[]' size='4' value='{{$invoiceLine->amount}}'>
                    <span class='fields'></span>

                </td>
                <td class='table-list-right'>
                    <image src='{{$invoiceLine->product->image}}' style='width:50px;height:50px; margin: 5px'></a>
                </td>
                <td class='table-list-left'>
                    <button class='button'>
                        <a href=' {{route('product.show', ['product' => $invoiceLine->product->id])}}'>
                            <i class='fa fa-eye' style='color:white'></i></a>
                    </button>
                    <button class='button'>
                        <a href=' {{route('product.edit', ['product' => $invoiceLine->product->id])}}'>
                            <i class='fa fa-edit' style='color:white'></i></a>
                    </button>
                    <span class='fields'>{{$invoiceLine->product->name}}</span>
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='product_due_date[]' size='4' value='{{$invoiceLine->product->due_date}}'>
                    {{number_format($invoiceLine->product->due_date)}}
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='product_work_hours[]' size='4' value='{{$invoiceLine->product->work_hours}}'>
                    {{number_format($invoiceLine->product->work_hours)}}
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='product_points[]' size='4' value='{{$invoiceLine->product->points}}'>
                    {{number_format($invoiceLine->product->points)}}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='product_cost[]' size='7' value='{{ $invoiceLine->product->cost1 + $invoiceLine->product->cost2 + $invoiceLine->product->cost3}}' >
                    {{number_format($invoiceLine->product->cost1 + $invoiceLine->product->cost2 + $invoiceLine->product->cost3, 2,',','.') }}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='product_tax_rate[]' size='7' value='{{$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100}}' >
                    {{number_format($invoiceLine->product->price * $invoiceLine->product->tax_rate / 100, 2,',','.') }}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='product_margin[]' size='7' value='{{-$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100 - $invoiceLine->product->cost1 - $invoiceLine->product->cost2 - $invoiceLine->product->cost3 + $invoiceLine->product->price}}'>
                    {{number_format(-$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100 - $invoiceLine->product->cost1 - $invoiceLine->product->cost2 - $invoiceLine->product->cost3 + $invoiceLine->product->price, 2,',','.')}}
                </td>
                <td class='table-list-right'>
                    <input type='decimal' name='product_price[]' size='7' value='{{formatCurrency($invoiceLine->subtotalPrice / $invoiceLine->amount)}}'>
                </td>
            </tr>
            @endforeach
            <tr>
                <td   class='table-list-header-right' colspan='8'>
                    desconto: 
                </td>
                <td   class='table-list-header-right' colspan='3'>
                    - {{formatCurrencyReal($invoice->discount)}}
                </td>
            </tr>
            <tr>
                <td   class='table-list-header-right' colspan='8'>
                    TOTAL: 
                </td>
                <td   class='table-list-header-right' colspan='3'>
                    {{formatCurrencyReal($invoice->totalPrice)}}
                </td>
            </tr>
            <tr>
                <td   class='table-list-header-right' colspan='8'>
                    PARCELAMENTO: 
                </td>

                <td   class='table-list-header-right' colspan='3'>
                    @if($invoice->number_installment_total == 1)
                    À vista
                    @else
                    {{$invoice->number_installment_total}} x {{formatCurrencyReal($invoice->installment_value)}}
                    @endif
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <label class='labels' for='' >ADICIONAR PRODUTOS:</label>
        <table class='table-list'>
            <tr>
                <td   class='table-list-header'>
                    QTDE
                </td>
                <td   class='table-list-header'>
                    FOTO
                </td>
                <td   class='table-list-header'>
                    NOME
                </td>
                <td   class='table-list-header'>
                    HORAS
                </td>
                <td   class='table-list-header'>
                    PONTOS
                </td>
                <td   class='table-list-header'>
                    PRAZO
                </td>
                <td   class='table-list-header'>
                    CUSTOS
                </td>
                <td   class='table-list-header'>
                    IMPOSTO
                </td>
                <td   class='table-list-header'>
                    MARGEM
                </td>
                <td   class='table-list-header'>
                    PREÇO
                </td>
            </tr>

            @foreach($products as $product)
            <tr style='font-size: 14px'>
                <td class='table-list-center'>
                    <input type='hidden' name='new_product_id[]' value='{{$product->id}}'>
                    <input type='number' name='new_product_amount[]' size='4'>
                </td>
                <td class='table-list-right'>
                    <image src='{{$product->image}}' style='width:50px;height:50px; margin: 5px'>
                </td>
                <td class='table-list-left'>
                    <button class='button-round'>
                        <a href='{{route('product.show', ['product' => $product->id])}}'>
                            <i class='fa fa-eye' style='color:white'></i>
                        </a>
                    </button>
                    <button class='button-round'>
                        <a href=' {{ route('product.edit', ['product' => $product->id]) }}'>
                            <i class='fa fa-edit' style='color:white'></i>
                        </a>
                    </button>
                    {{$product->name}}
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='new_product_due_date[]' size='4' value='{{$product->due_date}}'>
                    {{number_format($product->due_date)}}
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='new_product_work_hours[]' size='4' value='{{$product->work_hours}}'>
                    {{number_format($product->work_hours)}} dia(s)
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='new_product_points[]' size='4' value='{{$product->points}}'>
                    {{$product->points}}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='new_product_cost[]' size='7' value='{{ $product->cost1 + $product->cost2 + $product->cost3}}' >
                    {{number_format($product->cost1 + $product->cost2 + $product->cost3, 2,',','.')}}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='new_product_tax_rate[]' size='7' value='{{ $product->price * $product->tax_rate / 100 }}' >
                    {{number_format($product->price * $product->tax_rate / 100, 2,',','.')}}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='new_product_margin[]' size='7' value='{{-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price }}' >
                    {{number_format(-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,',','.')}}
                </td>
                <td class='table-list-right'>
                    <input type='decimal' name='new_product_price[]' size='7' value='{{formatCurrency($product->price)}}'>
                </td>
            </tr>
            @endforeach
        </table>
        <br>
        <br>
        <br>
        <label class='labels' for='' >OBSERVAÇÕES:</label>
        <textarea id='description' name='description' rows='20' cols='90'>
		{{$invoice->description}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <label class='labels' for='' >DESCONTO:   R$</label>
        <input type='number'  name='discount' size='7' step='any' style='text-align:right' value='{{formatCurrency($invoice->discount)}}'>
        <br>
        <label class='labels' for='' >NÚMERO DE PARCELAS: </label>
        <input type='number'  class='fields' style='text-align: right' name='number_installment_total' min='1' max='18' value='{{$invoice->number_installment_total}}'>
        <br>
                <label class='labels' for='' >VALOR DESTA FATURA:   R$</label>
        <input type='number'  name='installment_value' size='7' step='any' style='text-align:right' value='{{formatCurrency($invoice->installment_value)}}'>
        <br>
        <br>
        <br>
        <label class='labels' for=''>SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', returnInvoiceStatus(), $invoice->status)}}
        <br>
        <br>
        <input type='submit' value='enviar'>
    </form>
</div>
<br>
<br>
@endsection