@extends('layouts/edit')

@section('title','FATURAS')

@section('image-top')
{{ asset('images/invoice.png') }} 
@endsection


@section('form_start')
<form action=' {{route('invoice.update', ['invoice' => $invoice])}} ' method='post'>
    @csrf
    @method('put')
    @endsection


    @section('buttons')
    <a class='circular-button secondary'  title='Cancelar alterações' href='{{url()->previous()}}'>
        <i class='fas fa-times-circle'></i>
    </a>
    <button id='' class='circular-button primary' title='Salvar alterações' style='border:none;padding-left:4px;padding-top:2px' 'type='submit'>
        <i class='fas fa-save'></i>
    </button>
    @endsection


    @section('name')
    NOME:
    <input type='text' name='name' size='60' style='margin-left: 10px' value='{{$invoice->proposal->name}}'>
    @endsection


    @section('priority')
    IDENTIFICADOR:
    <input type='number' name='identifier'  style='width: 80px;text-align: right' value='{{$invoice->identifier}}'>
    @endsection


    @section('status')
    SITUAÇÃO:
    {{createSimpleSelect('status', 'fields', $status, $invoice->proposal->status)}}
    @endsection


    @section('fieldsId')
    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            PROPOSTA
        </div>
        <div class='show-label'>
            EMPRESA
        </div>
        <div class='show-label'>
            CONTATO
        </div>
        @if($invoice->proposal->opportunity)
        <div class='show-label'>
            OPORTUNIDADE
        </div>
        @endif
    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>
        <a href="{{route('proposal.show', ['proposal' => $invoice->proposal])}}">
            <div class='show-field-end'>
                {{$invoice->proposal->name}}
            </div>
        </a>
        <div class='show-field-end'>
            {{$invoice->proposal->company->name}}
        </div>
        <div class='show-field-end'>
            @if($invoice->proposal->contact)
            {{$invoice->proposal->contact->name}}
            @else
            Nao possui
            @endif
        </div>
        @if(isset($invoice->proposal->opportunity))
        <div class='show-field-end'>
            <input type='hidden' name='opportunity_id' value='{{$invoice->proposal->opportunity_id}}'>
            <span class='fields'>{{$invoice->proposal->opportunity->name}}</span>
        </div>
        @endif
    </div>
    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            VENDEDOR
        </div>
        <div class='show-label'>
            CONTRATO
        </div>
        <div class='show-label'>
            PARCELAMENTO
        </div>
    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>
        <div class='show-field-end'>
            {{$invoice->proposal->user->contact->name}}
        </div>
        <div class='show-field-end'>
            @if(!isset($invoice->proposal->contract_id) OR $invoice->proposal->contract_id == 0)
            Sem contrato
            @else
            <select name='contract_id'>
                <option  class='fields' value='{{$invoice->proposal->contract_id}}'>
                    {{$invoice->proposal->contract_id}}
                </option>
                @foreach ($contracts as $contract)
                <option  class='fields' value='{{$contract->id}}'>
                    {{$contract->id}} - {{$contract->name}}
                </option>
                @endforeach
            </select>
            @endif
        </div>
        <div class='show-field-end'>
            {{$invoice->proposal->installment}}
        </div>
    </div>
    @endsection





    @section('date_start')
    <div class='circle-date-start'>
        <input type='date' name='date_creation' size='20' value='{{$invoice->date_creation}}'>
        @if ($errors->has('date_creation'))
        <span class="text-danger">{{$errors->first('date_creation')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CRIAÇÃO
    </p>
    @endsection


    @section('date_due')    
    <div class='circle-date-due'>
        <input type='date' name='pay_day' size='20' value='{{$invoice->pay_day}}'>
        @if ($errors->has('pay_day'))
        <span class='text-danger'>{{$errors->first('pay_day')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        VENCIMENTO
    </p>
    @endsection




    @section('description')
    <textarea id='description' name='description' rows='20' cols='90'>
		{{$invoice->proposal->description}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
    <script>
CKEDITOR.replace('description');
    </script>
    @endsection



    @section('main')
    <div class="row table-header mt-5">
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
    </div>
    @endsection


    @section('js-scripts')
    <script>
        $("[name=value]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
    </script>
    @endsection