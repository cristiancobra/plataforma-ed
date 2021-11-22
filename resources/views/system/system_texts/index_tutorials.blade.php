@extends('layouts/index')

@section('title','TUTORIAIS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonCreate('systemText')}}
@endsection


@section('filter')
<form id="filter" action="{{route('systemText.index')}}" method="get" style="text-align: right">
    <input type="text" name="name" placeholder="nome da tarefa" value="">
    {{createFilterSelect('department', 'select', $departments, 'Todos departamentos')}}
    {{createFilterSelect('status', 'select', $status, 'Todas as situações')}}
    <br>
    <a class="text-button secondary" href='{{route('systemText.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
@endsection


@section('shortcuts')
@endsection


@section('table')
<div class='row mt-2'>
    <div class='tb tb-header-start col-5'>
        NOME
    </div>
    <div class='tb tb-header col-5'>
        TÍTULO
    </div>
    <div class='tb tb-header col-1'>
        TIPO
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($tutorials as $tutorial)
<div class='row'>
    <div class='tb col-5 justify-content-start' style="font-weight: 600">
        <a class="white" href=" {{ route('systemText.show', ['systemText' => $tutorial->id]) }}">
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        {{$tutorial->name}}
    </div>
    <div class='tb col-5'>
        {{$tutorial->title}}
    </div>

    {{formatType($tutorial)}}

    {{formatStatus($tutorial)}}

</div>
@endforeach
@endsection

@section('paginate', $tutorials->links())

@section('js-scripts')
@endsection