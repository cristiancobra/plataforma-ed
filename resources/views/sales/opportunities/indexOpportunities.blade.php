@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{asset('imagens/financeiro.png')}} 
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
<a class="circular-button primary"  href="{{route('opportunity.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<form id="filter" action="{{route('opportunity.filter')}}" method="post" style="text-align: right;display:none">
    @csrf
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    {{createFilterSelectModels('account_id', 'select', $accounts, 'Minhas empresas')}}
    {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todos os contatos')}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelectModels('user_id', 'select', $users, 'Todos os usuários')}}
    {{createFilterSelect('stage', 'select', returnOpportunitiesStage(), 'Todas as etapas')}}
    <br>
    <a class="button-secondary" href='{{route('opportunity.index')}}'>
        LIMPAR
    </a>
    <input class="button-secondary" type="submit" value="FILTRAR">
</form>
<br>
<table class="table-list">
    <tr>
        <td class="table-list-header" style="width: 35%">
            NOME 
        </td>
        <td class="table-list-header" style="width: 15%">
            CONTATO 
        </td>
        <td class="table-list-header" style="width: 20%">
            EMPRESA
        </td>
        <td class="table-list-header" style="width: 17%">
            RESPONSÁVEL 
        </td>
        <td class="table-list-header" style="width: 5%">
            PRÓXIMO CONTATO
        </td>
        <td   class="table-list-header" style="width: 8%">
            ETAPA DA VENDA
        </td>
    </tr>

    @foreach ($opportunities as $opportunity)
    <tr>
        <td class="table-list-left">
            <button class="button-round">
                <a href=" {{route('opportunity.show', ['opportunity' => $opportunity])}}">
                    <i class='fa fa-eye' style="color:white"></i>
                </a>
            </button>
            {{$opportunity->name}}
        </td>
        @if(isset($opportunity->contact->name))
        <td class="table-list-center">
            {{$opportunity->contact->name}}
        </td>
        @else
        <td class="table-list-center">
            Não possui
        </td>
        @endif
        @if(isset($opportunity->company->name))
        <td class="table-list-center">
            {{$opportunity->company->name}}
        </td>
        @else
        <td class="table-list-center">
            Pessoa física
        </td>
        @endif
        <td class="table-list-center">
            {{$opportunity->user->contact->name}}
        </td>
        <td class="table-list-center">
            @if($opportunity->date_conclusion == date('Y-m-d'))
            hoje
            @elseif($opportunity->stage != 'ganhamos' AND $opportunity->stage != 'perdemos' AND $opportunity->date_conclusion <= date('Y-m-d'))
            <p style="color: red">
                {{dateBr($opportunity->date_conclusion)}}
            </p>
            @else
            {{dateBr($opportunity->date_conclusion)}}
            @endif
        </td>
        {{formatStage($opportunity)}}
    </tr>
    @endforeach
</table>
<p style="text-align: right">
    <br>
    {{$opportunities->links()}}
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