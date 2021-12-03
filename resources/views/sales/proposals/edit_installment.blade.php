@extends('layouts/edit')

@section('title','EDITAR PARCELAMENTO')

@section('image-top')
{{ asset('images/proposal.png') }} 
@endsection


@section('form_start')
<form action=' {{route('proposal.updateInstallment', [
                                                                                        'proposal' => $proposal,
                                                                                        'invoice' => $invoices,
                                                                                     ])}} ' method='post'>
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
    {{$proposal->name}}
    @endsection


    @section('priority')
    {{$proposal->identifier}}
    @endsection


    @section('status')
    {{$proposal->status}}
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
        @if($proposal->opportunity)
        <div class='show-label'>
            OPORTUNIDADE
        </div>
        @endif
    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>
        <a href='{{route('proposal.show', ['proposal' => $proposal])}}'>
            <div class='show-field-end'>
                {{$proposal->name}}
            </div>
        </a>
        <div class='show-field-end'>
            @if($proposal->company)
            {{$proposal->company->name}}
            @else
            Nao possui
            @endif
        </div>
        <div class='show-field-end'>
            @if($proposal->contact)
            {{$proposal->contact->name}}
            @else
            Nao possui
            @endif
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
            {{$proposal->user->contact->name}}
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
            {{$proposal->installment}}
        </div>
    </div>
    @endsection





    @section('description')
    <section class='container' id='description'>
        O valor da soma das parcelas não pode ser MAIOR que o valor total da proposta.
        <br>
        Para realizar essa alteração clique acima em PROPOSTA e edite o valor total da proposta.
    </section>
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
    <section class='container mt-5' id='invoicesLines'>
        <div class='row table-header mt-3'>
            <div class='col-1'>
                FATURA
            </div>
            <div class='col-5'>
                PROPOSTA
            </div>
            <div class="col-2">
                VENCIMENTO
            </div>
            <div class="col-2">
                VALOR ATUAL
            </div>
            <div class="col-2">
                NOVO VALOR
            </div>
        </div>
        @foreach($invoices as $invoice)
        <div class='row table2 position-relative'  style='
             color: {{$principalColor}};
             border-left-color: {{$complementaryColor}}
             '>
            <div class='cel col-1 justify-content-start'  style="font-size: 26px;font-weight: 600">
                {{$counter}}
                <i class="fas fa-file-invoice-dollar" style='
                   display:block;
                   padding-left:10px;
                   width:25%;
                   font-size: 30px;
                   '>
                </i>
            </div>
            <div class='cel col-5 justify-content-start'>
                {{$invoice->proposal->name}}
            </div>
            <div class='cel col-2'>
                <input class="form-control text-end" type='date' name='pay_day[]' value='{{$invoice->pay_day}}' style="font-size: 14px">
            </div>
            <div class='cel col-2 justify-content-end'>
                {{formatCurrencyReal($invoice->totalPrice)}}
            </div>
            <div class='cel col-2 justify-content-end'>
                @if($proposal->type == 'receita')
                <input class="form-control" id='totalPrice_{{$counter++}}' name='totalPrice[]' type='decimal'  value='{{formatCurrency($invoice->totalPrice)}}' style="text-align: right;width: 120px;font-size: 14px">
                @else
                <input class="form-control" id='totalPrice_{{$counter++}}' name='totalPrice[]' type='decimal'  value='{{formatCurrency($invoice->totalPrice * -1)}}' style="text-align: right;width: 120px;font-size: 14px">
                @endif
            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-8 tb-header justify-content-end">
                TOTAL DA PROPOSTA
            </div>
            <div class="col-2 tb-header justify-content-lg-end">
                @if($proposal->type == 'receita')
                {{formatCurrency($proposal->totalPrice)}}
                @else
                {{formatCurrency($proposal->totalPrice * 1)}}
                @endif
            </div>
            <div class="col-2 tb-header">

            </div>
        </div>
    </section>
    @endsection


    @section('js-scripts')
    <script>
        @while ($counter > 0)
                $('[id=totalPrice_{!! json_encode($counter) !!}]').maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
        {{$counter--}}
        @endwhile
    </script>
    @endsection