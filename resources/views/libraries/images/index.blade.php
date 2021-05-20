@extends('layouts/master')

@section('title','IMAGENS')

@section('image-top')
"data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnPjxwYXRoIGQ9Im02LjI1IDE5LjVjLTEuNjAxIDAtMy4wMjUtMS4wMjUtMy41NDItMi41NTFsLS4wMzUtLjExNWMtLjEyMi0uNDA0LS4xNzMtLjc0NC0uMTczLTEuMDg0di02LjgxOGwtMi40MjYgOC4wOThjLS4zMTIgMS4xOTEuMzk5IDIuNDI2IDEuNTkyIDIuNzU1bDE1LjQ2MyA0LjE0MWMuMTkzLjA1LjM4Ni4wNzQuNTc2LjA3NC45OTYgMCAxLjkwNi0uNjYxIDIuMTYxLTEuNjM1bC45MDEtMi44NjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjxwYXRoIGQ9Im05IDljMS4xMDMgMCAyLS44OTcgMi0ycy0uODk3LTItMi0yLTIgLjg5Ny0yIDIgLjg5NyAyIDIgMnoiIGZpbGw9IiM4NzQ5ODMiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiPjwvcGF0aD48L2c+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMjEuNSAyaC0xNWMtMS4zNzggMC0yLjUgMS4xMjItMi41IDIuNXYxMWMwIDEuMzc4IDEuMTIyIDIuNSAyLjUgMi41aDE1YzEuMzc4IDAgMi41LTEuMTIyIDIuNS0yLjV2LTExYzAtMS4zNzgtMS4xMjItMi41LTIuNS0yLjV6bS0xNSAyaDE1Yy4yNzYgMCAuNS4yMjQuNS41djcuMDk5bC0zLjE1OS0zLjY4NmMtLjMzNS0uMzkzLS44Mi0uNjAzLTEuMzQxLS42MTUtLjUxOC4wMDMtMS4wMDQuMjMzLTEuMzM2LjYzMWwtMy43MTQgNC40NTgtMS4yMS0xLjIwN2MtLjY4NC0uNjg0LTEuNzk3LS42ODQtMi40OCAwbC0yLjc2IDIuNzU5di05LjQzOWMwLS4yNzYuMjI0LS41LjUtLjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjwvc3ZnPg=="
@endsection


@section('buttons')
<a class="circular-button primary"  href="{{route('image.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div class='row'>
    <div class='tb tb-header-start col-2'>
        IMAGEM
    </div>
    <div class='tb tb-header col-4'>
        NOME
    </div>
    <div class='tb tb-header col-4'>
        TEXTO ALTERNATIVO
    </div>
    <div class='tb tb-header col-1'>
        TIPO
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($images as $image)
<div class='row'>
    <div class='tb col-2'>
        <div class='product-image-small'>
            <a href=' {{route('image.show', ['image' => $image->id])}}'>
                <img src='{{asset($image->path)}}' width='100%' heigh='100%'>
            </a>
        </div>
    </div>
    <div class='tb col-4'>
        {{$image->name}}
    </div>
    <div class='tb col-4'>
        {{$image->alt}}
    </div>
    <div class='tb col-1'>
        {{$image->type}}
    </div>
    <div class='tb col-1'>
        {{$image->status}}
    </div>
</div>
@endforeach
    <div class='row'>
        <div class='tb-footer'></div>
    </div>
<br>
@endsection
