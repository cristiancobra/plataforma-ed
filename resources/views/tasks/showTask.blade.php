@extends('layouts/show')

@section('title','TAREFAS')

@section('image-top')
{{asset('imagens/tarefas.png')}} 
@endsection

@section('description')
@endsection


@section('buttons')
<a class="circular-button secondary"  href="{{route('task.pdf', ['task' => $task])}}">
    <i class="fas fa-print"></i>
</a>
<a class="circular-button primary"  href="{{route('task.index')}}">
    <i class="fas fa-arrow-left"></i>
</a>
@endsection


@section('name', $task->name)


@section('priority')
{{formatShowPriority($task)}}
@endsection


@section('status')
@if($task->status == 'fazer' AND $task->journeys()->exists())
<div class="doing">
    fazendo
</div>
@else
{{formatShowStatus($task)}}
@endif
@endsection


@section('date_start')
<div class="circle-date-start">
    {{date('d/m/Y', strtotime($task->date_start))}}
</div>
<p class="labels" style="text-align: center">
    CRIAÇÃO
</p>
@endsection


@section('date_due')
<div class="circle-date-due">
    {{date('d/m/Y', strtotime($task->date_due))}}
</div>
<p class="labels" style="text-align: center">
    PRAZO
</p>
@endsection


@section('date_conclusion')
<div class="circle-date-conclusion">
    @if($task->date_conclusion)
    {{date('d/m/Y', strtotime($task->date_conclusion))}}
    @else
    <p style="color:white">
        --
    </p>
    @endif
</div>
<p class="labels" style="text-align: center">
    CONCLUSÃO
</p>
@endsection

@section('execution')
<div class='row' style='margin-top: 30px'>
    <div class='col-12' style='text-align: left'>
        <div class='show-label-large'>
            DESCRIÇÃO
        </div>
        <div class='description-field'>
            {!!html_entity_decode($task->description)!!}
        </div>
    </div>
</div>

<div class='row' style='margin-top: 30px'>
    <div class='col-12' style='text-align: left'>
        <div class='show-label-large'>
            EXECUÇÃO
        </div>
        <div class='show-description'>
            <table class='table-show'>
                <tr>
                    <td   class='table-list-header' style='width: 15%'>
                        ID
                    </td>
                    <td   class='table-list-header' style='width: 20%'>
                        FUNCIONÁRIO
                    </td>
                    <td   class='table-list-header' style='width: 45%'>
                        OBSERVAÇÕES
                    </td>
                    <td   class='table-list-header' style='width: 5%'>
                        DATA 
                    </td>
                    <td   class='table-list-header' style='width: 5%'>
                        INÍCIO 
                    </td>
                    <td   class='table-list-header' style='width: 5%'>
                        TÉRMINO 
                    </td>
                    <td   class='table-list-header' style='width: 5%'>
                        DURAÇÃO
                    </td>
                </tr>
                @foreach ($task->journeys as $journey)
                <tr style='font-size: 14px'>
                    <td class='table-list-left'>
                        <button class='button-round'>
                            <a href=' {{route('journey.show', ['journey' => $journey])}}'>
                                <i class='fa fa-eye' style='color:white'></i>
                            </a>
                        </button>
                        <button class='button-round'>
                            <a href=' {{route('journey.edit', ['journey' => $journey])}}'>
                                <i class='fa fa-edit' style='color:white'></i>
                            </a>
                        </button>
                        {{$journey->id}}
                    </td>
                    <td class='table-list-center'>
                        {{$journey->user->contact->name}}
                    </td>
                    <td class='table-list-left'>
                        {!!html_entity_decode($journey->description)!!}
                    </td>
                    <td class='table-list-center'>
                        @if($journey->date == date('Y-m-d'))
                        hoje
                        @else
                        {{dateBr($journey->date)}}
                        @endif
                    </td>
                    <td class='table-list-center'>
                        {{date('H:i', strtotime($journey->start_time))}}
                    </td>
                    <td class='table-list-center'>
                        @if($journey->end_time == null)
                        --
                        @else
                        {{date('H:i', strtotime($journey->end_time))}}
                        @endif
                    </td>
                    <td class='table-list-center' style='color:white;background-color: #874983'>
                        {{gmdate('H:i', $journey->duration)}}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td   class='table-list-header' style='text-align: right;padding: 5px;padding-right: 25px;font-size: 16px' colspan='7'>
                        Tempo total:   {{number_format($totalDuration / 3600, 1, ',','.')}}
                        <br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection