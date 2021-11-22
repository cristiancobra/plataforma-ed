@extends('layouts/index')

@section('title',$title)

@section('image-top')
{{asset('images/financeiro.png')}} 
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonTrashIndex($trashStatus, 'opportunity')}}

{{createButtonCreate('opportunity', 'department',  $department)}}
@endsection



@section('filter')
<form id="filter" action="{{route('opportunity.index')}}" method="get" style="text-align: right;display:none">
    @csrf
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todos os contatos')}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
        {{createSelectUsers('select', $users, 'Todos os usuários')}}
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
@if($department == 'desenvolvimento')
@else
<div class='col shortcut prospecting'>
    <a style='text-decoration:none' href='{{route('opportunity.index', [
                                                                                                            'stage' =>'prospecção',
                                                                                                            'status' =>'ativo'
                                                                                                               ])}}'>
        <h2>
            {{$totalProspection}}
        </h2>
        <h3>
            prospecções
        </h3>
    </a>
</div>
<div class='col shortcut presentation'>
    <a style='text-decoration:none' href='{{route('opportunity.index', [
                                                                                                            'stage' =>'apresentação',
                                                                                                            'status' =>'ativo'
                                                                                                            ])}}'>
        <h2>
            {{$totalPresentation}}
        </h2>
        <h3>
            apresentações
        </h3>
    </a>
</div>

<div class='col shortcut proposal'>
    <a style='text-decoration:none' href='{{route('opportunity.index', [
                                                                                                            'stage' =>'proposta',
                                                                                                            'status' =>'ativo'
                                                                                                            ])}}'>
        <h2>
            {{$totalProposal}}
        </h2>
        <h3>
            propostas
        </h3>
    </a>
</div>

<div class='col shortcut contract'>
    <a style='text-decoration:none' href='{{route('opportunity.index',  [
                                                                                                            'stage' =>'contrato',
                                                                                                            'status' =>'ativo'
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
                                                                                                            'status' =>'ativo'
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
                                                                                                            'status' =>'ativo'
                                                                                                            ])}}'>
        <h2>
            {{$totalProduction}}
        </h2>
        <h3>
            produção
        </h3>
    </a>
</div>
@endif
@endsection



@section('table')
<div class="row">
    <div class="tb tb-header-start col-4">
        NOME 
    </div>

    @if($department != 'desenvolvimento')
    <div class="tb tb-header col-2">
        CONTATO 
    </div>
    @else
    <div class="tb tb-header col-3">
        CONTATO 
    </div>
    @endif

    <div class="tb tb-header col-2">
        EMPRESA
    </div>
    <div class="tb tb-header col-1">
        RESPONSÁVEL 
    </div>
    <div class="tb tb-header col-1">
        CRIADO 
    </div>

    @if($department != 'desenvolvimento')
    <div class="tb tb-header col-1">
        ETAPA DA VENDA
    </div>
    @endif

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

    @if($department != 'desenvolvimento')
    <div class="tb col-2">
        @else
        <div class="tb col-3">    
            @endif
            @if(isset($opportunity->contact->name))
            {{$opportunity->contact->name}}
            @else
            Não possui
            @endif
        </div>

        @if(isset($opportunity->company->name))
        <div class="tb col-2">
            {{$opportunity->company->name}}
        </div>
        @else
        <div class="tb col-2">
            Pessoa física
        </div>
        @endif
        <div class="tb col-1">
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
        <div class="tb col-1">
            {{dateBr($opportunity->date_start)}}
        </div>

        @if($department != 'desenvolvimento')
        {{formatStage($opportunity)}}
        @endif

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