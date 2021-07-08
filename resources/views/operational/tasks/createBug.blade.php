@extends('layouts/master')

@section('title','BUGS')

@section('image-top')
{{ asset('images/task.png') }} 
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
    <form action=" {{route('task.storeBug')}} " method="post">
        @csrf
        <input type="hidden" name="department"value="desenvolvimento">
        <input type="hidden" name="user_id"value="7">
        <input type="hidden" name="date_start" value="{{date('Y-m-d')}}">
        <br>
        <label class="labels" for="" >RELATADO POR: </label>
        <input type="hidden" name="contact_id" value="{{auth()->user()->contact_id}}">
                {{auth()->user()->contact->name}}
                <br>
                <span class="labels">da</span>
                {{auth()->user()->account->name}}
        <br>
        <br>
        <label class="labels" for="" >PRIORIDADE:</label>
            {{createSimpleSelect('priority', 'fields', $priorities)}}
        <br>
        <br>
        <label class="labels" for="" >ONDE OCORREU:</label>
        {{createSimpleSelect('module', 'select', $modules)}}
        <br>
        <label class="labels" for="" >O QUE VOCÊ ESTÁVA FAZENDO:</label>
        {{createSimpleSelect('action', 'select', $actions)}}
        <br>
        <br>
        <label class="labels" for="" >OBSERVAÇÕES:</label>
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
        <p style="text-align: right">
            <input class="btn btn-secondary" type="submit" value="REPORTAR BUG">
        </p>
    </form>
</div>
<br>
<br>
@endsection