@extends('layouts/index')

@section('title', 'PÁGINAS')

@section('image-top')
    <i class="fas fa-window-maximize"></i>
@endsection

@section('buttons')
    {{ createButtonFilter() }}
    <x-buttons.create model="page" :principalColor="$principalColor ?? null" />
@endsection


@section('filter')
@endsection


@section('shortcuts')
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'ENDEREÇO', 'class' => 'col-3'],
        ['label' => 'LINK', 'class' => 'col-4'],
        ['label' => 'CADASTROS', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($pages as $page)
        <div class='row'>
            <div class='tb col-3 justify-content-start' style="font-weight: 600">
                <a class="white" href="{{ route('page.public', ['page' => $page]) }}" target='_blank'>
                    <button class="button-round me-1">
                        <i class="fa fa-eye"></i>
                    </button>
                </a>
                <a class="white" href="{{ route('page.edit', ['page' => $page]) }}">
                    <button class="button-round me-2">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{ $page->name }}
            </div>
            <div class='tb col-3'>
                {{ $page->url }}
            </div>
            <div class='tb col-4 text-center'>
                https://{{ $page->url }}/paginas/public/redirect/{{ $page->id }}
            </div>
            <div class='tb col-1'>
                <a class="white" href="{{ route('contact.index', ['page_id' => $page->id]) }}">
                    {{ $page->contacts()->count() }}
                </a>
            </div>
            {{ formatStatus($page) }}
        </div>
    @endforeach
@endsection



@section('js-scripts')
@endsection
