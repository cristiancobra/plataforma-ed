@extends('layouts/master')

@section('title','METAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('goal')}}
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
    <form action=' {{route('goal.store')}} ' method='post' enctype='multipart/form-data'>
        @csrf
        <label class='labels' for='' >NOME:</label>
        <input type='text' name='name' style='width: 600px' value='{{old('name')}}'>
        @if ($errors->has('name'))
        <span class='text-danger'>{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class='labels' for='' >DEPARTAMENTO:</label>
        {{createSimpleSelect('department', 'fields', $departments)}}
        @if ($errors->has('department'))
        <span class='text-danger'>{{$errors->first('department')}}</span>
        @endif
        <br>
                <br>
        <label class="labels" for="" >INÍCIO:</label>
        <input type="date" name="date_start" value="{{old('date_start') ? old('date_start') : date('Y-m-d')}}">
        @if ($errors->has('date_start'))
        <span class="text-danger">{{$errors->first('date_start')}}</span>
        @endif
        <br>
        <br>
        <label class='labels' for='' >DESCRIÇÃO:</label>
        <br>
        @if ($errors->has('description'))
        <span class='text-danger'>{{$errors->first('description')}}</span>
        @endif
        <textarea id='text' name='description' rows='20' cols='90'>
  {{old('text')}}
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

        <label class='labels' for='' >SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status)}}
        <br>
        <br>
        <p style='text-align: right'>
            <input class='btn btn-secondary' type='submit' value='CRIAR'>
        </p>
    </form>
</div>
<br>
<br>
@endsection