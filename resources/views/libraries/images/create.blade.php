@extends('layouts/master')

@section('title','IMAGEM')

@section('image-top')
{{asset('imagens/image.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('image')}}
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
    <form action="{{route('image.store')}}" method="post" enctype='multipart/form-data'>
        @csrf
        <div class='container text-center'>
            <div class='profile-picture'>
                <img src='{{asset('imagens/colaborador.png')}}' width='100%' height='100%'>
            </div>
            <input  type='file' name='image'>
        </div>
        <br>
        <br>
        <label class="labels" for="" >EMPRESA: </label>
        @if(!empty(app('request')->input('taskAccountId')))
        {{app('request')->input('taskAccountName')}}
        <input type="hidden" name="account_id" value="{{app('request')->input('taskAccountId')}}">
        @else
        <select name="account_id">
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
            @endif
        </select>
        <br>
        <label class="labels" for="">NOME:</label>
        <input type='text' class='fields' name='name' size='50'>
        <br>
        <label class="labels" for="" >TEXTO ALTERNATIVO:</label>
        <br>
        @if ($errors->has('alt'))
        <span class="text-danger">{{$errors->first('alt')}}</span>
        @endif
        <textarea id="description" name="alt" rows="10" cols="90"  value="{{old('alt')}}">
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('alt');
        </script>
        <br>
        <label class="labels" for="">TIPO:</label>
        <input type='text' class='fields' name='type' size='50'>
        <br>
        <label class="labels" for="">STATUS:</label>
        <input type='text' class='fields' name='status' size='50'>
        <br>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
    <br>
    <br>
</div>     
@endsection