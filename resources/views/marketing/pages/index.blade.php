@extends('layouts/index')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/site.png')}}
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
<a class="circular-button primary"  href="{{route('page.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection


@section('filter')
@endsection


@section('shortcuts')
@endsection


@section('table')
<div class='row mt-2'>
    <div class='tb tb-header-start col-4'>
        NOME
    </div>
    <div class='tb tb-header col-3'>
        ENDEREÇO
    </div>
    <div class='tb tb-header col-3'>
        MODELO
    </div>
    <div class='tb tb-header-end col-2'>
        SITUAÇÃO
    </div>
</div>
@foreach ($pages as $page)
<div class='row'>
    <div class='tb col-4 justify-content-start' style="font-weight: 600">
        <a class="white" href="{{route('page.public', ['page' => $page])}}" target='_blank'>
            <button class="button-round me-1">
                <i class="fa fa-eye"></i>
            </button>
        </a>
        <a class="white" href="{{route('page.edit', ['page' => $page])}}">
            <button class="button-round me-2">
                <i class='fa fa-edit'></i>
            </button>
        </a>
        {{$page->name}}
    </div>
    <div class='tb col-3'>
        {{$page->url}}
    </div>
    <div class='tb col-3'>
        {{$page->template}}
    </div>
    <div class='tb col-2'>
        {{$page->status}}
    </div>
</div>
@endforeach
@endsection



@section('js-scripts')
@endsection