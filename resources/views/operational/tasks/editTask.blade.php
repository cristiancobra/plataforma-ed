@extends('layouts/edit')

@section('title','TAREFAS')

@section('image-top')
{{asset('images/rocket.png')}} 
@endsection



@section('form_start')
<form action=' {{route('task.update', ['task' => $task])}} ' method='post'>
    @csrf
    @method('put')
    @endsection



    @section('buttons')
    <a class='circular-button secondary'  title='Cancelar alterações' href='{{url()->previous()}}'>
        <i class='fas fa-times-circle'></i>
    </a>
    <button id='' class='circular-button primary' title='Salvar alterações' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
        <i class='fas fa-save'></i>
    </button>
    @endsection


    @section('name')
    NOME:
    @if ($errors->has('name'))
    <input type="text" name="name" size="60" value="{{old('name')}}">
    <span class="text-danger">{{$errors->first('name')}}</span>
    @else
    <input type="text" name="name" size="60" value="{{$task->name}}">
    @endif
    @endsection


    @section('priority')
    PRIORIDADE:
    <br>
    {{createSimpleSelect('priority', 'fields', $priorities, $task->priority)}}
    @endsection


    @section('status')
    SITUAÇÃO:
    {{createSimpleSelect('status', 'fields', $status, $task->status)}}
    @endsection


    @section('fieldsId')
        <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            CONTATO
        </div>
        <div class='show-label'>
            EMPRESA:
        </div>
        <div class='show-label'>
            OPORTUNIDADE 
        </div>
    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>
        <div class='show-field-end'>
            <select name="contact_id"  style='width:100%'>
                @if(!isset($task->contact->name))
                <option  class="fields" value="">
                    contato excluído
                </option>
                @else
                <option  class="fields" value="{{$task->contact_id}}">
                    {{$task->contact->name}}
                </option>
                @endif
                @foreach ($contacts as $contact)
                <option  class="fields" value="{{$contact->id}}">
                    {{$contact->name}}
                </option>
                @endforeach
            </select>
        </div>
        <div class='show-field-end'>
            @if($task->company_id)
            {{editDoubleSelectIdName('company_id', '', $companies, $task->company->name, 'Não possui')}}
            @else
            {{editDoubleSelectIdName('company_id', '', $companies, null, 'Não possui')}}
            @endif
        </div>
        <div class='show-field-end'>
            {{createSelectIdName('opportunity_id', 'fields', $opportunities, 'Não possui', $task->opportunity)}}
        </div>
    </div>
    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            RESPONSÁVEL
        </div>
        <div class='show-label'>
            DEPARTAMENTO
        </div>
        <div class='show-label'>
            PROJETO
        </div>
        <div class='show-label'>
            ETAPA
        </div>
        <div class='show-label'>
            PONTOS
        </div>
    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>
        <div class='show-field-end'>
            <select name="user_id">
                @if(!isset($task->user->contact->name))
                <option  class="fields" value="">
                    contato excluído
                </option>
                @else
                <option  class="fields" value="{{$task->user->id}}">
                    {{$task->user->contact->name}}
                </option>
                @foreach ($users as $user)
                <option  class="fields" value="{{$user->id}}">
                    {{$user->contact->name}}
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <div class='show-field-end'>
            {{createSimpleSelect('department', 'fields', $departments, $task->department)}}
        </div>
        <div class='show-field-end'>
            <select class = 'fields' name='project_id' style='width:100%' onchange='populate(this.name, 'stage_id')'>
                @if($task->project)
                <option value='{{$task->project_id}}'>
                    {{$task->project->name}}
                </option>
                @endif
                <option value=''>
                    Não possui
                </option>
                @foreach ($projects as $project)
                <option value='{{$project->id}}'>
                    {{$project->name}}
                </option>
                @endforeach
            </select>
        </div>
        <div class='show-field-end'>
                        <input type='number' name='points' value='{{$task->points}}' style="text-align: right;width: 100px">
        </div>
    </div>
    @endsection




    @section('date_start')
    <div class='circle-date-start'>
        <input type="date" name="date_start" size="20" value="{{$task->date_start}}">
        @if ($errors->has('date_start'))
        <span class='text-danger'>{{$errors->first('date_start')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        INÍCIO
    </p>
    @endsection


    @section('date_due')    
    <div class='circle-date-due'>
        <input type="date" name="date_due" size="20" value="{{date('Y-m-d', strtotime($task->date_due))}}">
        <input type="time" name="time_due" size="50"  value="{{date('H:i', strtotime($task->date_due))}}">
        @if ($errors->has('date_due'))
        <span class="text-danger">{{$errors->first('date_due')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        PRAZO
    </p>
    @endsection


    @section('date_conclusion')
    <div class='circle-date-due'>
        <input type="date" name="date_conclusion" size="20" value="{{$task->date_conclusion}}">
        @if ($errors->has('date_conclusion'))
        <span class="text-danger">{{$errors->first('date_conclusion')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CONCLUSÃO
    </p>
    @endsection


    



    @section('description')
    <br>
    @if ($errors->has('description'))
    <span class='text-danger'>{{$errors->first('text')}}</span>
    @endif
    <textarea id='text' name='description' rows='20' cols='120'>
  {{$task->description}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
CKEDITOR.replace('description');
    </script>
    @endsection


    @section('main')
    @if(Session::has('failed'))
    <div class='alert alert-danger'>
        {{Session::get('failed')}}
        @php
        Session::forget('failed');
        @endphp
    </div>
    @endif
    <div>
        <div class='row mt-4'>
            <div class="col">
                <label class='labels' for='' >ANEXAR IMAGEM:</label>
                <input type='file' name='image'>
            </div>
        </div>
    </div>
    @endsection




    @section('js_scripts')
    <script>
        function populate(project_id, stage_id) {

        }
        ;

        function loadAjaxGenericOptions(target, changeSelector, jsonUrl, inputId) {
            var changeInputId = $(changeSelector).val();
            var $target = $(target);
            if (!changeInputId) {
                $target.removeOption(/./);
                $target.change();
            } else {
                $.ajax({
                    async: false,
                    url: jsonUrl + '/' + changeInputId,
                    success: function (response, textStatus, jqXHR) {
                        if (response != "") {
                            $target.removeOption(/./);
                            $target.addOption(response, false);
                            $target.val(inputId);
                            $target.change();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        catchError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
            $(changeSelector).change(function () {
                var changeInputId = $(this).val();
                if (!changeInputId) {
                    $target.removeOption(/./);
                    $target.change();
                } else {
                    $.ajax({
                        async: false,
                        url: jsonUrl + '/' + changeInputId,
                        success: function (response, textStatus, jqXHR) {
                            if (response != "") {
                                $target.removeOption(/./);
                                $target.addOption(response, false);
                                $target.val(inputId);
                                $target.change();
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            catchError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            });
        }

    </script>
    @endsection