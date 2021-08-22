@extends('layouts/master')

@section('title','EDITAR PARCELAMENTO')

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
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<form action=' {{route('proposal.updateInstallment', [
                                                                                        'proposal' => $proposal,
                                                                                        'invoice' => $invoices,
                                                                                     ])}} ' method='post'>
    @csrf
    @method('put')
    @foreach($invoices as $invoice)
    <div class="row">
        <div class="col-2 tb tb-header">
            IDENTIFICADOR
        </div>
        <div class="col-6 tb tb-header">
            VENCIMENTO
        </div>
        <div class="col-2 tb tb-header">
            VALOR ATUAL
        </div>
        <div class="col-2 tb tb-header">
            NOVO VALOR
        </div>
    </div>
    <div class="row">
        <div class="col-2 tb">
            {{$invoice->id}}
        </div>
        <div class="col-6 tb">
            <input type='date' name='pay_day[]' value='{{$invoice->pay_day}}'>
        </div>
        <div class="col-2 tb justify-content-end">
            {{formatCurrency($invoice->totalPrice)}}
        </div>
        <div class="col-2 tb justify-content-end">
            <input type='decimal' name='totalPrice[]' value='{{formatCurrency($invoice->totalPrice)}}' style="text-align: right">
        </div>
    </div>
    @endforeach
        <div class="row">
        <div class="col-8 tb-header justify-content-end">
            TOTAL DA PROPOSTA
        </div>
        <div class="col-2 tb-header justify-content-lg-end">
            {{formatCurrencyReal($proposal->totalPrice)}}
        </div>
        <div class="col-2 tb-header">
            
        </div>
        </div>
    <br>
    <br>
    <input type='submit' value='enviar'>
</form>
</div>
<br>
<br>
@endsection