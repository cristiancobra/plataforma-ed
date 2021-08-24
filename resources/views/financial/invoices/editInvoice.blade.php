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
            <option  class='fields' value='{{$invoice->user_id}}'>
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
        <input type='date' name='date_creation' size='20' value='{{$invoice->date_creation}}'>
        @if ($errors->has('date_creation'))
        <span class="text-danger">{{$errors->first('date_creation')}}</span>
        @endif
        <br>
        <label class='labels' for='' >VALIDADE DA PROPOSTA:</label>
        <input type='number' name='expiration_date' size='3' min='1' max='365' value='{{$invoice->expiration_date}}'> dias
        <br>
        <label class='labels' for='' >DATA DO PAGAMENTO:</label>
        <input type='date' name='pay_day' size='20' value='{{$invoice->pay_day}}'>
        @if ($errors->has('pay_day'))
        <span class="text-danger">{{$errors->first('pay_day')}}</span>
        @endif
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
                    UNITÁRIO
                </td>
                <td   class='table-list-header'>
                    PREÇO
                </td>
            </tr>

            @foreach ($productProposals as $productProposal)
            <input type='hidden' name='product_margin[]' size='7' value='{{-$productProposal->product->price * $productProposal->product->tax_rate / 100 - $productProposal->product->cost1 - $productProposal->product->cost2 - $productProposal->product->cost3 + $productProposal->product->price}}'>
            <tr style='font-size: 14px'>
                <td class='table-list-center'>
                    {{number_format($productProposal->amount)}}
                </td>
                <td class='table-list-right'>
                    <image src='{{$productProposal->product->image}}' style='width:50px;height:50px; margin: 5px'></a>
                </td>
                <td class='table-list-left'>
                    <button class='button'>
                        <a href=' {{route('product.show', ['product' => $productProposal->product->id])}}'>
                            <i class='fa fa-eye' style='color:white'></i></a>
                    </button>
                    <button class='button'>
                        <a href=' {{route('product.edit', ['product' => $productProposal->product->id])}}'>
                            <i class='fa fa-edit' style='color:white'></i></a>
                    </button>
                    <span class='fields'>{{$productProposal->product->name}}</span>
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='product_due_date[]' size='4' value='{{$productProposal->product->due_date}}'>
                    {{number_format($productProposal->product->due_date)}}
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='product_work_hours[]' size='4' value='{{$productProposal->product->work_hours}}'>
                    {{number_format($productProposal->product->work_hours)}}
                </td>
                <td class='table-list-center'>
                    <input type='hidden' name='product_points[]' size='4' value='{{$productProposal->product->points}}'>
                    {{number_format($productProposal->product->points)}}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='product_cost[]' size='7' value='{{ $productProposal->product->cost1 + $productProposal->product->cost2 + $productProposal->product->cost3}}' >
                    {{number_format($productProposal->product->cost1 + $productProposal->product->cost2 + $productProposal->product->cost3, 2,',','.') }}
                </td>
                <td class='table-list-right'>
                    <input type='hidden' name='product_tax_rate[]' size='7' value='{{$productProposal->product->price * $productProposal->product->tax_rate / 100}}' >
                    {{number_format($productProposal->product->price * $productProposal->product->tax_rate / 100, 2,',','.') }}
                </td>
                <td class='table-list-right'>
                    {{formatCurrency($productProposal->product->price)}}
                </td>
                <td class='table-list-right'>
                    {{formatCurrency($productProposal->subtotalPrice)}}
                </td>
            </tr>
            @endforeach
            <tr>
                <td   class='table-list-header-right' colspan='8'>
                    desconto: 
                </td>
                <td   class='table-list-header-right' colspan='3'>
                    {{formatCurrencyReal($invoice->proposal->discount)}}
                </td>
            </tr>
            <tr>
                <td   class='table-list-header-right' colspan='8'>
                    VALOR DA PROPOSTA: 
                </td>
                <td   class='table-list-header-right' colspan='3'>
                    {{formatCurrencyReal($invoice->proposal->totalPrice)}}
                </td>
            </tr>
            <tr>
                <td   class='table-list-header-right' colspan='8'>
                    VALOR DESTA FATURA: 
                </td>

                <td   class='table-list-header-right' colspan='3'>
                    <input type='decimal' name='totalPrice' value='{{formatCurrency($invoice->totalPrice)}}' style="text-align:right">
                </td>
            </tr>
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
