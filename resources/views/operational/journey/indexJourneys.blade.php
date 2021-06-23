@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{asset('imagens/journey.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
<a class="circular-button primary"  href="{{route('journey.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div style="text-align:right">
    <form id="filter" action="{{route('journey.index')}}" method="get" style="text-align: right;display:none">
        <input type="text" name="name" placeholder="nome da tarefa" value="">
        <input type="date" name="date_start" size="20" value="{{old('date_start')}}">
        <input type="date" name="date_end" size="20" value="{{old('date_end')}}">
        {{createFilterSelectModels('user_id', 'select', $users, 'Todos os usuários')}}
        <br>
        <a class="text-button secondary" href='{{route('journey.index')}}'>
            LIMPAR
        </a>
        <input class="text-button primary" type="submit" value="FILTRAR">
    </form>
    <br>
</div>
<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 20%">
            DATA 
        </td>
        <td   class="table-list-header" style="width: 35%">
            TAREFA 
        </td>
        <td   class="table-list-header" style="width: 15%">
            RESPONSÁVEL 
        </td>
        <td   class="table-list-header" style="width: 5%">
            INÍCIO 
        </td>
        <td   class="table-list-header" style="width: 5%">
            TÉRMINO 
        </td>
        <td   class="table-list-header" style="width: 5%">
            DURAÇÃO 
        </td>
    </tr>

    @foreach ($journeys as $journey)
    <tr style="font-size: 14px">
        <td class="table-list-left">
            <a href=" {{route('journey.show', ['journey' => $journey])}}">
                <button class="button-round">
                    <i class='fa fa-eye' style="color:white"></i>
                </button>
            {{date('d/m/Y', strtotime($journey->date))}}
            </a>
        </td>
        <td class="table-list-left">
            <a class="white" href=" {{route('task.show', ['task' => $journey->task_id])}}">
                {{$journey->task->name}}
            </a>
        </td>
        <td class="table-list-center">
            {{$journey->user->contact->name}}
        </td>
        <td class="table-list-center">
            {{date('H:i', strtotime($journey->start))}}
        </td>
        <td class="table-list-center">
            @if($journey->end == null)
            --
            @else
            {{date('H:i', strtotime($journey->end))}}
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
<script>
    $(document).ready(function () {
        //botao de exibir filtro
        $("#filter_button").click(function () {
            $("#filter").slideToggle(600);
        });

    });
</script>
@endsection