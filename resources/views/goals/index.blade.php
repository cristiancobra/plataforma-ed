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
    <div class='col-3 shortcut prospecting'>
        <a style='text-decoration:none' href='{{ route('goal.index', ['department' => 'desenvolvimento']) }}'>
            <h2>

            </h2>
            <h3>
                DESENVOLVIMENTO
            </h3>
        </a>
    </div>

@endsection


@section('table')
    <div class='row mt-5'>
        <div class='tb tb-header-start col-4'>
            NOME
        </div>
        <div class='tb tb-header col-2'>
            DEPARTAMENTO
        </div>
        <div class='tb tb-header col-1'>
            INÍCIO
        </div>
        <div class='tb tb-header col-1'>
            FIM
        </div>
        <div class='tb tb-header col-4'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($goals as $goal)
        <div class='row'>
            <div class='tb col-4 justify-content-start' style="font-weight: 600">
                <a class="white" href=" {{ route('goal.show', ['goal' => $goal->id]) }}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
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
