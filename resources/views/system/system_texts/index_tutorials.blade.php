@extends('layouts/index')

@section('title', 'TUTORIAIS')

@section('image-top')
    <i class="fas fa-rocket"></i>
@endsection

@section('buttons')
    <x-buttons.create model="systemText" />
@endsection


@section('filter')
    <x-table.filter :action="route('systemText.index')" :reset-url="route('systemText.index')" :total-filtered="$tutorials->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome" />
        <x-filter.select name="department" :options="$departments" placeholder="Todos os departamentos" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('shortcuts')
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-5'],
        ['label' => 'TÍTULO', 'class' => 'col-5'],
        ['label' => 'TIPO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($tutorials as $tutorial)
        <div data-href="{{ route('systemText.showTutorial', ['systemText' => $tutorial->id]) }}" class='row row-link'>
            <div class='tb col-5 justify-content-start' style="font-weight: 600">
                
                {{ $tutorial->name }}
            </div>
            <div class='tb col-5'>
                {{ $tutorial->title }}
            </div>

            {{ formatType($tutorial) }}

            {{ formatStatus($tutorial) }}

        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">{{ $tutorials->appends(request()->query())->links() }}</div>
@endsection

@section('js-scripts')
@endsection
