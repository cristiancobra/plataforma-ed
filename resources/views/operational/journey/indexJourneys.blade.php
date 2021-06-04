@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{ asset('imagens/journey.png') }} 
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
    <form id="filter" action="{{route('journey.filter')}}" method="post" style="text-align: right;display:none">
        @csrf
        <input type="text" name="name" placeholder="nome da tarefa" value="">
        <input type="date" name="date_start" size="20" value="{{old('date_start')}}"><span class="fields"></span>
        <input type="date" name="date_end" size="20" value="{{old('date_end')}}"><span class="fields"></span>
        {{createFilterSelectModels('account_id', 'select', $accounts, 'Minhas empresas')}}
        {{createFilterSelect('department', 'select', returnDepartments(), 'Todos os departamentos')}}
        {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todos os contatos')}}
        {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
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
            <button class="button-round">
                <a href=" {{ route('journey.show', ['journey' => $journey]) }}">
                    <i class='fa fa-eye' style="color:white"></i></a>
            </button>
            <button class="button-round">
                <a href=" {{ route('journey.edit', ['journey' => $journey]) }}">
                    <i class='fa fa-edit' style="color:white"></i></a>
            </button>
            {{date('d/m/Y', strtotime($journey->date))}}
        </td>
        <td class="table-list-left">
            <button class="button-round">
                <a href=" {{ route('task.show', ['task' => $journey->task_id]) }}">
                    <i class='fa fa-eye' style="color:white"></i></a>
            </button>
            @isset($journey->task)
            {{$journey->task->name}}
            @endisset

        </td>
        <td class="table-list-center">
            {{$journey->user->contact->name}}
        </td>
        <td class="table-list-center">
            {{date('H:i', strtotime($journey->start_time))}}
        </td>
        <td class="table-list-center">
            @if($journey->end_time == null)
            --
            @else
            {{date('H:i', strtotime($journey->end_time))}}
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