@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('task.index')}}">
    VOLTAR
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
        <input type="text" name="name" value="{{$taskName}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
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
        @if(!empty(app('request')->input('opportunityName')))
        <label class="labels" for="" >OPORTUNIDADE:</label>
        {{app('request')->input('opportunityName')}}
        <input type="hidden" name="opportunity_id" value="{{app('request')->input('opportunityId')}}">
        <br>
        @endif
        <label class="labels" for="" >DEPARTAMENTO:</label>
        @if(!empty(app('request')->input('department')))
        {{app('request')->input('department')}}
        <input type="hidden" name="department"value="{{app('request')->input('department')}}">
        @elseif($errors->has('department'))
        <span class="text-danger">{{$errors->first('department')}}</span>
        @else
        <select class="fields" name="department">
            {{createSimpleSelect($departments)}}
        </select>
        @endif
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
        <select name="user_id">
            <option  class="fields" value="{{Auth::user()->id}}">
                Eu
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->contact->name}}
            </option>
            @endforeach
        </select>
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
        @if(!empty(app('request')->input('opportunityContactName')))
        <select name="contact_id">
            <option  class="fields" value="{{app('request')->input('opportunityContactId')}}">
                {{app('request')->input('opportunityContactName')}}
            </option>
        </select>
        @endif
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts)}}
        <br>
        <label class="labels" for="" >EMPRESA: </label>
        @if(!empty(app('request')->input('opportunityCompanyName')))
        <select name="company_id">
            <option  class="fields" value="{{app('request')->input('opportunityCompanyName')}}">
                {{app('request')->input('opportunityCompanyName')}}
            </option>
        </select>
        @endif
        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física')}}
        <br>
        <label class="labels" for="" >PRIORIDADE:</label>
        <select class="fields" name="priority">
            {{createSimpleSelect($priorities)}}
        </select>
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