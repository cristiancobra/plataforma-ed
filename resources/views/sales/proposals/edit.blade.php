@extends('layouts/edit')

@if($type == 'receita')
@section('title','PROPOSTAS')
@else
@section('title','DESPESAS')
@endif

@section('image-top')
{{ asset('images/proposal.png') }} 
@endsection

@section('form_start')
<form action=' {{route('proposal.update', ['proposal' => $proposal])}} ' method='post'>
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
    <input type='text' name='name' size='60' style='margin-left: 10px' value='{{$proposal->name}}'>
    @endsection


    @section('status')
    SITUAÇÃO:
    {{createSimpleSelect('status', 'fields', returnInvoiceStatus(), $proposal->status)}}
    @endsection

    @section('fieldsId')
    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            EMPRESA
        </div>
        <div class='show-label'>
            CONTATO
        </div>
        @if(isset($proposal->opportunity))
        <div class='show-label'>
            OPORTUNIDADE
        </div>
        @endif
    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>
        <div class='show-field-end'>
            {{createDoubleSelectIdName('company_id', 'fields', $companies,'Não possui', $proposal->company)}}
        </div>
        <div class='show-field-end'>
            {{createDoubleSelectIdName('contact_id', 'fields', $contacts,'Não possui', $proposal->contact)}}
            {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        </div>
        @if(isset($proposal->opportunity))
        <div class='show-field-end'>
            <input type='hidden' name='opportunity_id' value='{{$proposal->opportunity_id}}'>
            <span class='fields'>{{$proposal->opportunity->name}}</span>
        </div>
        @endif
    </div>
    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            RESPONSÁVEL
        </div>
        <div class='show-label'>
            IDENTIFICADOR
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
            <select name='user_id' style='width: 89%'>
                <option  class='fields' value='{{$proposal->user_id}}'>
                    {{$proposal->user->contact->name}}
                </option>
                @foreach ($users as $user)
                <option  class='fields' value='{{$user->id}}'>
                    {{$user->name}}
                </option>
                @endforeach
            </select>
        </div>
        <div class='show-field-end'>
            <input type='number'  name='identifier' size='5' style='text-align: right' value='{{$proposal->identifier}}'>
        </div>
        <div class='show-field-end'>
            @if(!isset($proposal->contract_id) OR $proposal->contract_id == 0)
            Sem contrato
            @else
            <select name='contract_id'>
                <option  class='fields' value='{{$proposal->contract_id}}'>
                    {{$proposal->contract_id}}
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
            <input type='number'  class='fields' style='text-align: right' name='installment' value='{{$proposal->installment}}' max='12' size='4'>
        </div>
    </div>
    @endsection



    @section('date_start')
    <div class='circle-date-start'>
        <input type='date' name='date_creation' size='20' value='{{$proposal->date_creation}}'>
        @if ($errors->has('date_creation'))
        <span class='text-danger'>{{$errors->first('date_creation')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CRIAÇÃO
    </p>
    @endsection


    @section('date_due')    
    <div class='circle-date-due'>
        <input type='date' name='pay_day' size='20' value='{{$proposal->pay_day}}'>
        @if ($errors->has('pay_day'))
        <span class='text-danger'>{{$errors->first('pay_day')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        VENCIMENTO
    </p>
    @endsection


    @section('date_conclusion')
    <div class='circle-date-due'>
        <input type='number' name='expiration_date' size='3' min='1' max='365' value='{{$proposal->expiration_date}}'> dias
    </div>
    <p class='labels' style='text-align: center'>
        VALIDADE
    </p>
    @endsection


    @section('description')
    <textarea id='description' name='description' rows='20' cols='90'>
		{{$proposal->description}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
    <script>
CKEDITOR.replace('description');
    </script>
    @endsection


    @section('main')
    <div>
        <label class='labels' for='' >PRODUTOS ATUAIS:</label>
        <div class='row'>
            <div class='tb tb-header-start col-1'>
                QTDE
            </div>
            <div class='tb tb-header col-1'>
                FOTO
            </div>
            <div class='tb tb-header col-3'>
                NOME
            </div>
            <div class='tb tb-header col-1'>
                HORAS
            </div>
            <div class='tb tb-header col-1'>
                PONTOS
            </div>
            <div class='tb tb-header col-1'>
                PRAZO
            </div>
            <div class='tb tb-header col-1'>
                CUSTOS
            </div>
            <div class='tb tb-header col-1'>
                IMPOSTO
            </div>
            <div class='tb tb-header col-1'>
                UNITÁRIO
            </div>
            <div class='tb tb-header-end col-1'>
                PREÇO
            </div>
        </div>

        @foreach ($productProposals as $productProposal)
        <input type='hidden' name='product_proposal_id[]' value='{{$productProposal->id}}'>
        <input type='hidden' name='product_id[]' value='{{$productProposal->product->id}}'>
        <input type='hidden' name='product_margin[]' size='7' value='{{-$productProposal->product->price * $productProposal->product->tax_rate / 100 - $productProposal->product->cost1 - $productProposal->product->cost2 - $productProposal->product->cost3 + $productProposal->product->price}}'>
        <div class='row'>
            <div class='tb -start col-1'>
                <input type='number' name='product_amount[]' size='5' value='{{$productProposal->amount}}'>
            </div>
            <div class='tb  col-1'>
                <image src='{{$productProposal->product->image}}' style='width:50px;height:50px; margin: 5px'></a>
            </div>
            <div class='tb  col-3'>
                <button class='button'>
                    <a href=' {{route('product.show', ['product' => $productProposal->product->id])}}'>
                        <i class='fa fa-eye' style='color:white'></i></a>
                </button>
                <button class='button'>
                    <a href=' {{route('product.edit', ['product' => $productProposal->product->id])}}'>
                        <i class='fa fa-edit' style='color:white'></i></a>
                </button>
                <span class='fields'>{{$productProposal->product->name}}</span>
            </div>
            <div class='tb  col-1'>
                <input type='hidden' name='product_due_date[]' size='4' value='{{$productProposal->product->due_date}}'>
                {{number_format($productProposal->product->due_date)}}
            </div>
            <div class='tb  col-1'>
                <input type='hidden' name='product_work_hours[]' size='4' value='{{$productProposal->product->work_hours}}'>
                {{number_format($productProposal->product->work_hours)}}
            </div>
            <div class='tb  col-1'>
                <input type='hidden' name='product_points[]' size='4' value='{{$productProposal->product->points}}'>
                {{number_format($productProposal->product->points)}}
            </div>
            <div class='tb  col-1'>
                <input type='hidden' name='product_cost[]' size='7' value='{{ $productProposal->product->cost1 + $productProposal->product->cost2 + $productProposal->product->cost3}}' >
                {{number_format($productProposal->product->cost1 + $productProposal->product->cost2 + $productProposal->product->cost3, 2,',','.') }}
            </div>
            <div class='tb  col-1'>
                <input type='hidden' name='product_tax_rate[]' size='7' value='{{$productProposal->product->price * $productProposal->product->tax_rate / 100}}' >
                {{number_format($productProposal->product->price * $productProposal->product->tax_rate / 100, 2,',','.') }}
            </div>
            <div class='tb  col-1'>
                @if($type == 'despesa')
                <input type='decimal' name='price[]' id='product_price' size='7' value='{{formatCurrency($productProposal->price * -1)}}' style='text-align: right'>
                @else
                <input type='decimal' name='price[]' id='product_price' size='7' value='{{formatCurrency($productProposal->price)}}' style='text-align: right'>
                @endif
            </div>
            <div class='tb  col-1'>
                {{formatCurrencyReal($productProposal->subtotalPrice)}}
            </div>
        </div>
        @endforeach
        <div class='row'>
            <div class='tb tb-header col-11'>
                desconto: 
            </div>
            <div class='tb tb-header col-1 justify-content-end'>
                <input type='text' id='discount' name='discount' value='{{formatCurrency($proposal->discount)}}' style='text-align: right;width: 90px'>
            </div>
        </div>
        <div class='row'>
            <div class='tb tb-header col-11'>
                TOTAL DA COMPRA: 
            </div>
            <div class='tb tb-header col-1'>
                {{formatCurrencyReal($proposal->totalPrice)}}
            </div>
        </div>
    </div>
    @endsection

    @section('js-scripts')
    <script>
        $('[name=discount]').maskMoney({prefix: 'R$ ', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false});
        $('[id=product_price]').maskMoney({prefix: 'R$ ', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false});
    </script>
    @endsection