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
    <x-shortcut :href="route('task.index', ['status' => 'fazer', 'contact_id' => '', 'user_id' => Auth::user()->id])"
        :number="$myTasksPendingAmount" label="minhas pendências" />
    <x-shortcut :href="route('task.index', ['status' => 'fazer', 'priority' => 'emergência', 'contact_id' => ''])"
        :number="$teamTasksEmergencyAmount" label="emergências equipe" />
    <x-shortcut :href="route('task.index', ['status' => 'fazer', 'priority' => 'emergência', 'contact_id' => '', 'user_id' => Auth::user()->id])"
        :number="$myTasksEmergencyAmount" label="minhas emergências" />
@endsection



@section('filter')
    <x-table.filter :action="route('task.index')" :reset-url="route('task.index')" :total-filtered="$tasks->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome da tarefa" />
        <x-filter.select name="department" :options="$departments" placeholder="Todos os departamentos" />
        <x-filter.select name="contact_id" :options="$contacts->pluck('name', 'id')->all()" placeholder="Todos os contatos" />
        <x-filter.select name="company_id" :options="$companies->pluck('name', 'id')->all()" placeholder="Todas as organizações" />
        <x-filter.select name="user_id" :options="$users->mapWithKeys(fn ($u) => [$u->id => optional($u->contact)->name])->all()" placeholder="Todos os usuários" />
        <x-filter.select name="priority" :options="$priorities" placeholder="Todas as prioridades" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" class="mt-2 mb-2" :columns="[
        ['label' => 'RESPONSÁVEL', 'class' => 'col-1'],
        ['label' => 'NOME', 'class' => 'col-4'],
        ['label' => 'CONTATO', 'class' => 'col-2'],
        ['label' => 'ORGANIZAÇÃO', 'class' => 'col-2'],
        ['label' => 'PRAZO', 'class' => 'col-1'],
        ['label' => 'PRIORIDADE', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($tasks as $task)
        <div class="row row-link table2 position-relative mt-3" data-href="{{ route('task.show', ['task' => $task]) }}"
            style="
     color: {{ $principalColor }};
     border-left-color: {{ $complementaryColor }}
     ">
            <div class='col-1 text-center'>
                <x-user.avatar :user="$task->user" />
            </div>
            <div class='col-4 justify-content-start' style="font-weight: 600">
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

        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">{{ $tasks->appends(request()->query())->links() }}</div>
@endsection
