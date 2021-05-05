@extends('layouts/show')

@section('title','TAREFAS')

@section('image-top')
{{asset('imagens/tarefas.png')}} 
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


@section('fieldsId')
<div class='show-label'>
    CONTATO
</div>
<div class='show-label'>
    EMPRESA
</div>
<div class='show-label'>
    OPORTUNIDADE
</div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field'>
        @if(isset($task->contact->name))
        {{$task->contact->name}}
        @else
        Não possui
        @endif
    </div>
    <div class='show-field'>
        @if(isset($task->company->name))
        {{$task->company->name}}
        @else
        Pessoa física
        @endif
    </div>
    <div class='show-field'>
        @isset($task->opportunity->id)
        {{$task->opportunity->name}}
        <button class='button-round'>
            <a href=' {{route('opportunity.show', ['opportunity' => $task->opportunity])}}'>
                <i class='fa fa-eye' style='color:white'></i>
            </a>
        </button>
        @else
        Não possui
        @endisset
    </div>
</div>
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        CONTA
    </div>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field'>
        {{$task->account->name}}
    </div>
    <div class='show-field'>
        {{$task->department}}
    </div>
    <div class='show-field'>
        @if(isset($task->user->contact->name))
        {{$task->user->contact->name}}
        @else
        foi excluído
        @endif
    </div>
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


    @section('description')
    {!!html_entity_decode($task->description)!!}
    @endsection

    @section('execution')
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

    <div class='row' style='margin-top: 10px;text-align: right'>
        <div class='col-12'style='text-align: right'>
            <a class='circular-button primary' href='{{route('journey.create', [
				'taskName' => $task->name,
				'taskId' => $task->id,
				'taskAccountName' => $task->account->name,
				'taskAccountId' => $task->account->id,
				])}}'>
                <i class='fa fa-plus' aria-hidden='true'></i>
            </a>
        </div>
    </div>
    @endsection

    @section('deleteButton', route('task.destroy', ['task' => $task->id]))

    @section('editButton', route('task.edit', ['task' => $task->id]))

    @section('backButton', route('task.index'))

    @section('createdAt')
    <div class='row' style='margin-top: 30px'>
        <div class='col-12'style='padding-top: -10px'>
            Primeiro registro em: {{date('d/m/Y H:i', strtotime($task->created_at))}}
        </div>
    </div>
    @endsection
