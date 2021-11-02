@extends('layouts/master')

@section('title','DESENVOLVIMENTO')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3 ms-1 me-1'>
    <div class="col">
                    <p class='h2' style='color: {{$principalColor}}'>
        METAS
                    </p>
    </div>
</div>
<div class='row mt-2 mb-3 ms-1 me-1'>
     
        <div class='col d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('opportunity.index', ['department' => 'desenvolvimento'])}}'>
            <p class='panel-text'>
                <i class='fas fa-flask' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                METAS
            </p>
        </a>
    </div>
     
        <div class='col d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('opportunity.index', ['department' => 'desenvolvimento'])}}'>
            <p class='panel-text'>
                <i class='fas fa-flask' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                PROJETOS
            </p>
        </a>
    </div>
     
        <div class='col d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('task.index', ['department' => 'desenvolvimento'])}}'>
            <p class='panel-text'>
                <i class='fas fa-check' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                TAREFAS
            </p>
        </a>
    </div>
   
</div>

@endsection