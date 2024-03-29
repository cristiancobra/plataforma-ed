@extends('layouts/show')

@section('title', $title)

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
{{createButtonTrash($project, 'project')}}
{{createButtonEdit('project', 'project', $project, 'department', $project->department)}}
{{createButtonList('project', 'department',  $project->department)}}
@endsection

@section('name', $project->name)


@section('priority', $priority)


@section('status', $status)


@section('fieldsId')
<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        META
    </div>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        CONTATO
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>
    @if($project->goal)
    <a href='{{route('goal.show', ['goal' => $project->goal_id])}}'>
        <div class='show-field-end'>
            {{$project->goal->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif

    @if($project->company)
    <a href='{{route('company.show', ['company' => $project->company])}}'>
        <div class='show-field-end'>
            {{$companyName}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif


    @if(isset($project->contact->name))
    <a href='{{route('contact.show', ['contact' => $project->contact])}}'>
        <div class='show-field-end'>
            {{$project->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif
</div>
<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>
    @if(isset($project->user->contact->name))
    <a href='{{route('user.show', ['user' => $project->user])}}'>
        <div class='show-field-end'>
            {{$project->user->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        foi excluído
    </div>
</div>
@endif
@endsection

@section('date_start')
<div class='circle-date-start'>
    @if($project->date_start == null)
    indefinida
    @else
    {{date('d/m/Y', strtotime($project->date_start))}}
    @endif
</div>
<p class='labels' style='text-align: center'>
    CRIAÇÃO
</p>
@endsection


@section('date_due')    
<div class='circle-date-due'>
    @if($project->date_due)
    {{date('d/m/Y', strtotime($project->date_due))}}
    @else
    --
    @endif
</div>
<p class='labels' style='text-align: center'>
    PRAZO FINAL
</p>
@endsection


@section('date_conclusion')
<div class='circle-date-conclusion'>
    @if($project->date_conclusion == null)
    --
    @else
    <p style='color:white'>
        {{date('d/m/Y', strtotime($project->date_conclusion))}}
    </p>
    @endif
</div>
<p class='labels' style='text-align: center'>
    CONCLUSÃO
</p>
@endsection


@section('description')
{!!html_entity_decode($project->description)!!}
@endsection


@section('main')
<div class='container mt-5' style='
     border-style: solid;
     border-width: 1px;
     border-radius: 7px 7px 7px 7px;
     border-color: {{$principalColor}}
     '>
    <div class='row mt-0'>
        <div class='col-6 pt-3 pb-3'>
            <img src='{{asset('images/task-new.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >
                ETAPAS
            </label>
        </div>
        <div class='col-6 pt-4 pb-3 d-flex justify-content-end'
             '>
            <a id='stageButtonOnOff' class='circular-button primary' title='Criar nova etapa' onclick='toogleAddForm("targetEtapa")'>
                <i id='stageButtonOnOffIcon' class='fa fa-plus' id='buttonOnOff' aria-hidden='true'></i>
            </a>
        </div>
    </div>

    <!--  div oculta ADICIONAR ETAPA  -->

    @if(Session::has('failed'))
    <div class="alert alert-danger">
        {{Session::get('failed')}}
        @php
        Session::forget('failed');
        @endphp
    </div>
    @endif
    <div class='container pt-5 pb-5'  id='targetEtapa' style='display: none;background-color: #f1f1f1'>
        <form id='addStage' action='{{route('stage.store')}}' method='post' style='text-align: left'>
            @csrf
            <input type='hidden' name='project_id'  value='{{$project->id}}'>
            <div class="row">
                <div class='col' style='text-align:left'>
                    <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                        NOME: 
                    </label>
                    <input type='text' name='name'  placeholder='nome da ETAPA'  style='width:90%;margin-left: 10px' value=''>
                </div>
            </div>
            <div class="row mt-5">
                <div class='col-3' style='text-align:left'>
                    <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                        RESPONSÁVEL
                    </label>
                    <br>
                    {{createSelectUsers('select', $allUsers)}}
                </div>
                <div class='col-2' style='text-align:left'>
                    <label class="labels" for="" >
                        INÍCIO:
                    </label>
                    <br>
                    <input type="date" name="start" value="{{date('Y-m-d')}}">
                    @if ($errors->has('start'))
                    <span class="text-danger">{{ $errors->first('start') }}</span>
                    @endif
                    <br>
                </div>
                <div class='col-3' style='text-align:left'>
                    <label class="labels" for="" >
                        PRAZO FINAL:
                    </label>
                    <br>
                    @if(!empty(app('request')->input('end')))
                    <input type="date" name="end" value="{{app('request')->input('end')}}">
                    @else
                    <input type="date" name="end" value="{{old('end')}}">
                    @endif
                    <input type="time" name="time_due" size="50"  value="{{old('time_due')}}">
                    @if ($errors->has('date_due'))
                    <span class="text-danger">{{$errors->first('date_due')}}</span>
                    @endif
                    <br>
                </div>
                <div class='col-2' style='text-align:left'>
                    <label class='labels' for='priority' style='text-align:left;color:{{$principalColor}}'>
                        PRIORIDADE
                    </label>
                    <br>
                    {{createFilterSelect('priority', 'select', $priorities)}}
                </div>
                <div class='col-1' style='text-align:left'>
                    <label class='labels' for='status' style='text-align:left;color:{{$principalColor}}'>
                        SITUAÇÃO
                    </label>
                    <br>
                    {{createFilterSelect('status', 'select', $allStatus)}}
                </div>
            </div>
            <div class="row pt-4">
                <div class='col-5' style='text-align:left'>
                    <label class='labels' for='description' style='text-align:left;color:{{$principalColor}}'>
                        DESCRIÇÃO
                    </label>
                    @if ($errors->has('description'))
                    <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                </div>
            </div>
            <div class="row pt-1">
                <div class='col' style='text-align:left'>
                    <textarea id="descriptionStage" name="description" rows="6" cols="90">
  {{old('description')}}
                    </textarea>
                    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                    <script>
CKEDITOR.replace('descriptionStage');
                    </script>
                </div>
            </div>
            <div class="row pt-4">
                <div class='col d-flex justify-content-end'>
                    {{createButtonSave()}}
                </div>
            </div>
        </form>
    </div>

    <!--cabeçalho--> 
    <div class='row table-header mt-4'  style="background-color: {{$principalColor}}">
        <div class='col-1'>
            RESPONSÁVEL
        </div>
        <div class='col-1'>
            INÍCIO 
        </div>
        <div class='col-7'>
            TAREFA 
        </div>
        <div class='col-1'>
            CONCLUSÃO
        </div>
        <div class='col-1'>
            PRIORIDADE
        </div>
        <div class='col-1'>
            SITUAÇÃO
        </div>
    </div>

    <!--linhas de ETAPAS-->
    @foreach($stages as $stage)
    <div class="container mt-5"style="
         border-color: {{$oppositeColor}};
         border-style: solid;
         border-radius: 7px;
         padding: 0px;
         ">
        <div class='row pt-3 pb-2 position-relative' style="margin:auto;background-color: {{$oppositeColor}}">
            <a class='stretched-link' href='{{route('stage.edit', ['stage' => $stage->id])}}'>
            </a>
            <div class='col-8 justify-content-start'>
                <p  class='labels' style="text-align: left; color: {{$principalColor}}">
                    ETAPA:  {{$stage->name}}
                </p>
            </div>
            <div class='col-2 justify-content-start'>
                <p  class='labels' style="text-align: left; color: {{$principalColor}}">
                    início:  {{dateBr($stage->start)}}
                </p>
            </div>
            <div class='col-2 justify-content-start'>
                <p  class='labels' style="text-align: left; color: {{$principalColor}}">
                    prazo:  {{dateBr($stage->end)}}
                </p>
            </div>
        </div>
        <div class='row pt-0 pb-2 position-relative ' style="margin:auto;background-color: {{$oppositeColor}}">
            <a class='stretched-link' href='{{route('stage.edit', ['stage' => $stage->id])}}'>
            </a>
            <div class='col justify-content-start'>
                {{formatedText($stage->description)}}
            </div>
        </div>



        <!--linhas de tarefas-->
        @foreach ($stage->tasks as $task)
        @if($task->trash != 1)
        <div class='row table2 position-relative' style="
             margin-left: 20px;
             margin-right: 20px;
             color: {{$principalColor}};
             border-left-color: {{$complementaryColor}};
             ">
            <a class="stretched-link" href=' {{ route('task.show', ['task' => $task->id]) }}'>
            </a>
            <div class='cel col-1'>
                @if(isset($task->user->image))
                <div class='profile-picture-small'>
                    <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
                        <img src='{{asset($task->user->image->path)}}' width='100%' height='100%'>
                    </a>
                </div>
                @elseif(isset($task->user->contact->name))
                <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
                    {{$task->user->contact->name}}
                </a>
                @else
                funcionário excluído
                @endif
            </div>
            <div class='cel col-1' style="font-weight: 600">
                {{date('d/m/Y', strtotime($task->date_start))}}
            </div>
            <div class='cel col-7 justify-content-start'>
                {{$task->name}}
            </div>
            
            {{formatDateDue($task)}}

            {{formatPriority($task)}}

            {{formatStatus($task)}}

        </div>
        @endif
        @endforeach


        <!--linha com botao ADICIONAR TAREFA-->
        <div class='row'>
            <div class='col-11 d-flex justify-content-end pt-3'>
                adicionar tarefa nesta etapa
            </div>
            <div class='col-1 d-flex justify-content-center pt-2 pb-2'>
                <a id="taskButtonOnOff_{{$counter}}" class='circular-button primary' title='Criar nova tarefa'  onclick='toogleAddForm("taskRow_{{$counter}}")'>
                    <i class='fa fa-plus' id='buttonOnOff' aria-hidden='true'></i>
                </a>
            </div>
        </div>


        <!--linha oculta adicionar TAREFAS DENTRO DA ETAPA -->
        @if(Session::has('failed'))
        <div class="alert alert-danger">
            {{Session::get('failed')}}
            @php
            Session::forget('failed');
            @endphp
        </div>
        @endif
        <div class='container pt-5 pb-5' id="taskRow_{{$counter}}" style='display: none;background-color: #f1f1f1'>
            <form id='addStage' action='{{route('task.store')}}' method='post' style='text-align: left'>
                <input type='hidden' name='project_id' value='{{$project->id}}'>
                <input type='hidden' name='stage_id' value='{{$stage->id}}'>
                @csrf
                <div class="row">
                    <div class='col' style='text-align:left'>
                        <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                            NOME: 
                        </label>
                        <input type='text' name='name'  placeholder='nome da TAREFA'  style='width:90%;margin-left: 10px' value=''>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class='col-3' style='text-align:left'>
                        <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                            RESPONSÁVEL
                        </label>
                        <br>
                        {{createSelectUsers('select', $allUsers)}}
                    </div>
                    <div class='col-2' style='text-align:left'>
                        <label class="labels" for="" >
                            INÍCIO:
                        </label>
                        <br>
                        <input type="date" name="date_start" value="{{date('Y-m-d')}}">
                        @if ($errors->has('date_start'))
                        <span class="text-danger">{{ $errors->first('date_start') }}</span>
                        @endif
                    </div>
                    <div class='col-3' style='text-align:left'>
                        <label class="labels" for="" >
                            PRAZO FINAL:
                        </label>
                        <br>
                        @if(!empty(app('request')->input('date_due')))
                        <input type="date" name="date_due" value="{{app('request')->input('date_due')}}">
                        @else
                        <input type="date" name="date_due" value="{{old('date_due')}}">
                        @endif
                        <input type="time" name="time_due" size="50"  value="{{old('time_due')}}">
                        @if ($errors->has('date_due'))
                        <span class="text-danger">{{$errors->first('date_due')}}</span>
                        @endif
                    </div>
                    <div class='col-2' style='text-align:left'>
                        <label class='labels' for='priority' style='text-align:left;color:{{$principalColor}}'>
                            PRIORIDADE
                        </label>
                        <br>
                        {{createFilterSelect('priority', 'select', $priorities)}}
                    </div>
                    <div class='col-1' style='text-align:left'>
                        <label class='labels' for='status' style='text-align:left;color:{{$principalColor}}'>
                            SITUAÇÃO
                        </label>
                        <br>
                        {{createFilterSelect('status', 'select', $allStatus)}}
                    </div>
                </div>
                <div class="row pt-4">
                    <div class='col-5' style='text-align:left'>
                        <label class='labels' for='description' style='text-align:left;color:{{$principalColor}}'>
                            DESCRIÇÃO
                        </label>
                        @if ($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                        @endif
                    </div>
                </div>
                <div class="row pt-1">
                    <div class='col' style='text-align:left'>
                        <textarea id="descriptionTask_{{$counter}}" name="description" rows="20" cols="90">
  {{old('description')}}
                        </textarea>
                        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                        <script>
CKEDITOR.replace("descriptionTask_{{$counter++}}");
                        </script>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class='col d-flex justify-content-end'>
                        {{createButtonSave()}}
                    </div>
            </form>
        </div>
    </div>
</div>
@endforeach



<!--cabeçalho sem tarefas-->
<div class="container mt-5"style="
     border-color: lightgray;
     border-style: solid;
     border-radius: 7px;
     padding: 0px;
     ">
    <div class='row pt-3 pb-2' style="margin:auto;background-color: lightgray">
        <div class='col-7 justify-content-start'>
            <p  class='labels' style="text-align: left; color: {{$principalColor}}">
                TAREFAS SEM ETAPA
            </p>
        </div>
    </div>



    <!--linhas de tarefas-->
    @foreach ($tasksWithoutStage as $task)
    @if($task->trash != 1)
    <div class='row table2 position-relative' style="color: {{$principalColor}};
         border-left-color: {{$complementaryColor}};
         ">
        <a class="stretched-link" href=' {{ route('task.show', ['task' => $task->id]) }}'>
        </a>
        <div class='cel col-1'>
            @if(isset($task->user->image))
            <div class='profile-picture-small'>
                <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
                    <img src='{{asset($task->user->image->path)}}' width='100%' height='100%'>
                </a>
            </div>
            @elseif(isset($task->user->contact->name))
            <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
                {{$task->user->contact->name}}
            </a>
            @else
            funcionário excluído
            @endif
        </div>
            <div class='cel col-1' style="font-weight: 600">
            {{date('d/m/Y', strtotime($task->date_start))}}
        </div>
        <div class='cel col-7 justify-content-start'>
            {{$task->name}}
        </div>
        {{formatDateDue($task)}}

        {{formatPriority($task)}}

        {{formatStatus($task)}}

    </div>
    @endif
    @endforeach
</div>




<!--linha com botao ADICIONAR TAREFA SEM ETAPA-->
<div class='row'>
    <div class='col-11 d-flex justify-content-end pt-3'>
        adicionar tarefa nesta etapa
    </div>
    <div class='col-1 d-flex justify-content-center pt-2 pb-2'>
        <a id="taskButtonOnOffExtra" class='circular-button primary' title='Criar nova tarefa' onclick='toogleAddForm("taskRowExtra")'>
            <i class='fa fa-plus' id='buttonOnOff' aria-hidden='true'></i>
        </a>
    </div>
</div>

<!--div oculta adicionar tarefa SEM ETAPA-->

@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div class='container pt-5 pb-5' id="taskRowExtra" style='display: none;background-color: #f1f1f1'>
    <form id='addStage' action='{{route('task.store')}}' method='post' style='text-align: left'>
        <input type='hidden' name='project_id' value='{{$project->id}}'>
        @csrf
        <div class="row">
            <div class='col' style='text-align:left'>
                <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                    NOME: 
                </label>
                <input type='text' name='name'  placeholder='nome da TAREFA'  style='width:90%;margin-left: 10px' value=''>
            </div>
        </div>
        <div class="row mt-5">
            <div class='col-3' style='text-align:left'>
                <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                    RESPONSÁVEL
                </label>
                <br>
                {{createSelectUsers('select', $allUsers)}}
            </div>
            <div class='col-2' style='text-align:left'>
                <label class="labels" for="" >
                    INÍCIO:
                </label>
                <br>
                <input type="date" name="date_start" value="{{date('Y-m-d')}}">
                @if ($errors->has('date_start'))
                <span class="text-danger">{{ $errors->first('date_start') }}</span>
                @endif
            </div>
            <div class='col-3' style='text-align:left'>
                <label class="labels" for="" >
                    PRAZO FINAL:
                </label>
                <br>
                @if(!empty(app('request')->input('date_due')))
                <input type="date" name="date_due" value="{{app('request')->input('date_due')}}">
                @else
                <input type="date" name="date_due" value="{{old('date_due')}}">
                @endif
                <input type="time" name="time_due" size="50"  value="{{old('time_due')}}">
                @if ($errors->has('date_due'))
                <span class="text-danger">{{$errors->first('date_due')}}</span>
                @endif
            </div>
            <div class='col-2' style='text-align:left'>
                <label class='labels' for='priority' style='text-align:left;color:{{$principalColor}}'>
                    PRIORIDADE
                </label>
                <br>
                {{createFilterSelect('priority', 'select', $priorities)}}
            </div>
            <div class='col-1' style='text-align:left'>
                <label class='labels' for='status' style='text-align:left;color:{{$principalColor}}'>
                    SITUAÇÃO
                </label>
                <br>
                {{createFilterSelect('status', 'select', $allStatus)}}
            </div>
        </div>
        <div class="row pt-4">
            <div class='col-5' style='text-align:left'>
                <label class='labels' for='description' style='text-align:left;color:{{$principalColor}}'>
                    DESCRIÇÃO
                </label>
                @if ($errors->has('description'))
                <span class="text-danger">{{$errors->first('description')}}</span>
                @endif
            </div>
        </div>
        <div class="row pt-1">
            <div class='col' style='text-align:left'>
                <textarea id="descriptionTaskExtra" name="description" rows="20" cols="90">
  {{old('description')}}
                </textarea>
                <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                <script>
CKEDITOR.replace("descriptionTaskExtra");
                </script>
            </div>
        </div>
        <div class="row pt-4">
            <div class='col d-flex justify-content-end'>
                {{createButtonSave()}}
            </div>
    </form>
</div>
</div>
</div>




<!--linha total--> 
<div class='row mb-4'>
    <div class='tb tb-header col-11 justify-content-end'>
        TOTAL:
    </div>
    <div class='tb tb-header col-1'>
        {{formatTotalHour($tasksOperationalHours)}} horas
    </div>
</div>
</div>
@endsection


@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($project->created_at))}}
    </div>
</div>
@endsection



@section('workflow')
@endsection

