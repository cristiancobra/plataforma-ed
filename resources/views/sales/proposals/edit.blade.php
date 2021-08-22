@extends('layouts/master')

@if($type == 'receita')
@section('title','PROPOSTAS')
@else
@section('title','DESPESAS')
@endif

@section('image-top')
{{ asset('images/proposal.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='circular-button primary'  href='{{route('proposal.index')}}'>
    <i class='fas fa-arrow-left'></i>
</a>
@endsection

@section('main')
<div>
    <form action=' {{route('proposal.update', ['proposal' => $proposal])}} ' method='post'>
        @csrf
        @method('put')
        <label class='labels' for='' >NOME:</label>
        <input type='text' name='name' size='80' value='{{$proposal->name}}'>
        <br>
        <label class='labels' for='' >IDENTIFICADOR:</label>
        <input type='number'  size='5' style='text-align: right' value='{{$proposal->identifier}}'>
        <br>
        <label class='labels' for='' >VENDEDOR: </label>
        <select name='user_id'>
            <option  class='fields' value='{{$proposal->user_id}}'>
                {{$proposal->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class='fields' value='{{$user->id}}'>
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        @if(isset($proposal->opportunity))
        <label class='labels' for='' >OPORTUNIDADE: </label>
        <input type='hidden' name='opportunity_id' value='{{$proposal->opportunity_id}}'>
        <span class='fields'>{{$proposal->opportunity->name}}</span>
        <br>
        @endif


        <label class='labels' for=''>EMPRESA:</label>
        {{createDoubleSelectIdName('company_id', 'fields', $companies,'Não possui', $proposal->company)}}

        <br>

        <label class='labels' for='' >CONTATO: </label>
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts,'Não possui', $proposal->contact)}}
        {{createButtonAdd('company.create', 'typeCompanies','fornecedor')}}
        <br>
        @if(isset($proposal->opportunity_id))
        <label class='labels' for='' >CONTRATO: </label>
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
        <br>
        <br>
        <label class='labels' for='' >DATA DE CRIAÇÃO:</label>
        <input type='date' name='date_creation' size='20' value='{{$proposal->date_creation}}'>
        @if ($errors->has('date_creation'))
        <span class='text-danger'>{{$errors->first('date_creation')}}</span>
        @endif
        <br>
        <label class='labels' for='' >VALIDADE DA PROPOSTA:</label>
        <input type='number' name='expiration_date' size='3' min='1' max='365' value='{{$proposal->expiration_date}}'> dias
        <br>
        <label class='labels' for='' >DATA DO PAGAMENTO:</label>
        <input type='date' name='pay_day' size='20' value='{{$proposal->pay_day}}'>
        @if ($errors->has('pay_day'))
        <span class='text-danger'>{{$errors->first('pay_day')}}</span>
        @endif
        <br>
        <br>
        <label class='labels' for='' >NÚMERO DE PARCELAS: </label>
        <input type='number'  class='fields' style='text-align: right' name='installment' value='{{$proposal->installment}}' max='12'>
        <br>
        <br>
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
                <input type='decimal' name='product_price[]' size='7' value='{{formatCurrency($productProposal->product->price)}}' style='text-align: right'>
            </div>
            <div class='tb  col-1'>
                {{formatCurrency($productProposal->subtotalPrice)}}
            </div>
        </div>
        @endforeach
        <div class='row'>
            <div class='tb tb-header col-11'>
                desconto: 
            </div>
            <div class='tb tb-header col-1'>
                - {{formatCurrencyReal($proposal->discount)}}
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
        <br>
        <br>
        <br>
        <label class='labels' for='' >OBSERVAÇÕES:</label>
        <textarea id='description' name='description' rows='20' cols='90'>
		{{$proposal->description}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <label class='labels' for=''>SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', returnInvoiceStatus(), $proposal->status)}}
        <br>
        <br>
        <input type='submit' value='enviar'>
    </form>
</div>
<br>
<br>
@endsection
