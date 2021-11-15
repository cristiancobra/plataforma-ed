@extends('layouts/index')

@section('title',$title)

@section('image-top')
{{asset('images/financeiro.png')}} 
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonTrashIndex($trashStatus, 'project')}}
{{createButtonBack()}}
{{createButtonCreate('project')}}
@endsection



@section('filter')
<form id="filter" action="{{route('project.index')}}" method="get" style="text-align: right;display:none">
    @csrf
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todos os contatos')}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelectModels('user_id', 'select', $users, 'Todos os usuários')}}
    {{createFilterSelect('status', 'select', $status, 'Todas as situações')}}
    <br>
    <a class="btn btn-secondary" href='{{route('project.index')}}'>
        LIMPAR
    </a>
    <input class="btn btn-primary" type="submit" value="FILTRAR">
</form>
@endsection


@section('shortcuts')
@if(1 > 2)
<div class='col shortcut prospecting'>
    <a style='text-decoration:none' href='{{route('project.index', [
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
    <a style='text-decoration:none' href='{{route('project.index', [
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
    <a style='text-decoration:none' href='{{route('project.index', [
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
    <a style='text-decoration:none' href='{{route('project.index',  [
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
    <a style='text-decoration:none' href='{{route('project.index', [
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
    <a style='text-decoration:none' href='{{route('project.index', [
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
    <div class="tb tb-header col-3">
        META 
    </div>
    <div class="tb tb-header col-2">
        EMPRESA
    </div>
    <div class="tb tb-header col-1">
        RESPONSÁVEL 
    </div>
    <div class="tb tb-header col-1">
        CRIADO 
    </div>
    <div class="tb tb-header-end col-1">
        SITUAÇÃO
    </div>
</div>

@foreach ($projects as $project)
<div class="row">
    <div class="tb col-4 justify-content-start">
        <button class="button-round">
            <a href=" {{route('project.show', ['project' => $project])}}">
                <i class='fa fa-eye' style="color:white"></i>
            </a>
        </button>
        {{$project->name}}
    </div>

        <div class="tb col-3">    
            @if(isset($project->goal))
            {{$project->goal->name}}
            @else
            Não possui
            @endif
        </div>

        @if(isset($project->company->name))
        <div class="tb col-2">
            {{$project->company->name}}
        </div>
        @else
        <div class="tb col-2">
            Pessoa física
        </div>
        @endif
        <div class="tb col-1">
            @if(isset($project->user->image))
            <div class='profile-picture-small'>
                <a  class='white' href=' {{route('user.show', ['user' => $project->user->id])}}'>
                    <img src='{{asset($project->user->image->path)}}' width='100%' height='100%'>
                </a>
            </div>
            @elseif(isset($project->user->contact->name))
            <a  class='white' href=' {{route('user.show', ['user' => $project->user->id])}}'>
                {{$project->user->contact->name}}
            </a>
            @else
            funcionário excluído
            @endif
        </div>
        <div class="tb col-1">
            {{dateBr($project->date_start)}}
        </div>

        {{formatStatus($project)}}
    </div>
    @endforeach
    @endsection


    @section('paginate', $projects->links())


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