@extends('layouts/index')

@section('title', 'TEXTOS DO SISTEMA')

@section('image-top')
    <i class="fas fa-rocket"></i>
@endsection

@section('buttons')
    <x-buttons.create model="systemText" />
@endsection


@section('filter')
    <x-table.filter :action="route('systemText.index')" :reset-url="route('systemText.index')" :total-filtered="$systemTexts->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome" />
        <x-filter.select name="department" :options="$departments" placeholder="Todos os departamentos" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('shortcuts')
    <x-shortcut :href="route('systemText.index', ['type' => 'primeiros passos'])" label="primeiros passos" />
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-5'],
        ['label' => 'TÍTULO', 'class' => 'col-5'],
        ['label' => 'TIPO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($systemTexts as $systemText)
        <div data-href="{{ route('systemText.show', ['systemText' => $systemText->id]) }}" class='row row-link'>
            <div class='tb col-5 justify-content-start' style="font-weight: 600">
                
                {{ $systemText->name }}
            </div>
            <div class='tb col-5'>
                {{ $systemText->title }}
            </div>

            {{ formatType($systemText) }}

            {{ formatStatus($systemText) }}

        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">{{ $systemTexts->appends(request()->query())->links() }}</div>
@endsection

@section('js-scripts')
@endsection
