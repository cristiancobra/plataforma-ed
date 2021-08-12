@extends('layouts/index')

@section('title','OPORTUNIDADES')

@section('image-top')
{{asset('images/financeiro.png')}} 
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonTrashIndex($trashStatus, 'opportunity')}}
{{createButtonBack()}}
{{createButtonCreate('opportunity')}}
@endsection



@section('filter')
<form id="filter" action="{{route('opportunity.index')}}" method="get" style="text-align: right;display:none">
    @csrf
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todos os contatos')}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelectModels('user_id', 'select', $users, 'Todos os usuários')}}
    {{createFilterSelect('stage', 'select', $stages, 'Todas as etapas')}}
    {{createFilterSelect('status', 'select', $status, 'Todas as situações')}}
    <br>
    <a class="btn btn-secondary" href='{{route('opportunity.index')}}'>
        LIMPAR
    </a>
    <input class="btn btn-primary" type="submit" value="FILTRAR">
</form>
@endsection


@section('shortcuts')
<div class='col shortcut prospecting'>
    <a style='text-decoration:none' href='{{route('opportunity.index', ['stage' =>'prospecção'])}}'>
        <h2>
            {{$totalProspection}}
        </h2>
        <h3>
            prospecções
        </h3>
    </a>
</div>
<div class='col shortcut presentation'>
    <a style='text-decoration:none' href='{{route('opportunity.index', ['stage' =>'apresentação'])}}'>
        <h2>
            {{$totalPresentation}}
        </h2>
        <h3>
            apresentações
        </h3>
    </a>
</div>

<div class='col shortcut proposal'>
    <a style='text-decoration:none' href='{{route('opportunity.index', ['stage' =>'proposta',])}}'>
        <h2>
            {{$totalProposal}}
        </h2>
        <h3>
            propostas
        </h3>
    </a>
</div>

<div class='col shortcut contract'>
    <a style='text-decoration:none' href='{{route('opportunity.index', [
				'stage' =>'contrato',
				])}}'>
        <h2>
            {{$totalContract}}
        </h2>
        <h3>
            contratos
        </h3>
    </a>
</div>

<div class='col shortcut bill'>
    <a style='text-decoration:none' href='{{route('opportunity.index', [
				'stage' =>'cobrança',
				])}}'>
        <h2>
            {{$totalBill}}
        </h2>
        <h3>
            cobrança
        </h3>
    </a>
</div>

<div class='col shortcut production'>
    <a style='text-decoration:none' href='{{route('opportunity.index', [
				'stage' =>'produção',
				])}}'>
        <h2>
            {{$totalProduction}}
        </h2>
        <h3>
            produção
        </h3>
    </a>
</div>
@endsection



@section('table')
<div class="row">
    <div class="tb tb-header-start col-4">
        NOME 
    </div>
    <div class="tb tb-header col-2">
        CONTATO 
    </div>
    <div class="tb tb-header col-2">
        EMPRESA
    </div>
    <div class="tb tb-header col-2">
        RESPONSÁVEL 
    </div>
    <div class="tb tb-header col-1">
        ETAPA DA VENDA
    </div>
    <div class="tb tb-header-end col-1">
        SITUAÇÃO
    </div>
</div>

@foreach ($opportunities as $opportunity)
<div class="row">
    <div class="tb col-4 justify-content-start">
        <button class="button-round">
            <a href=" {{route('opportunity.show', ['opportunity' => $opportunity])}}">
                <i class='fa fa-eye' style="color:white"></i>
            </a>
        </button>
        {{$opportunity->name}}
    </div>
    @if(isset($opportunity->contact->name))
    <div class="tb col-2">
        {{$opportunity->contact->name}}
    </div>
    @else
    <div class="tb col-2">
        Não possui
    </div>
    @endif
    @if(isset($opportunity->company->name))
    <div class="tb col-2">
        {{$opportunity->company->name}}
    </div>
    @else
    <div class="tb col-2">
        Pessoa física
    </div>
    @endif
    <div class="tb col-2">
        @if(isset($opportunity->user->image))
        <div class='profile-picture-small'>
            <a  class='white' href=' {{route('user.show', ['user' => $opportunity->user->id])}}'>
                <img src='{{asset($opportunity->user->image->path)}}' width='100%' height='100%'>
            </a>
        </div>
        @elseif(isset($opportunity->user->contact->name))
        <a  class='white' href=' {{route('user.show', ['user' => $opportunity->user->id])}}'>
            {{$opportunity->user->contact->name}}
        </a>
        @else
        funcionário excluído
        @endif
    </div>
    {{formatStage($opportunity)}}
    {{formatStatus($opportunity)}}
</div>
@endforeach
@endsection


@section('paginate', $opportunities->links())


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