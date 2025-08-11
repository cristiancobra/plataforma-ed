@extends('layouts/master')

@section('title', $title)

@section('image-top')
{{asset('images/financeiro.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonList('project')}}
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
<div>
    <form action=" {{route('project.update', ['project' =>$project->id])}} " method="post">
        @csrf
        @method('put')
        @if($project->department == 'desenvolvimento')
        <input type="hidden" name="department" value="{{$project->department}}">
        @endif
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" style="width: 700px" value="{{$project->name}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
        <select name="user_id">
            <option  class="fields" value="{{$project->user_id}}">
                {{$project->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->contact->name}}
            </option>
            @endforeach
        </select>
                <br>
        <label class="labels" for="" >META: </label>
        {{createSelectIdName('goal_id', 'fields', $goals, 'Não possui', $project->goal)}}
        <br>
        <br>
        <label class="labels" for="" >EMPRESA: </label>
        @if(isset($project->company))
        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física', $project->company)}}
        @else
        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física')}}
        @endif
        <label class="labels" for="" >
            CONTATO:
        </label>
        <select name="contact_id">
            @if(isset($project->contact))
            <option  class="fields" value="{{$project->contact_id}}">
                {{$project->contact->name}}
            </option>
            @else
            <option  class="fields" value="">
                não possui
            </option>
            @endif
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{$contact->id}}">
                {{$contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >
            DATA DE CRIAÇÃO:
        </label>
        <input type="date" name="date_start" size="20" value="{{date('Y-m-d', strtotime($project->date_start))}}">
        <br>
                <label class="labels" for="" >
                    PRAZO FINAL:
                </label>
        <input type="date" name="date_due" size="20" value="{{date('Y-m-d', strtotime($project->date_due))}}">
        @if ($errors->has('date_due'))
        <span class="text-danger">{{$errors->first('date_due')}}</span>
        @endif
        <br>
        <br>
        <label class="labels" for="" >
            DESCRIÇÃO:
        </label>
        <textarea id="description" name="description" rows="20" cols="90">
		{{$project->description}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        
        <label class="labels" for="" >DATA DE CONCLUSÃO:</label>
                @if($project->date_conclusion)
        <input type="date" name="date_conclusion" size="20" value="{{date('Y-m-d', strtotime($project->date_conclusion))}}">
        @else
        <input type="date" name="date_conclusion" size="20">
        @endif
        
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status, $project->status)}}
        <br>
        <br>
        <div style="text-align: right">
            <input class="btn btn-secondary" style="float:right;text-align: right;margin-left: 5px" type="submit" value="SALVAR">
            </form>
            <form   style="text-decoration: none;display: inline-block" action="{{route('project.destroy', ['project' => $project->id])}}" method="post">
                @csrf
                @method('delete')
                <input class="btn btn-danger" type="submit" value="APAGAR">
            </form>
            <a class="btn btn-secondary" href=" {{route('project.index')}} "  style="text-decoration: none;color: white;display: inline-block">
                <i class='fas fa-arrow-alt-circle-left'></i><i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <br>
        </div>
        <br>
        <br>
        @endsection