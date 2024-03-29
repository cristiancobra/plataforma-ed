@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('images/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonPdf($contract, 'contract')}}
{{createButtonEdit('contract', 'contract', $contract)}}
{{createButtonList('contract')}}
@endsection

@section('main')
<p>
    <br>
    <label class="labels" for="" >IDENTIFICADOR:</label>
    <span class="fields">{{$contract->identifier}}</span>
    <br>
    <label class="labels" for="" >OPORTUNIDADE:</label>
    <span class="fields">{{$contract->opportunity->name}}</span>
    <button class="button-round">
        <a href=" {{route('opportunity.show', ['opportunity' => $contract->opportunity])}}">
            <i class='fa fa-eye' style="color:white"></i>
        </a>
    </button>
    <button class="button-round">
        <a href=" {{route('opportunity.edit', ['opportunity' => $contract->opportunity])}}">
            <i class='fa fa-edit' style="color:white"></i>
        </a>
    </button>
    <br>
    <br>
<h1 class="name" style="text-align: center">
    {{$contract->name}}
</h1>
<br>
<h3>
    Objeto do contrato
</h3>
<p>
    1. É objeto deste contrato o/a {{$contract->name}} nos termos aqui descritos.
</p>
<br>
<h3>
    Identificação das partes
</h3>
<p>
    2. São partes deste contrato a empresa contratada 
    <span class="labels">{{$contract->account->name}}</span>
    <button class="button-round">
        <a href=" {{ route('account.edit', ['account' => $contract->account->id]) }}">
            <i class='fa fa-edit' style="color:white"></i></a>
    </button>
    inscrita no CNPJ sob o nº
    <span class="labels">{{formatCnpj($contract->account->cnpj)}}</span>.
    Localizada na
    <span class="labels">{{$contract->account->address}}</span>,
    em
    <span class="labels">{{$contract->account->city}}</span>,
    –
    <span class="labels">{{$contract->account->state}}</span>,
    CEP
    <span class="labels">{{formatZipCode($contract->account->zip_code)}}</span>,
    representada por
    <span class="labels">{{$contract->userContact->name}}</span>
    <button class="button-round">
        <a href=" {{route('contact.edit', ['contact' => $contract->userContact->id])}}">
            <i class='fa fa-edit' style="color:white"></i></a>
    </button>
    ,
    inscrito no CPF sob o nº
    <span class="labels">{{formatCpf($contract->userContact->cpf)}}</span>,
    residente em
    <span class="labels">{{$contract->userContact->address}}</span>,
    em
    <span class="labels">{{$contract->userContact->city}}</span>,
    /
    <span class="labels">{{$contract->userContact->state}}</span>,
    CEP:
    <span class="labels">{{formatZipCode($contract->userContact->zip_code)}}</span> e,
</p>
<br>
<p>
    a empresa contratante
    <span class="labels">{{$contract->company->name}}</span>
    <button class="button-round">
        <a href=" {{ route('company.edit', ['company' => $contract->company->id]) }}">
            <i class='fa fa-edit' style="color:white"></i></a>
    </button>
    inscrita no CNPJ sob o nº
    <span class="labels">{{formatCnpj($contract->company->cnpj)}}</span>.
    Localizada na
    <span class="labels">{{$contract->company->address}}</span>,
    em
    <span class="labels">{{$contract->company->city}}</span>,
    –
    <span class="labels">{{$contract->company->state}}</span>,
    CEP
    <span class="labels">{{formatZipCode($contract->company->zip_code)}}</span>,
    representada por
    <span class="labels">{{$contract->contact->name}}</span>
    <button class="button-round">
        <a href=" {{route('contact.edit', ['contact' => $contract->contact->id])}}">
            <i class='fa fa-edit' style="color:white"></i></a>
    </button>
    ,
    inscrito no CPF sob o nº
    <span class="labels">{{formatCpf($contract->contact->cpf)}}</span>,
    residente em
    <span class="labels">{{$contract->contact->address}}</span>,
    em
    <span class="labels">{{$contract->contact->city}}</span>,
    /
    <span class="labels">{{$contract->contact->state}}</span>,
    CEP:
    <span class="labels">{{formatZipCode($contract->contact->zip_code)}}</span>.
</p>
<br>
<h3>
    Serviços/produtos contratados
    <button class="button-round">
        <a href=" {{ route('proposal.edit', [
                                                                'proposal' => $contract->proposal_id,
                                                                'type' => 'receita',
                                                               ]) }}">
            <i class='fa fa-edit' style="color:white"></i></a>
    </button>
</h3>
<p>
    3. Os produtos/serviços contratados e suas especificidades são:
</p>
<br>
<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 5%">
            QTDE
        </td>
        <td   class="table-list-header" style="width: 55%">
            NOME
        </td>
        <td   class="table-list-header" style="width: 10%">
            PRAZO
        </td>
        <td   class="table-list-header" style="width: 10%">
            IMPOSTO
        </td>
        <td   class="table-list-header" style="width: 10%">
            UNITÁRIO
        </td>
        <td   class="table-list-header" style="width: 10%">
            TOTAL
        </td>
    </tr>

    @foreach ($productProposals as $productProposal)
    <tr style="font-size: 14px">
        <td class="table-list-center">
            {{$productProposal->amount}}
        </td>
        <td class="table-list-left">
            {{$productProposal->product->name}}
        </td>
        <td class="table-list-center">
            {{$productProposal->subtotalDeadline}} dia(s)
        </td>
        <td class="table-list-right">
            {{formatCurrencyReal($productProposal->subtotalTax_rate)}}
        </td>
        <td class="table-list-right">
            {{formatCurrencyReal($productProposal->product->price)}}
        </td>
        <td class="table-list-right">
            {{formatCurrencyReal($productProposal->subtotalPrice)}}
        </td>
    </tr>

    <tr style="font-size: 12px">
        <td class="table-list-left" colspan="6">
            {!!html_entity_decode($productProposal->product->description)!!}
        </td>
    </tr>
    @endforeach

    <tr>
        <td   class="table-list-header-right" colspan="4">
        </td>
        <td   class="table-list-header-right">
            desconto: 
        </td>
        <td   class="table-list-header-right">
            @if($contract->proposal)
            - {{formatCurrencyReal($contract->proposal->discount)}}
            @else
            fatura excluída
            @endif
        </td>
    </tr>
    <tr>
        <td   class="table-list-header-right" colspan="4">

        <td   class="table-list-header-right">
            TOTAL: 
        </td>
        </td>
        <td   class="table-list-header-right">
            @if($contract->proposal)
            {{formatCurrencyReal($contract->proposal->totalPrice) }}
            @else
            fatura excluída
            @endif
        </td>
    </tr>
    <tr>
        <td   class="table-list-header-right" colspan="4">
        </td>
        <td   class="table-list-header-right">
            PARCELAMENTO: 
        </td>

        <td   class="table-list-header-right" colspan="2">
            @if($contract->proposal)
            @if($contract->proposal->installment == 1)
            À vista
            @else
            {{$contract->proposal->installment}}x
            @endif
            @else
            fatura excluída
            @endif
        </td>
    </tr>
</table>
<br>
<br>
<h3>
    Condições gerais
</h3>
<p>
    {!!html_entity_decode($contract->text)!!}
</p>
<br>
<br>
<p style="text-align: center">
    Assinam esse contrato no dia {{date('d/m/Y', strtotime($contract->date_start))}}
</p>
<br>
<div style="text-align: center;display: inline-block;width: 100%">
    <div>
        <p style="text-align: center;display: inline-block;padding: 5%">
            ________________________________________________
            <br>
            <span class="labels">{{$contract->userContact->name}}</span> - <span class="labels">{{$contract->account->name}}</span>
            <br>
            contratada
            <br>
        </p>
        <p style="text-align: center;display: inline-block;padding: 5%">
            <br>
            ________________________________________________
            <br>
            <span class="labels">{{$contract->contact->name}}</span> - <span class="labels">{{$contract->company->name}}</span>
            <br>
            contratante
            <br>
        </p>
        <br>
    </div>
    <div>
        <p style="text-align: center;display: inline-block;padding: 5%">
            ________________________________________________
            <br>
            <span class="labels">{{$witnessName1}}</span> - testemunha 1
            <br>
        </p>
        <p style="text-align: center;display: inline-block;padding: 5%">
            ________________________________________________
            <br>
            <span class="labels">{{$witnessName2}}</span> - testemunha 2
            <br>
        </p>
        <br>
    </div>
</div>
<br>
<br>
<h3>
    Observações
</h3>
<p>
    Informações internas, não aparecerão no contrato final (PDF).
</p>
<p>
    {!!html_entity_decode($contract->observations)!!}
</p>
<br>
<br>
<p class="labels">Criado em:  {{date('d/m/Y H:i', strtotime($contract->created_at))}}</p>

<div style="text-align:right">
    <a class="btn btn-secondary" href=" {{ route('contract.edit', ['contract' => $contract->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
        <i class='fa fa-edit'></i>
        EDITAR
    </a>
    <a class="btn btn-secondary" href="{{route('contract.index')}}">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<br>

@endsection