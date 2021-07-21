@extends('layouts/index')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/page.png')}}
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
    <div class='tb tb-header-start col-3'>
        NOME
    </div>
    <div class='tb tb-header col-3'>
        ENDEREÇO
    </div>
</div>
@foreach ($pages as $page)
<div class='row'>
    <div class='tb col-3 justify-content-start' style="font-weight: 600">
        <a class="white" href=" {{route('page.show', ['page' => $page->id])}}" target='_blank'>
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        <a class="white" href=" {{route('page.edit', ['page' => $page->id])}}">
            <button class="button-round">
                <i class='fa fa-edit'></i>
            </button>
        </a>
        {{$page->name}}
    </div>
        {{$page->url}}
    </div>
</div>
@endforeach
@endsection



@section('js-scripts')
@endsection