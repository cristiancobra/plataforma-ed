@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{asset('images/rocket.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('task')}}
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<form action=" {{route('task.update', ['task' =>$task->id])}} " method="post">
    @csrf
    @method('put')
    <div>
        <label class="labels" for="" >NOME DA TAREFA:</label>
        @if ($errors->has('name'))
        <input type="text" name="name" size="80" value="{{old('name')}}">
        <span class="text-danger">{{$errors->first('name')}}</span>
        @else
        <input type="text" name="name" size="80" value="{{$task->name}}">
        @endif
        <br>
        <label class="labels" for="" >DEPARTAMENTO:</label>
        {{createSimpleSelect('department', 'fields', $departments, $task->department)}}
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
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
                {{$user->name}}
            </option>
            @endforeach
            @endif
        </select>
        <br>
        <br>
        @if($task->department == 'desenvolvimento')
        <label class="labels" for="" >PROJETO:</label>
        <select class = 'fields' name='opportunity_id' style='width:700px'>
            @if($task->opportunity_id != null)
            <option value='{{$task->opportunity_id}}'>
                {{$task->opportunity->name}}
            </option>
            @endif
            @foreach ($projects as $project)
            <option value='{{$project->id}}'>
                {{$project->name}}
            </option>
            @endforeach
        </select>
                {{createButtonAdd('opportunity.create', 'department', 'desenvolvimento')}}
        <br>
        <br>
        @else
        <label class="labels" for="" >OPORTUNIDADE:</label>
        <select class = 'fields' name='opportunity_id' style='width:700px'>
            @if($task->opportunity_id != null)
            <option value='{{$task->opportunity_id}}'>
                {{$task->opportunity->name}}
            </option>
            @endif
            <option value=''>
                Não possui
            </option>
            @foreach ($opportunities as $opportunity)
            <option value='{{$opportunity->id}}'>
                {{$opportunity->date_start}}  //  
                @if($opportunity->company)
                {{$opportunity->company->name}}  --
                @endif
                @if($opportunity->contact)
                {{$opportunity->contact->name}}  --
                @endif
                {{$opportunity->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        @endif
        <label class="labels" for="" >DATA DE CRIAÇÃO:</label>
        <input type="date" name="date_start" size="20" value="{{$task->date_start}}">
        @if ($errors->has('date_start'))
        <span class="text-danger">{{$errors->first('date_start')}}</span>
        @endif
        <br>
        <label class="labels" for="" >PRAZO FINAL:</label>
        <input type="date" name="date_due" size="20" value="{{date('Y-m-d', strtotime($task->date_due))}}">
        <input type="time" name="time_due" size="50"  value="{{date('H:i', strtotime($task->date_due))}}">
        @if ($errors->has('date_due'))
        <span class="text-danger">{{$errors->first('date_due')}}</span>
        @endif
        <br>
        <label class="labels" for="" >DATA DE CONCLUSÃO:</label>
        <input type="date" name="date_conclusion" size="20" value="{{$task->date_conclusion}}">
        <input type="checkbox" name="cancelado" value="cancelado"
               @if($task->status == "cancelado")
        checked="checked"
        @endif
        >
        cancelada
        <input type="checkbox" name="aguardar" value="aguardar"
               @if($task->status == "aguardar")
        checked="checked"
        @endif
        >
        aguardar
        <br>
        <label class="labels" for="" >PONTOS:</label>
        <input type='number' name='points' value='{{$task->points}}' style="text-align: right;width: 100px">
        <br>
        <br>
        <label class="labels" for="" >DESCRIÇÃO:</label>
        <textarea id="description" name="description" rows="20" cols="90">
		{{ $task->description }}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <label class="labels" for="" >CONTATO: </label>
        <select name="contact_id">
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
        <br>
        <label class="labels" for="" >EMPRESA: </label>
        @if($task->company_id)
        {{editDoubleSelectIdName('company_id', '', $companies, $task->company->name, 'Não possui')}}
        @else
        {{editDoubleSelectIdName('company_id', '', $companies, null, 'Não possui')}}
        @endif
        <br>
        <label class="labels" for="" >PRIORIDADE:</label>
        {{createSimpleSelect('priority', 'fields', $priorities, $task->priority)}}
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR TAREFA">
        </form>
        <br>
        <br>
        <br>
    </div>     
    @endsection
