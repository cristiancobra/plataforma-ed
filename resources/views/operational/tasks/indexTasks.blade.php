@extends('layouts/index')

@section('title','TAREFAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonTrashIndex($trashStatus, 'task')}}
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonCreate('task')}}
@endsection


@section('filter')
<form id="filter" action="{{route('task.index')}}" method="get" style="text-align: right">
    <input type="text" name="name" placeholder="nome da tarefa" value="">
    {{createFilterSelect('department', 'select', $departments, 'Todos departamentos')}}
    {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todos os contatos')}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelectModels('user_id', 'select', $users, 'Todos os usuários')}}
    {{createFilterSelect('priority', 'select', $priorities, 'Todas as prioridades')}}
    {{createFilterSelect('status', 'select', $status, 'Todas as situações')}}
    <br>
    <a class="text-button secondary" href='{{route('task.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
@endsection


@section('shortcuts')
<div class='col-lg-3 d-inline-block tasks-my'>
    <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'contact_id' => '',
				'user_id' => Auth::user()->id,
				])}}'>
        <p class='panel-number'>
            {{$myTasksPendingAmount}}
        </p>
        <p class='panel-text'>
            minhas pendências
        </p>
    </a>
</div>
<div class='col-lg-3 d-inline-block tasks-toDo'>
    <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'priority' =>'emergência',
				'contact_id' => '',
				])}}'>
        <p class='panel-number'>
            {{$teamTasksEmergencyAmount}}
        </p>
        <p class='panel-text'>
            emergências equipe
        </p>
    </a>
</div>

<div class='col-lg-3 d-inline-block tasks-emergency'>
    <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
                                                                        'priority' =>'emergência',
				'contact_id' => '',
				'user_id' => Auth::user()->id,
				])}}'>
        <p class='panel-number'>
            {{$myTasksEmergencyAmount}}
        </p>
        <p class='panel-text'>
            minhas emergências
        </p>
    </a>
</div>
@endsection


@section('table')
<div class='row mt-2'>
    <div class='tb tb-header-start col-3'>
        NOME
    </div>
    <div class='tb tb-header col-2'>
        CONTATO
    </div>
    <div class='tb tb-header col-2'>
        EMPRESA
    </div>
    <div class='tb tb-header col-2'>
        RESPONSÁVEL
    </div>
    <div class='tb tb-header col-1'>
        PRAZO
    </div>
    <div class='tb tb-header col-1'>
        PRIORIDADE
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($tasks as $task)
<div class='row'>
    <div class='tb col-3 justify-content-start' style="font-weight: 600">
        <a class="white" href=" {{ route('task.show', ['task' => $task->id]) }}">
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        {{$task->name}}
    </div>
    <div class='tb col-2'>
        <a  class="white" href=" {{ route('contact.show', ['contact' => $task->contact_id]) }}">
            @if(isset($task->contact->name))
            {{$task->contact->name}}
            @else
            contato excluído
            @endif
        </a>
    </div>
    <div class='tb col-2'>
        @if(isset($task->company->name))
        {{$task->company->name}}
        @else
        não possui
        @endif
    </div>
    <div class='tb col-2'>
        @if(isset($task->user->image))
        <div class='profile-picture-small'>
            <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
                <img src='{{asset($task->user->image->path)}}' width='100%' height='100%'>
            </a>
        </div>
        @elseif(isset($task->user->contact->name))
        <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
            {{$task->user->contact->name}}
        </a>
        @else
        funcionário excluído
        @endif
    </div>

    {{formatDateDue($task)}}
    
    {{formatPriority($task)}}

    {{formatStatus($task)}}

</div>
@endforeach
@endsection

@section('paginate', $tasks->links())

@section('js-scripts')
@endsection