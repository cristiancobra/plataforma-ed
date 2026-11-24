@extends('layouts/index')

@section('title', 'JORNADAS')

@section('image-top')
    <i class="fa fa-coffee"></i>
@endsection


@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'journey'" />
    <x-buttons.create model="journey" />
@endsection

@section('filter')
    <x-table.filter :action="route('journey.index')" :reset-url="route('journey.index')" :total-filtered="$journeys->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome da tarefa" />
        <x-filter.input name="start" type="date" title="Data inicial" />
        <x-filter.input name="end" type="date" title="Data final" />
        <x-filter.select name="department" :options="$departments" placeholder="Todos os departamentos" />
        <x-filter.select name="user_id" :options="$users->mapWithKeys(fn ($u) => [$u->id => optional($u->contact)->name])->all()" placeholder="Todos os usuários" />
    </x-table.filter>
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'DATA', 'class' => 'col-2'],
        ['label' => 'TAREFA', 'class' => 'col-4'],
        ['label' => 'RESPONSÁVEL', 'class' => 'col-2'],
        ['label' => 'INÍCIO', 'class' => 'col-1'],
        ['label' => 'TÉRMINO', 'class' => 'col-1'],
        ['label' => 'DURAÇÃO', 'class' => 'col-2'],
    ]" />
    @foreach ($journeys as $journey)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('journey.show', ['journey' => $journey]) }}">
            <div class="col-2 fw-bold small">{{ dateBr($journey->start) }}</div>
            <div class="col-4 small">
                @if ($journey->task)
                    <a href="{{ route('task.show', ['task' => $journey->task_id]) }}" onclick="event.stopPropagation()">{{ $journey->task->name }}</a>
                @else
                    tarefa excluída
                @endif
            </div>
            <div class="col-2 text-center small">{{ $journey->user->contact->name }}</div>
            <div class="col-1 text-center small">{{ date('H:i', strtotime($journey->start)) }}</div>
            <div class="col-1 text-center small">{{ $journey->end == null ? '--' : date('H:i', strtotime($journey->end)) }}</div>
            <div class="col-2 text-center small fw-bold">{{ gmdate('H:i', $journey->duration) }}</div>
        </div>
    @endforeach
@endsection

@section('paginate', $journeys->links())


@section('js-scripts')
@endsection
