@extends('layouts/index')

@section('title', 'TAREFAS')

@section('image-top')
    <i class="fa fa-tasks"></i>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'task'" />
    <x-buttons.create model="task" />
@endsection


@section('shortcuts')
    <div class='col-lg-3 d-inline-block tasks-my'>
        <a style='text-decoration:none'
            href='{{ route('task.index', [
                'status' => 'fazer',
                'contact_id' => '',
                'user_id' => Auth::user()->id,
            ]) }}'>
            <p class='panel-number'>
                {{ $myTasksPendingAmount }}
            </p>
            <p class='panel-text'>
                minhas pendências
            </p>
        </a>
    </div>
    <div class='col-lg-3 d-inline-block tasks-toDo'>
        <a style='text-decoration:none'
            href='{{ route('task.index', [
                'status' => 'fazer',
                'priority' => 'emergência',
                'contact_id' => '',
            ]) }}'>
            <p class='panel-number'>
                {{ $teamTasksEmergencyAmount }}
            </p>
            <p class='panel-text'>
                emergências equipe
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block tasks-emergency'>
        <a style='text-decoration:none'
            href='{{ route('task.index', [
                'status' => 'fazer',
                'priority' => 'emergência',
                'contact_id' => '',
                'user_id' => Auth::user()->id,
            ]) }}'>
            <p class='panel-number'>
                {{ $myTasksEmergencyAmount }}
            </p>
            <p class='panel-text'>
                minhas emergências
            </p>
        </a>
    </div>
@endsection



@section('filter')
    <form id="filter" action="{{ route('task.index') }}" method="get" class="mb-4">
        <div class="row g-2 align-items-end p-3 mb-4 shadow-sm rounded" style="border-color: {{ $oppositeColor }};">
            <div class="col-md-3 col-12 mb-2 mb-md-0">
                <input class="form-control" type="text" name="name" placeholder="Filtrar por nome" value="">
            </div>
            <div class="col-md-7 col-12 mb-2 mb-md-0 d-flex flex-wrap gap-2">
                <div class="flex-fill">{{ createFilterSelect('department', 'select', $departments, 'departamento') }}</div>
                <div class="flex-fill">{{ createFilterSelectModels('contact_id', 'select', $contacts, 'contato') }}</div>
                <div class="flex-fill">{{ createFilterSelectModels('company_id', 'select', $companies, 'empresa') }}</div>
                <div class="flex-fill">{{ createSelectUsers('select', $users, 'usuário') }}</div>
                <div class="flex-fill">{{ createFilterSelect('priority', 'select', $priorities, 'prioridade') }}</div>
                <div class="flex-fill">{{ createFilterSelect('status', 'select', $status, 'situação') }}</div>
            </div>
            <div class="col-md-2 col-12 d-flex gap-2 justify-content-md-end justify-content-start mt-2 mt-md-0">
                <a class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                    title="Remover filtros" href="{{ route('task.index') }}">
                    <i class="fa fa-ban" aria-hidden="true"></i>
                </a>
                <button class="btn btn-primary d-flex align-items-center justify-content-center" type="submit"
                    title="Aplicar filtros" value="FILTRAR">
                    <i class="fa fa-filter" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </form>
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" class="mt-2 mb-2" :columns="[
        ['label' => 'RESPONSÁVEL', 'class' => 'col-1'],
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'CONTATO', 'class' => 'col-2'],
        ['label' => 'ORGANIZAÇÃO', 'class' => 'col-2'],
        ['label' => 'PRAZO', 'class' => 'col-1'],
        ['label' => 'PRIORIDADE', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
        ['label' => 'VER', 'class' => 'col-1'],
    ]" />
    @foreach ($tasks as $task)
        <div class="row table2 position-relative mt-3"
            style="
     color: {{ $principalColor }};
     border-left-color: {{ $complementaryColor }}
     ">
            <div class='col-1 text-center'>
                <x-user.avatar :user="$task->user" />
            </div>
            <div class='col-3 justify-content-start' style="font-weight: 600">
                {{ $task->name }}
            </div>
            <div class='col-2 text-center'>
                @if ($task->contact)
                    {{ $task->contact->name }}
                @else
                    contato excluído
                @endif
            </div>
            <div class='col-2 text-center'>
                @if ($task->company)
                    {{ $task->company->name }}
                @else
                    não possui
                @endif
            </div>

            {{ formatDateDue($task) }}

            {{ formatPriority($task) }}

            {{ formatStatus($task) }}

            <div class="col-1 d-flex align-items-center justify-content-center pe-4">
                <x-buttons.details :href="route('task.show', ['task' => $task])" title="Visualizar tarefa" :color="$principalColor" :size="36" />
            </div>
        </div>
    @endforeach
@endsection

@section('paginate', $tasks->links())
