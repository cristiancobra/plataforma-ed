@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('task.index')}}">
    <i class="fas fa-arrow-left"></i>
</a>
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
    <form action=" {{route('task.store')}} " method="post" style="color: #874983">
        @csrf
        <label class="labels" for="" >NOME:</label>
        @if(!empty(app('request')->input('taskName')))
        <input type="text" name="name" value="{{app('request')->input('taskAccountId')}}">
        @else
        <input type="text" name="name" value="{{old('name')}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        @endif
        <br>
        <label class="labels" for="" >EMPRESA:</label>
        @if(!empty(app('request')->input('taskAccountName')))
        {{app('request')->input('taskAccountName')}}
        <input type="hidden" name="account_id" value="{{app('request')->input('taskAccountId')}}">
        @else
        {{createDoubleSelectIdName('account_id', 'fields', $accounts)}}
        @endif
        <br>
        @if(!empty(app('request')->input('opportunity_id')))
        <label class="labels" for="" >OPORTUNIDADE:</label>
        {{app('request')->input('opportunity_name')}}
        <input type="hidden" name="opportunity_id" value="{{app('request')->input('opportunity_id')}}">
        <br>
        @endif
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