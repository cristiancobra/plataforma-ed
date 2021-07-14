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
<div>
    <form action=" {{route('task.store')}} " method="post" enctype='multipart/form-data'>
        @csrf
        <label class="labels" for="" >NOME:</label>
        @if(!empty(app('request')->input('task_name')))
        <input type="text" name="name" value="{{app('request')->input('task_name')}}" style="width: 600px">
        @else
        <input type="text" name="name" value="{{old('name')}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        @endif
        <br>
        <label class="labels" for="" >DEPARTAMENTO:</label>
        @if(!empty(app('request')->input('department')))
        {{app('request')->input('department')}}
        <input type="hidden" name="department"value="{{app('request')->input('department')}}">
        @elseif($errors->has('department'))
        <span class="text-danger">{{$errors->first('department')}}</span>
        @else
        {{createSimpleSelect('department', 'fields', $departments)}}
        @endif
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
        {{createSelectUsers('fields', $users)}}
        <br>
        <br>
        <label class="labels" for="" >OPORTUNIDADE:</label>
        @if(!empty(app('request')->input('opportunity_id')))
        {{app('request')->input('opportunity_name')}}
        <input type="hidden" name="opportunity_id" value="{{app('request')->input('opportunity_id')}}">
        @else
        <select class = 'fields' name='opportunity_id' style='width:700px'>
            <option value=''>
                Não possui
            </option>
            @foreach ($opportunities as $opportunity)
            @if(old('opportunity_id') == $opportunity->id)
            <option value='{{$opportunity->id}}' selected='selected'>
                {{$opportunity->name}}
            </option>
            @endif
            <option value='{{$opportunity->id}}'>
                {{$opportunity->date_start}}  //  
                @if($opportunity->company)
                {{$opportunity->company->name}}  --
                @endif
                {{$opportunity->contact->name}}  --  {{$opportunity->name}}
            </option>
            @endforeach
        </select>
        @endif
        <br>
        <label class="labels" for="" >DATA DE CRIAÇÃO:</label>
        <input type="date" name="date_start" value="{{$today}}">
        @if ($errors->has('date_start'))
        <span class="text-danger">{{ $errors->first('date_start') }}</span>
        @endif
        <br>
        <label class="labels" for="" >PRAZO FINAL:</label>
        <input type="date" name="date_due" value="{{old('date_due')}}">
        @if ($errors->has('date_due'))
        <span class="text-danger">{{$errors->first('date_due')}}</span>
        @endif
        <br>
        <label class="labels" for="" >PONTOS:</label>
        <input type='number' value='{{old('points')}}' style="text-align: right;width: 100px">
        <br>
        <br>
        <label class="labels" for="" >DESCRIÇÃO:</label>
        <br>
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
        <br>
        <label class='labels' for='' >ANEXAR IMAGEM:</label>
        <input type='file' name='image'>
        <br>
        <br>
        <label class="labels" for="" >CONTATO: </label>
        @if(!empty(app('request')->input('contact_id')))
        <input type="hidden" name="contact_id" value="{{app('request')->input('contact_id')}}">
        {{app('request')->input('contact_name')}}
        @else
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts)}}
        @endif
        <br>
        <label class="labels" for="" >EMPRESA: </label>
        @if(!empty(app('request')->input('company_id')))
        <input type="hidden" name="company_id" value="{{app('request')->input('company_id')}}">
        {{app('request')->input('company_name')}}
        @else
        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física')}}
        @endif
        <br>
        <label class="labels" for="" >PRIORIDADE:</label>
        {{createSimpleSelect('priority', 'fields', $priorities)}}
        <br>
        <br>
        <p style="text-align: right">
            <input class="btn btn-secondary" type="submit" value="CRIAR TAREFA">
        </p>
    </form>
</div>
<br>
<br>
@endsection