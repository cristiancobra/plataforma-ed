@extends('layouts/index')

@section('title','METAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonTrashIndex($trashStatus, 'goal')}}
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonCreate('goal')}}
@endsection


@section('filter')
<form id="filter" action="{{route('goal.index')}}" method="get" style="text-align: right">
    <input type="text" name="name" placeholder="nome da tarefa" value="">
    {{createFilterSelect('department', 'select', $departments, 'Todos departamentos')}}
    {{createFilterSelect('status', 'select', $status, 'Todas as situações')}}
    <br>
    <a class="text-button secondary" href='{{route('goal.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
@endsection


@section('shortcuts')
<div class='col-3 shortcut prospecting'>
    <a style='text-decoration:none' href='{{route('goal.index', ['department' =>'desenvolvimento'])}}'>
        <h2>

        </h2>
        <h3>
            DESENVOLVIMENTO
        </h3>
    </a>
</div>

@endsection


@section('table')
<div class='row mt-2'>
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
        {{$goal->name}}
    </div>
    <div class='tb col-2'>
        {{$goal->department}}
    </div>
    <div class='tb col-1'>
    {{date('d/m/Y', strtotime($goal->date_start))}}
    </div>
    <div class='tb col-1'>
    {{date('d/m/Y', strtotime($goal->date_due))}}
    </div>
    <div class='tb col-4'>
    {{$goal->result}}
    </div>


</div>
@endforeach
@endsection

@section('paginate', $goals->links())

@section('js-scripts')
@endsection