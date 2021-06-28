@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('images/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button secondary"  href="{{route('contractTemplate.index')}}">
    <i class="fa fa-edit" aria-hidden="true"></i>
</a>
<a class="circular-button primary"  href="{{route('contract.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 25%">
                TÍTULO
            </td>
            <td   class="table-list-header" style="width: 15%">
                CONTRATADA
            </td>
            <td   class="table-list-header" style="width: 15%">
                CONTRATANTE
            </td>
            <td   class="table-list-header" style="width: 15%">
                RESPONSÁVEL
            </td>
            <td   class="table-list-header" style="width: 10%">
                INÍCIO
            </td>
            <td   class="table-list-header" style="width: 10%">
                VENCIMENTO
            </td>
            <td   class="table-list-header" style="width: 10%">
                SITUAÇÃO
            </td>
        </tr>

        @foreach ($contracts as $contract)
        <tr style="font-size: 14px">
            <td class="table-list-left">
                <button class="button-round">
                    <a href=" {{ route('contract.show', ['contract' => $contract]) }}">
                        <i class='fa fa-eye' style="color:white"></i></a>
                </button>
                <button class="button-round">
                    <a href=" {{ route('contract.edit', ['contract' => $contract]) }}">
                        <i class='fa fa-edit' style="color:white"></i></a>
                </button>
                {{$contract->name}}
            </td>
            <td class="table-list-center">
                {{$contract->account->name}}
            </td>
            <td class="table-list-center">
                {{$contract->company->name}}
            </td>
            <td class="table-list-center"> 
                {{$contract->userContact->name}}
            </td>
            <td class="table-list-center">
                {{date('d/m/Y', strtotime($contract->date_start))}}
            </td>
            <td class="table-list-center">
                {{date('d/m/Y', strtotime($contract->date_due))}}
            </td>
            @if($contract->status == 'assinado' AND $contract->date_due < date('Y-m-d'))
            <td class="td-late">
                vencido
            </td>
            @elseif($contract->status == 'assinado' AND $contract->date_start <= date('Y-m-d'))
            <td class="td-doing">
                vigente
            </td>
            @else
            {{formatContractStatus($contract)}}
            @endif
        </tr>
        @endforeach
    </table>
    <p style="text-align: right">
        <br>
        {{ $contracts->links() }}
    </p>
    <br>
    @endsection