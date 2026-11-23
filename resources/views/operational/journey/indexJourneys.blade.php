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
    <table class="table-list">
        <tr>
            <td class="table-list-header" style="width: 20%">
                DATA
            </td>
            <td class="table-list-header" style="width: 35%">
                TAREFA
            </td>
            <td class="table-list-header" style="width: 15%">
                RESPONSÁVEL
            </td>
            <td class="table-list-header" style="width: 5%">
                INÍCIO
            </td>
            <td class="table-list-header" style="width: 5%">
                TÉRMINO
            </td>
            <td class="table-list-header" style="width: 5%">
                DURAÇÃO
            </td>
        </tr>

        @foreach ($journeys as $journey)
            <tr style="font-size: 14px">
                <td class="table-list-left">
                    <a href=" {{ route('journey.show', ['journey' => $journey]) }}">
                        <button class="button-round">
                            <i class='fa fa-eye' style="color:white"></i>
                        </button>
                        {{ date('d/m/Y', strtotime($journey->start)) }}
                    </a>
                </td>
                <td class="table-list-left">
                    @if ($journey->task)
                        <a class="white" href=" {{ route('task.show', ['task' => $journey->task_id]) }}">
                            {{ $journey->task->name }}
                        </a>
                    @else
                        tarefa excluída
                    @endif
                </td>
                <td class="table-list-center">
                    {{ $journey->user->contact->name }}
                </td>
                <td class="table-list-center">
                    {{ date('H:i', strtotime($journey->start)) }}
                </td>
                <td class="table-list-center">
                    @if ($journey->end == null)
                        --
                    @else
                        {{ date('H:i', strtotime($journey->end)) }}
                    @endif
                </td>
                <td class="table-list-center" style="color:white;background-color: #874983">
                    {{ gmdate('H:i', $journey->duration) }}
                </td>
            </tr>
        @endforeach
    </table>
    <p style="text-align: right">
        <br>
        {{ $journeys->links() }}
    </p>
    <br>
@endsection

@section('js-scripts')
@endsection
