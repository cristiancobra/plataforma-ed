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
{{createButtonTrashIndex($trashStatus, 'proposal')}}

{{createButtonCreate('proposal', 'type', $type)}}
@endsection

@section('table')
<div class="row mb-5">
    <form id="filter" action="{{route('proposal.index')}}" method="get" style="text-align: right;display:none">
        <input type="hidden" name="type" value="{{$type}}">
        <input type="text" name="name" placeholder="nome da oportunidade" value="">
        <input type="date" name="date_start" size="20" value="{{old('date_start')}}">
        <input type="date" name="date_end" size="20" value="{{old('date_end')}}">
        {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
        {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todas os contatos')}}
        {{createFilterSelectModels('product_id', 'select', $products, 'Todos os produtos')}}
        {{createFilterSelect('status', 'select', returnInvoiceStatusToFilter(), 'Todas as situações')}}
        <br>
        <a class="text-button secondary" href='{{route('proposal.index', ['type' => $type])}}'>
            LIMPAR
        </a>
        <input class="text-button primary" type="submit" value="FILTRAR">
    </form>
</div>

<div class='row  table-header mt-2 mb-2' style="background-color: {{$principalColor}}">
    <div   class="col-3">
        NOME
    </div>
    <div   class="col-2">
        CONTATO
    </div>
    <div   class="col-2">
        @if($type == 'receita')
        CONTRATANTE 
        @else
        FORNECEDOR
        @endif
    </div>
    <div   class="col-1">
        VENCIMENTO
    </div>
    <div   class="col-1">
        TOTAL
    </div>
    <div   class="col-1">
        SALDO
    </div>
    <div   class="col-1">
        SITUAÇÃO
    </div>
    <div   class="col-1">
        PAGAMENTO
    </div>
</div>

@foreach ($proposals as $proposal)
<div class="row table2 position-relative"  style="
     color: {{$principalColor}};
     border-left-color: {{$complementaryColor}}
     ">
    <a class="stretched-link "href=" {{route('proposal.show', ['proposal' => $proposal,  'type' => $type])}}">
    </a>
    <div class="cel col-3 justify-content-start">
        @if($proposal->name)
        {{$proposal->name}}
        @else
        Sem nome
        @endif
    </div>
    <div class="cel col-2">
        @if($proposal->contact)
        {{$proposal->contact->name}}
        @else
        não possui
        @endif
    </div>
    <div class="cel col-2">
        @if(isset($proposal->company))
        {{$proposal->company->name}}
        @else
        não possui
        @endif
    </div>
    @if($proposal->status == 'aprovada' AND $proposal->pay_day < date('Y-m-d'))
    <div class="cel col-1" style="color: red">
        {{date('d/m/Y', strtotime($proposal->pay_day))}}
    </div>
    @else
    <div class="cel col-1">
        {{date('d/m/Y', strtotime($proposal->pay_day))}}
    </div>
    @endif

    @if($proposal->totalPrice > 0)
    <div class="cel col-1 justify-content-end">
        {{formatCurrencyReal($proposal->totalPrice)}}
    </div>
    @else
    <div class="cel col-1 justify-content-end" style="color: red">
        {{formatCurrencyReal($proposal->totalPrice)}}
    </div>
    @endif

    @if($proposal->paid > 0)
    <div class="cel col-1 justify-content-end">
        {{formatCurrencyReal($proposal->balance)}}
    </div>
    @else
    <div class="cel col-1 justify-content-end" style="color: red">
        {{formatCurrencyReal($proposal->balance)}}
    </div>
    @endif

    {{formatInvoiceStatus($proposal)}}

    <div class="cel col-1">
        {{faiconInvoiceStatus($proposal->status)}}
    </div>

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