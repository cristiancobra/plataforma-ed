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

@section('priority')
{{formatShowStage($project)}}
@endsection

@section('status')
{{formatShowStatus($project)}}
@endsection

@section('fieldsId')
<div class='col-lg-2 col-xs-6' style='text-align: center'>
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
<div class='col-lg-4 col-xs-6' style='text-align: center'>
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
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
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
     border-top-style: solid;
     border-top-width: 1px;
     border-left-style: solid;
     border-left-width: 1px;
     border-radius: 7px 0px 0px 0px;
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
            <a id='stageButtonOnOff' class='circular-button primary' title='Criar nova etapa'>
                <i class='fa fa-plus' id='buttonOnOff' aria-hidden='true'></i>
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
    <form id='addStage' action='{{route('stage.store')}}' method='post' style='text-align: left'>
        @csrf
        <input type='hidden' name='project_id'  value='{{$project->id}}'>
        <div class='row pt-5 pb-5' id='stageRow' style='display: none'>
            <div class="row">
                <div class='col-3' style='text-align:left'>
                    <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                        NOME DA ETAPA
                    </label>
                    <br>
                    <input type='text' name='name'  placeholder='nome do projeto'  style='width:300px' value=''>
                </div>
                <div class='col-2' style='text-align:left'>
                    <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                        RESPONSÁVEL
                    </label>
                    <br>
                    {{createSelectUsers('select', $users)}}
                </div>
                <div class='col-2' style='text-align:left'>
                    <label class="labels" for="" >
                        DATA DE CRIAÇÃO:
                    </label>
                    <input type="date" name="start" value="{{date('Y-m-d')}}">
                    @if ($errors->has('start'))
                    <span class="text-danger">{{ $errors->first('start') }}</span>
                    @endif
                    <br>
                </div>
                <div class='col-2' style='text-align:left'>
                    <label class="labels" for="" >
                        PRAZO FINAL:
                    </label>
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
                    {{createFilterSelect('status', 'select', $status)}}
                </div>
            </div>
            <div class="row pt-4">
                <div class='col-5' style='text-align:left'>
                    <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                        DESCRIÇÃO
                    </label>
                </div>
            </div>
            <div class="row pt-1">
                <div class='col' style='text-align:left'>
                    @if ($errors->has('description'))
                    <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                    <textarea id="description" name="description" rows="20" cols="90">
  {{old('description')}}
                    </textarea>
                    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                    <script>
CKEDITOR.replace('description');
                    </script>
                </div>
            </div>
            <div class="row pt-4">
                <div class='col d-flex justify-content-end'>
                    {{createButtonSave()}}
                </div>
            </div>
        </div>
                </form>

        <!--cabeçalho--> 
        <div class='row mt-4'>
            <div class='col-1 tb tb-header'>
                RESPONSÁVEL
            </div>
            <div class='col-1 tb tb-header'>
                INÍCIO 
            </div>
            <div class='col-3 tb tb-header'>
                TAREFA 
            </div>
            <div class='col-4 tb tb-header'>
                DESCRIÇÃO 
            </div>
            <div class='col-1 tb tb-header'>
                CONCLUSÃO
            </div>
            <div class='col-1 tb tb-header'>
                PRIORIDADE
            </div>
            <div class='col-1 tb tb-header'>
                SITUAÇÃO
            </div>
        </div>
        @foreach($stages as $stage)
        <div class='row pt-3 pb-2 ' style="background-color: {{$oppositeColor}}">
            <div class='col-7 justify-content-start'>
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
            <div class='col-1 d-flex justify-content-center'>
                {{createButtonEdit('stage', 'stage', $stage)}}
            </div>
        </div>
        <div class='row pt-0 pb-2 ' style="background-color: {{$oppositeColor}}">
            <div class='col justify-content-start'>
                {{formatedText($stage->description)}}
            </div>
        </div>



        <!--várias linhas de tarefas-->
        @foreach ($stage->tasks as $task)
        @if($task->trash != 1)
        <div class='row position-relative'>
            <a class="stretched-link" href=' {{ route('task.show', ['task' => $task->id]) }}'>
            </a>
            <div class='tb col-1'>
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
            <div class='tb col-1'>
                {{date('d/m/Y', strtotime($task->date_start))}}
            </div>
            <div class='tb col-3'>
                {{$task->name}}
            </div>
            <div class='tb-description col-4'>
                {!!html_entity_decode($task->description)!!}
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
                <a id="taskButtonOnOff_{{$counter}}" class='circular-button primary' title='Criar nova tarefa'>
                    <i class='fa fa-plus' id='buttonOnOff' aria-hidden='true'></i>
                </a>
            </div>
        </div>



        <!-- linhas de tarefas sem estágio -->
        @foreach ($tasksWithoutStage as $task)
        @if($task->trash != 1)
        <div class='row position-relative'>
            <a class="stretched-link" href=' {{ route('task.show', ['task' => $task->id]) }}'>
            </a>
            <div class='tb col-1'>
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
            <div class='tb col-1'>
                {{date('d/m/Y', strtotime($task->date_start))}}
            </div>
            <div class='tb col-3'>
                {{$task->name}}
            </div>
            <div class='tb-description col-4'>
                {!!html_entity_decode($task->description)!!}
            </div>
            {{formatDateDue($task)}}

            {{formatPriority($task)}}

            {{formatStatus($task)}}

        </div>
        @endif



        <!--linha com botao ADICIONAR TAREFA-->
        <div class='row'>
            <div class='col-11 d-flex justify-content-end pt-3'>
                adicionar tarefa nesta etapa
            </div>
            <div class='col-1 d-flex justify-content-center pt-2 pb-2'>
                <a id="taskButtonOnOff_{{$counter}}" class='circular-button primary' title='Criar nova tarefa'>
                    <i class='fa fa-plus' id='buttonOnOff' aria-hidden='true'></i>
                </a>
            </div>
        </div>

        <!--linha oculta criar nova tarefa-->
        @if(Session::has('failed'))
        <div class="alert alert-danger">
            {{Session::get('failed')}}
            @php
            Session::forget('failed');
            @endphp
        </div>
        @endif
        <div class='pt-5 pb-5' id="taskRow_{{$counter++}}" style='display: none'>
            <div class="row">
                <div class='col-3' style='text-align:left'>
                    <form id='addStage' action='{{route('task.store')}}' method='post' style='text-align: left'>
                        <input type='hidden' name='project_id' value='{{$project->id}}'>
                        <input type='hidden' name='stage_id' value='{{$stage->id}}'>
                        @csrf
                        <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                            NOME DA TAREFA
                        </label>
                        <br>
                        <input type='text' name='name'  placeholder='nome da tarefa' value=''>
                        </div>
                        <div class='col-2' style='text-align:left'>

                            <label class="labels" for="" >DATA DE CRIAÇÃO:</label>
                            <input type="date" name="date_start" value="{{date('Y-m-d')}}">
                            @if ($errors->has('date_start'))
                            <span class="text-danger">{{ $errors->first('date_start') }}</span>
                            @endif
                            <br>
                        </div>
                        <div class='col-2' style='text-align:left'>
                            <label class="labels" for="" >PRAZO FINAL:</label>
                            @if(!empty(app('request')->input('date_due')))
                            <input type="date" name="date_due" value="{{app('request')->input('date_due')}}">
                            @else
                            <input type="date" name="date_due" value="{{old('date_due')}}">
                            @endif
                            <input type="time" name="time_due" size="50"  value="{{old('time_due')}}">
                            @if ($errors->has('date_due'))
                            <span class="text-danger">{{$errors->first('date_due')}}</span>
                            @endif
                            <br>
                        </div>
                        <div class='col-2' style='text-align:left'>
                            <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                                RESPONSÁVEL
                            </label>
                            <br>
                            {{createSelectUsers('select', $users, 'Todos os usuários')}}
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
                            {{createFilterSelect('status', 'select', $status)}}
                        </div>
                </div>
                <div class="row pt-5">
                    <div class='col-5' style='text-align:left'>
                        <label class='labels' for='description' style='text-align:left;color:{{$principalColor}}'>
                            DESCRIÇÃO
                        </label>
                    </div>
                </div>
                <div class="row pt-1">
                    <div class='col' style='text-align:left'>
                        @if ($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                        @endif
                        <textarea id="description" name="description" rows="20" cols="90">
  {{old('description')}}
                        </textarea>
                        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                        <script>
CKEDITOR.replace('description');
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
            @endforeach


            <!--tarefas sem etapas-->
            @if(Session::has('failed'))
            <div class="alert alert-danger">
                {{Session::get('failed')}}
                @php
                Session::forget('failed');
                @endphp
            </div>
            @endif
            <div class='pt-5 pb-5' id="taskRow_{{$counter++}}" style='display: none'>
                <div class="row">
                    <div class='col-3' style='text-align:left'>
                        <form id='addStage' action='{{route('task.store')}}' method='post' style='text-align: left'>
                            <input type='hidden' name='project_id' value='{{$project->id}}'>
                            <input type='hidden' name='stage_id' value='{{$stage->id}}'>
                            @csrf
                            <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                                NOME DA TAREFA
                            </label>
                            <br>
                            <input type='text' name='name'  placeholder='nome da tarefa' value=''>
                            </div>
                            <div class='col-2' style='text-align:left'>

                                <label class="labels" for="" >DATA DE CRIAÇÃO:</label>
                                <input type="date" name="date_start" value="{{date('Y-m-d')}}">
                                @if ($errors->has('date_start'))
                                <span class="text-danger">{{ $errors->first('date_start') }}</span>
                                @endif
                                <br>
                            </div>
                            <div class='col-2' style='text-align:left'>
                                <label class="labels" for="" >PRAZO FINAL:</label>
                                @if(!empty(app('request')->input('date_due')))
                                <input type="date" name="date_due" value="{{app('request')->input('date_due')}}">
                                @else
                                <input type="date" name="date_due" value="{{old('date_due')}}">
                                @endif
                                <input type="time" name="time_due" size="50"  value="{{old('time_due')}}">
                                @if ($errors->has('date_due'))
                                <span class="text-danger">{{$errors->first('date_due')}}</span>
                                @endif
                                <br>
                            </div>
                            <div class='col-2' style='text-align:left'>
                                <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                                    RESPONSÁVEL
                                </label>
                                <br>
                                {{createSelectUsers('select', $users, 'Todos os usuários')}}
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
                                {{createFilterSelect('status', 'select', $status)}}
                            </div>
                    </div>
                    <div class="row pt-5">
                        <div class='col-5' style='text-align:left'>
                            <label class='labels' for='description' style='text-align:left;color:{{$principalColor}}'>
                                DESCRIÇÃO
                            </label>
                        </div>
                    </div>
                    <div class="row pt-1">
                        <div class='col' style='text-align:left'>
                            @if ($errors->has('description'))
                            <span class="text-danger">{{$errors->first('description')}}</span>
                            @endif
                            <textarea id="description" name="description" rows="20" cols="90">
  {{old('description')}}
                            </textarea>
                            <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                            <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                            <script>
CKEDITOR.replace('description');
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
                @endforeach



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

            @section('deleteButton')
            {{createButtonTrash($project, 'project')}}
            @endsection

            @section('editButton', route('project.edit', ['project' => $project->id]))

            @section('backButton', route('project.index'))

            @section('createdAt')
            <div class='row' style='margin-top: 30px'>
                <div class='col-12'style='padding-top: -10px'>
                    Primeiro registro em: {{date('d/m/Y H:i', strtotime($project->created_at))}}
                </div>
            </div>
            @endsection


            @section('js-scripts')
            <script>
                // botão do filtro
                $(document).ready(function () {
                console.log('filter button')
                        //botao de exibir filtro
                        $('#stageButtonOnOff').click(function () {
                $('#stageRow').slideToggle(600);
                $('#buttonOnOff').toggleClass('plus minus');
                });
                $('#taskButtonOnOff').click(function () {
                $('#taskRow').slideToggle(600);
                });
                @php
                        $counterJs = 1;
                foreach($stages as $stage) {
                echo "
                        $('#taskButtonOnOff_$counterJs').click(function () {
                $('#taskRow_$counterJs').slideToggle(600);
                });
                ";
                        $counterJs++;
                }
                @endphp

                });
            </script>
            @endsection
