@extends('layouts/master')

@section('title','TEXTOS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('text')}}
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
    <form action=' {{route('text.store')}} ' method='post' enctype='multipart/form-data'>
        @csrf
        <label class='labels' for='' >NOME INTERNO:</label>
        <input type='text' name='name' style='width: 600px' value='{{old('name')}}'>
        @if ($errors->has('name'))
        <span class='text-danger'>{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class='labels' for='' >TÍTULO PÚBLICO:</label>
        <input type='title' name='title' style='width: 600px' value='{{old('title')}}'>
        @if ($errors->has('title'))
        <span class='text-danger'>{{$errors->first('title')}}</span>
        @endif
        <br>
        <label class='labels' for='' >DEPARTAMENTO:</label>
        {{createSimpleSelect('department', 'fields', $departments)}}
        @if ($errors->has('department'))
        <span class='text-danger'>{{$errors->first('department')}}</span>
        @endif
        <br>
        <br>
        <label class='labels' for='' >TEXTO:</label>
        <br>
        @if ($errors->has('text'))
        <span class='text-danger'>{{$errors->first('text')}}</span>
        @endif
        <textarea id='text' name='text' rows='20' cols='90'>
  {{old('text')}}
        </textarea>
                <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('text');
        </script>
        <br>
        <label class='labels' for='' >ANEXAR IMAGEM:</label>
        <input type='file' name='image'>
        <br>
        <br>

        @if(app('request')->input('type') == 'proposta de valor')
        <input type='hidden' name='type' value='proposta de valor'>
        @elseif(app('request')->input('type') == 'apresentação da empresa')
        <input type='hidden' name='type' value='apresentação da empresa'>
        @elseif(app('request')->input('type') == 'força')
        <input type='hidden' name='type' value='força'>
        @else
        <label class='labels' for='' >TIPO:</label>
        {{createSimpleSelect('type', 'fields', $types)}}
        <br>
        @endif

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