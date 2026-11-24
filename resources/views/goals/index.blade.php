@extends('layouts/index')

@section('title', 'METAS')

@section('image-top')
    <i class="fa fa-tasks"></i>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'goal'" />
    <x-buttons.create model="goal" />
@endsection


@section('filter')
    <x-table.filter :action="route('goal.index')" :reset-url="route('goal.index')" :total-filtered="$goals->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome da meta" />
        <x-filter.select name="department" :options="$departments" placeholder="Todos os departamentos" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('shortcuts')
    <x-shortcut :href="route('goal.index', ['department' => 'desenvolvimento'])" label="desenvolvimento" />
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-4'],
        ['label' => 'DEPARTAMENTO', 'class' => 'col-2'],
        ['label' => 'INÍCIO', 'class' => 'col-1'],
        ['label' => 'FIM', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-4'],
    ]" />
    @foreach ($goals as $goal)
        <div data-href="{{ route('goal.show', ['goal' => $goal->id]) }}" class='row row-link'>
            <div class='tb col-4 justify-content-start' style="font-weight: 600">
                
                {{ $goal->name }}
            </div>
            <div class='tb col-2'>
                {{ $goal->department }}
            </div>
            <div class='tb col-1'>
                {{ date('d/m/Y', strtotime($goal->date_start)) }}
            </div>
            <div class='tb col-1'>
                {{ date('d/m/Y', strtotime($goal->date_due)) }}
            </div>
            <div class='tb col-4'>
                {{ $goal->result }}
            </div>


        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">{{ $goals->appends(request()->query())->links() }}</div>
@endsection

@section('js-scripts')
@endsection
