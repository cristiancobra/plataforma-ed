@extends('layouts/master')

@section('title', 'PROJETOS')

@section('image-top')
{{ asset('images/financeiro.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('project')}}
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{ Session::get('failed') }}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action=" {{route('project.store')}} " method="post" style="color: #874983">
        @csrf
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="60" value="{{old('name')}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name') }}</span>
        @endif
        <br>
        <label class="labels" for="" >METAS: </label>
        {{createSelectIdName('goal', 'fields', $goals, 'Não possui')}}
        <br>
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
        {{createSelectUsers('fields', $users)}}
        <br>
        <br>
        @if($department != 'desenvolvimento')
        <label class="labels" for="" >EMPRESA: </label>
        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física')}}
        {{createButtonAdd('company.create', 'typeCompanies', 'cliente')}}
        <br>
        @endif
        <label class="labels" for="" >CONTATO: </label>
        @if(!empty(app('request')->input('contact_id')))
        <input type="hidden" name="contact_id" value="{{app('request')->input('contact_id')}}">
        {{app('request')->input('contact_name')}}
        @else
        {{createDoubleSelectIdName('contact_id', 'fields', $contacts)}}
        @endif
        {{createButtonAdd('contact.create')}}
        <br>
        <br>
        <label class="labels" for="" >DATA DE CRIAÇÃO:</label>
        <input type="date" name="date_start" size="20"  value="{{old('date_start')}}">
        @if ($errors->has('date_start'))
        <span class="text-danger">{{$errors->first('date_start')}}</span>
        @endif
        <br>
        <label class="labels" for="" >PRAZO FINAL:</label>
        <input type="date" name="date_due" size="20" value="{{old('date_due')}}">
        @if ($errors->has('date_due'))
        <span class="text-danger">{{$errors->first('date_due')}}</span>
        @endif
        <br>
        <label class="labels" for="" >DATA DA CONCLUSÃO:</label>
        <input type="date" name="date_conclusion" size="20" value="{{old('date_conclusion')}}">
        @if ($errors->has('date_conclusion'))
        <span class="text-danger">{{$errors->first('date_conclusion')}}</span>
        @endif
        <br>
        <br>
        <label class="labels" for="" >DESCRIÇÃO:</label>
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

        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status)}}
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
</div>
<br>
<br>
@endsection