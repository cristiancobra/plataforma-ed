@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{asset('imagens/tarefas.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
<a class="circular-button primary"  href="{{route('task.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<form id="filter" action="{{route('task.filter')}}" method="post" style="text-align: right;display:none">
    @csrf
    <input type="text" name="name" placeholder="nome da tarefa" value="">
    {{createFilterSelectModels('account_id', 'select', $accounts, 'Minhas empresas')}}
    {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todos os contatos')}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelectModels('user_id', 'select', $users, 'Todos os usuários')}}
    {{createFilterSelect('stage', 'select', returnStatus(), 'Todas as situações')}}
    <br>
    <a class="text-button secondary" href='{{route('task.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
<br>
<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 25%">
            NOME
        </td>
        <td   class="table-list-header" style="width: 15%">
            CONTATO
        </td>
        <td   class="table-list-header" style="width: 15%">
            EMPRESA
        </td>
        <td   class="table-list-header" style="width: 15%">
            CONTA
        </td>
        <td   class="table-list-header" style="width: 10%">
            RESPONSÁVEL
        </td>
        <td   class="table-list-header" style="width: 10%">
            PRAZO
        </td>
        <td   class="table-list-header" style="width: 5%">
            PRIORIDADE
        </td>
        <td   class="table-list-header" style="width: 5%">
            SITUAÇÃO
        </td>
    </tr>

    @foreach ($tasks as $task)
    <tr style="font-size: 14px">
        <td class="table-list-left">
            <a class="white" href=" {{ route('task.show', ['task' => $task->id]) }}">
                <button class="button-round">
                    <i class='fa fa-eye'></i>
                </button>
            </a>
            <a href=" {{ route('task.edit', ['task' => $task->id]) }}">
                <button class="button-round">
                    <i class='fa fa-edit'></i>
                </button>
            </a>
            {{$task->name}}
        </td>

        <td class="table-list-center">
            @if(isset($task->contact->name))
            {{$task->contact->name}}
            @else
            contato excluído
            @endif
        </td>
        <td class="table-list-center">
            @if(isset($task->company->name))
            {{$task->company->name}}
            @else
            não possui
            @endif
        </td>
        <td class="table-list-center">
            {{$task->account->name}}
        </td>
        <td class="table-list-center">
            @if($task->user->profile_picture)
            <div class='profile-picture-small'>
                <a  class='white' href=' {{route('user.show', ['user' =>$task->user->id])}}'>
                    <img src='{{asset($task->user->profile_picture)}}' width='100%' height='100%'>
                </a>
            </div>
            @elseif(isset($task->user->contact->name))
            {{$task->user->contact->name}}
            @else
            funcionário excluído
            @endif
        </td>	
        <td class="table-list-center">
            @if($task->date_due == date('Y-m-d'))
            hoje
            @elseif($task->status == 'fazer' AND $task->date_due <= date('Y-m-d'))
            <p style="color: red">
                {{dateBr($task->date_due)}}
            </p>
            @else
            {{dateBr($task->date_due)}}
            @endif
        </td>
        {{formatPriority($task)}}
        @if($task->status == 'fazer' AND $task->journeys()->exists())
        <td class="td-doing">
            fazendo
        </td>
        @else
        {{formatStatus($task)}}
        @endif
    </tr>
    @endforeach
</table>
<p style="text-align: right">
    <br>
    {{$tasks->links()}}
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