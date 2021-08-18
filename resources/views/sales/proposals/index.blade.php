@extends('layouts/index')

@if($type == 'receita')
@section('title','PROPOSTAS')
@else
@section('title','DESPESAS')
@endif

@section('image-top')
{{asset('images/proposal.png')}} 
@endsection


@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonBack()}}
{{createButtonCreate('proposal', 'type', $type)}}
@endsection

@section('table')
<div class="row mb-5">
    <form id="filter" action="{{route('proposal.index')}}" method="post" style="text-align: right;display:none">
        @csrf
        <input type="text" name="name" placeholder="nome da oportunidade" value="">
        <input type="date" name="date_start" size="20" value="{{old('date_start')}}">
        <input type="date" name="date_end" size="20" value="{{old('date_end')}}">
        {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
        {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todas os contatos')}}
        {{createFilterSelect('status', 'select', returnInvoiceStatusToFilter(), 'Todas as situações')}}
        <br>
        <a class="text-button secondary" href='{{route('proposal.index')}}'>
            LIMPAR
        </a>
        <input class="text-button primary" type="submit" value="FILTRAR">
    </form>
</div>

<div class='row'>
    <div   class="tb tb-header-start col-1">
        ID
    </div>
    <div   class="tb tb-header col-4">
        NOME
    </div>
    <div   class="tb tb-header col-2">
        CONTATO
    </div>
    <div   class="tb tb-header col-2">
        CONTRATANTE 
    </div>
    <div   class="tb tb-header col-1">
        VENCIMENTO
    </div>
    <div   class="tb tb-header col-1">
        VALOR
    </div>
    <div   class="tb tb-header-end col-1">
        SITUAÇÃO
    </div>
</div>

@foreach ($proposals as $proposal)
<div class='row'>
    <div class="tb col-1 justify-content-start">
        <button class="button-round">
            <a href=" {{route('proposal.show', ['proposal' => $proposal])}}">
                <i class='fa fa-eye' style="color:white"></i>
            </a>
        </button>
        {{$proposal->identifier}}
    </div>
    <div class="tb col-4 justify-content-start">
        @if($proposal->name)
        {{$proposal->name}}
        @else
        Sem nome
        @endif
    </div>
    <div class="tb col-2">
        @if($proposal->contact)
        {{$proposal->contact->name}}
        @else
        não possui
        @endif
    </div>
    <div class="tb col-2">
        @if(isset($proposal->company))
        {{$proposal->company->name}}
        @else
        não possui
        @endif
    </div>
    @if($proposal->status == 'aprovada' AND $proposal->pay_day < date('Y-m-d'))
    <div class="tb col-1" style="color: red">
        {{date('d/m/Y', strtotime($proposal->pay_day))}}
    </div>
    @else
    <div class="tb col-1">
        {{date('d/m/Y', strtotime($proposal->pay_day))}}
    </div>
    @endif
    @if($proposal->type == 'receita')
    <div class="tb col-1 justify-content-end">
        {{formatCurrencyReal($proposal->totalPrice)}}
    </div>
    @else
    <div class="tb col-1 justify-content-end" style="color: red">
        - {{formatCurrencyReal($proposal->totalPrice)}}
    </div>
    @endif

    {{formatInvoiceStatus($proposal)}}
</div>
@endforeach

<p style="text-align: right">
    <br>
    {{$proposals->links()}}
</p>
<br>
@endsection

@section('js-scripts')
<script>
    $(document).ready(function () {
        //botao de exibir filtro
        $("#filter_button").click(function () {
            $("#filter").slideToggle(600);
        });

    });
</script>
@endsection