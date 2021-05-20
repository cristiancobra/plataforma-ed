@extends('layouts/master')

@section('title','IMAGEM')

@section('image-top')
"data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnPjxwYXRoIGQ9Im02LjI1IDE5LjVjLTEuNjAxIDAtMy4wMjUtMS4wMjUtMy41NDItMi41NTFsLS4wMzUtLjExNWMtLjEyMi0uNDA0LS4xNzMtLjc0NC0uMTczLTEuMDg0di02LjgxOGwtMi40MjYgOC4wOThjLS4zMTIgMS4xOTEuMzk5IDIuNDI2IDEuNTkyIDIuNzU1bDE1LjQ2MyA0LjE0MWMuMTkzLjA1LjM4Ni4wNzQuNTc2LjA3NC45OTYgMCAxLjkwNi0uNjYxIDIuMTYxLTEuNjM1bC45MDEtMi44NjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjxwYXRoIGQ9Im05IDljMS4xMDMgMCAyLS44OTcgMi0ycy0uODk3LTItMi0yLTIgLjg5Ny0yIDIgLjg5NyAyIDIgMnoiIGZpbGw9IiM4NzQ5ODMiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiPjwvcGF0aD48L2c+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMjEuNSAyaC0xNWMtMS4zNzggMC0yLjUgMS4xMjItMi41IDIuNXYxMWMwIDEuMzc4IDEuMTIyIDIuNSAyLjUgMi41aDE1YzEuMzc4IDAgMi41LTEuMTIyIDIuNS0yLjV2LTExYzAtMS4zNzgtMS4xMjItMi41LTIuNS0yLjV6bS0xNSAyaDE1Yy4yNzYgMCAuNS4yMjQuNS41djcuMDk5bC0zLjE1OS0zLjY4NmMtLjMzNS0uMzkzLS44Mi0uNjAzLTEuMzQxLS42MTUtLjUxOC4wMDMtMS4wMDQuMjMzLTEuMzM2LjYzMWwtMy43MTQgNC40NTgtMS4yMS0xLjIwN2MtLjY4NC0uNjg0LTEuNzk3LS42ODQtMi40OCAwbC0yLjc2IDIuNzU5di05LjQzOWMwLS4yNzYuMjI0LS41LjUtLjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjwvc3ZnPg=="
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
            <div class='product-image'>
                <img src=
                     "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnPjxwYXRoIGQ9Im02LjI1IDE5LjVjLTEuNjAxIDAtMy4wMjUtMS4wMjUtMy41NDItMi41NTFsLS4wMzUtLjExNWMtLjEyMi0uNDA0LS4xNzMtLjc0NC0uMTczLTEuMDg0di02LjgxOGwtMi40MjYgOC4wOThjLS4zMTIgMS4xOTEuMzk5IDIuNDI2IDEuNTkyIDIuNzU1bDE1LjQ2MyA0LjE0MWMuMTkzLjA1LjM4Ni4wNzQuNTc2LjA3NC45OTYgMCAxLjkwNi0uNjYxIDIuMTYxLTEuNjM1bC45MDEtMi44NjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjxwYXRoIGQ9Im05IDljMS4xMDMgMCAyLS44OTcgMi0ycy0uODk3LTItMi0yLTIgLjg5Ny0yIDIgLjg5NyAyIDIgMnoiIGZpbGw9IiM4NzQ5ODMiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiPjwvcGF0aD48L2c+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMjEuNSAyaC0xNWMtMS4zNzggMC0yLjUgMS4xMjItMi41IDIuNXYxMWMwIDEuMzc4IDEuMTIyIDIuNSAyLjUgMi41aDE1YzEuMzc4IDAgMi41LTEuMTIyIDIuNS0yLjV2LTExYzAtMS4zNzgtMS4xMjItMi41LTIuNS0yLjV6bS0xNSAyaDE1Yy4yNzYgMCAuNS4yMjQuNS41djcuMDk5bC0zLjE1OS0zLjY4NmMtLjMzNS0uMzkzLS44Mi0uNjAzLTEuMzQxLS42MTUtLjUxOC4wMDMtMS4wMDQuMjMzLTEuMzM2LjYzMWwtMy43MTQgNC40NTgtMS4yMS0xLjIwN2MtLjY4NC0uNjg0LTEuNzk3LS42ODQtMi40OCAwbC0yLjc2IDIuNzU5di05LjQzOWMwLS4yNzYuMjI0LS41LjUtLjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjwvc3ZnPg=="
                      width='100%' height='100%'>
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
        {{createSimpleSelect('type', 'fields', $types)}}
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status)}}
        <br>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
    <br>
    <br>
</div>     
@endsection