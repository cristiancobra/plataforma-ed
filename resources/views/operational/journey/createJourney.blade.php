@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{ asset('images/journey.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('journey')}}
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
    <form action=" {{route('journey.store')}} " method="post">
        @csrf
        <label class="labels" for="" >FUNCIONÁRIO: </label>
        {{Auth::user()->contact->name}}
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        <br>
        <label class="labels" for="" >TAREFA: </label>
        @if(isset($task))
        {{app('request')->input('taskName')}}
        <input type="hidden" name="name" value="{{app('request')->input('taskName')}}">
        @else
        <select name="task_id">
            <option  class="fields" value="{{app('request')->input('taskId')}}">
                {{app('request')->input('taskName')}}
            </option>
            @foreach ($tasks as $task)
            <option  class="fields" value="{{ $task->id }}">
                {{ $task->name }}
            </option>
            @endforeach
        </select>
        <a class="circular-button secondary" href="{{ route('task.create') }}" target="blank">
            <i class="fas fa-plus"></i>
        </a>
        @endif
        @if ($errors->has('task_id'))
        <span class="text-danger">{{ $errors->first('task_id') }}</span>
        @endif
        <br>
        <br>
        <label class="labels" for="" >OBSERVAÇÕES:</label>
        <br>
        @if ($errors->has('description'))
        <span class="text-danger">{{ $errors->first('description') }}</span>
        @endif
        <textarea id="description" name="description" rows="10" cols="90">
                                    {{old('description')}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <label class="labels" for="" >DATA:</label>
        @if(old('date'))
        <input type="date" name="date" value="{{old('date')}}">
        @else
        <input type="date" name="date" value="{{date('Y-m-d')}}">
        @endif
        @if ($errors->has('date'))
        <span class="text-danger">{{$errors->first('date')}}</span>
        @endif
        <br>
        <label class="labels" for="" >
            INÍCIO: 
        </label>
        @if(old('start'))
        <input type="time" name="start" size="50" value="{{old('start')}}"><span class="fields"></span>
        @else
        <input type="time" name="start" size="50" value="{{date('H:i')}}"><span class="fields"></span>
        @endif
        @if ($errors->has('start'))
        <span class="text-danger">{{ $errors->first('start') }}</span>
        @endif
        <br>
        <label class="labels" for="">
            TÉRMINO: 
            <br>
        </label>
        <input type="time" name="end" size="50"><span class="fields"></span>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
</div>     
@endsection