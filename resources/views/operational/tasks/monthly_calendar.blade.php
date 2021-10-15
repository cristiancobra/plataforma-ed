@extends('layouts/master')

@section('title','AGENDA')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 ms-1 me-1'>
    <div class='col tb-header-start' style='background-color:{{$principalColor}}' >
        SEGUNDA
    </div>
    <div class='col tb-header' style='background-color:{{$principalColor}}' >
        TERÇA
    </div>
    <div class='col tb-header' style='background-color:{{$principalColor}}' >
        QUARTA
    </div>
    <div class='col tb-header' style='background-color:{{$principalColor}}' >
        QUINTA
    </div>
    <div class='col tb-header' style='background-color:{{$principalColor}}' >
        SEXTA
    </div>
    <div class='col tb-header' style='background-color:{{$principalColor}}' >
        SÁBADO
    </div>
    <div class='col tb-header-end' style='background-color:{{$principalColor}}' >
        DOMINGO
    </div>
</div>

@while($totalDays >= $day)

@if($counter == 1 OR $counter == 8 OR $counter == 15 OR $counter == 22 OR $counter == 29)
<div class='row ms-1 me-1'>
    @endif

    @if($counter == 1)
    @for ($i = 0; $i < $nullDays; $i++)
    <div class='col tb' id='{{$counter++}}'>
    </div>
    @endfor
    @else
    <div class='col tb d-flex justify-content-start' style='font-size: 36px;color:{{$oppositeColor}}' id='{{$counter++}}'>
        <div class="col-3">
            <div class='row justify-content-center'>
                {{$day++}}
            </div>
            <div class='row justify-content-center'>
                <a class='circular-button-mini primary' style='display: inline-block;float: right' href='{{route('task.create', ['date_due' => date("Y-m-$day")])}}'>
                    <i class='fa fa-plus text-center ' aria-hidden='true'></i>
                </a>
            </div>
        </div>
        <div class="col-8">
            @foreach($myTasks as $task)
            @if(date('Y-m-d', strtotime($task->date_due)) == date("Y-m-$day"))
            <div class='row mb-1'>
                <div class='col-4 text-end my-auto' style='color: {{$principalColor}};font-weight: 600;font-size:12px'>
                    {{date('H:i', strtotime($task->date_due))}}
                </div>
                <div class='col-8 justify-content-start task-mini'>
                    <a style='text-decoration:none' href='{{route('task.show', ['task' => $task->id])}}'>
                        <span  style='font-weight: 600;font-size:12px'>
                            {{$task->name}}
                        </span>
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>


    @if($counter == 8 OR $counter == 15 OR $counter == 22 OR $counter == 29 OR $totalDays < $day)
</div>
@endif

@endif
@endwhile


@endsection