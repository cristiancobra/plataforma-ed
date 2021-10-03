@extends('layouts/show')

@section('title','IMAGENS')

@section('image-top')
"data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnPjxwYXRoIGQ9Im02LjI1IDE5LjVjLTEuNjAxIDAtMy4wMjUtMS4wMjUtMy41NDItMi41NTFsLS4wMzUtLjExNWMtLjEyMi0uNDA0LS4xNzMtLjc0NC0uMTczLTEuMDg0di02LjgxOGwtMi40MjYgOC4wOThjLS4zMTIgMS4xOTEuMzk5IDIuNDI2IDEuNTkyIDIuNzU1bDE1LjQ2MyA0LjE0MWMuMTkzLjA1LjM4Ni4wNzQuNTc2LjA3NC45OTYgMCAxLjkwNi0uNjYxIDIuMTYxLTEuNjM1bC45MDEtMi44NjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjxwYXRoIGQ9Im05IDljMS4xMDMgMCAyLS44OTcgMi0ycy0uODk3LTItMi0yLTIgLjg5Ny0yIDIgLjg5NyAyIDIgMnoiIGZpbGw9IiM4NzQ5ODMiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiPjwvcGF0aD48L2c+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMjEuNSAyaC0xNWMtMS4zNzggMC0yLjUgMS4xMjItMi41IDIuNXYxMWMwIDEuMzc4IDEuMTIyIDIuNSAyLjUgMi41aDE1YzEuMzc4IDAgMi41LTEuMTIyIDIuNS0yLjV2LTExYzAtMS4zNzgtMS4xMjItMi41LTIuNS0yLjV6bS0xNSAyaDE1Yy4yNzYgMCAuNS4yMjQuNS41djcuMDk5bC0zLjE1OS0zLjY4NmMtLjMzNS0uMzkzLS44Mi0uNjAzLTEuMzQxLS42MTUtLjUxOC4wMDMtMS4wMDQuMjMzLTEuMzM2LjYzMWwtMy43MTQgNC40NTgtMS4yMS0xLjIwN2MtLjY4NC0uNjg0LTEuNzk3LS42ODQtMi40OCAwbC0yLjc2IDIuNzU5di05LjQzOWMwLS4yNzYuMjI0LS41LjUtLjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjwvc3ZnPg=="
@endsection

@section('buttons')
{{createButtonEdit('image', 'image', $image)}}
{{createButtonList('image')}}
@endsection

@section('name', $image->name)

@section('priority')
{{formatShowType($image)}}
@endsection


@section('status')
{{formatShowStatus($image)}}
@endsection


@section('fieldsId')
<div class='col-lg-12 col-xs-6' style='text-align: center'>
    <div class='image-show'>
        <img src='{{asset($image->path)}}' width='100%' heigh='100%'>
    </div>
</div>
@endsection


@section('description')
{!!html_entity_decode($image->alt)!!}
@endsection


@section('main')
@endsection

@section('deleteButton', route('image.destroy', ['image' => $image->id]))

@section('editButton', route('image.edit', ['image' => $image->id]))

@section('backButton', route('image.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($image->created_at))}}
    </div>
</div>
@endsection