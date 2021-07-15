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
<div>
    <form action=" {{ route('journey.update', ['journey' => $journey]) }} " method="post">
        @csrf
        @method('put')
        <label class="labels" for="" >FUNCIONÁRIO:</label>
        <select name="user_id">
            <option  class="fields" value="{{$journey->user_id}}">
                {{$journey->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >TAREFA: </label>
        <select name="task_id">
            <option value="{{$journey->task->id}}">{{$journey->task->name}}</option>
            @foreach ($tasks as $task)
            <option  class="fields" value="{{ $task->id }}">
                {{ $task->name }}
            </option>
            @endforeach
        </select>
        <a class="circular-button secondary" href="{{ route('task.create') }}" target="blank">
            <i class="fas fa-plus"></i>
        </a>
        <br>
        <br>
        <label class="labels" for="" >OBSERVAÇÕES:</label>
        <br>
        @if ($errors->has('description'))
        <span class="text-danger">{{ $errors->first('description') }}</span>
        @endif
        <textarea id="description" name="description" rows="10" cols="90"  value="{{old('description')}}">
		{{ $journey->description }}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        <label class="labels" for="" >DATA:</label>
        <input type="date" name="date" size="20" value="{{$journey->date}}"><span class="fields"></span>
        @if ($errors->has('date'))
        <span class="text-danger">{{$errors->first('date')}}</span>
        @endif
        <br>
        <label class="labels" for="">
            INÍCIO: 
        </label>
        <input type="time" name="start" size="50"  value="{{date('H:i', strtotime($journey->start))}}"><span class="fields"></span>
        @if ($errors->has('start'))
        <span class="text-danger">{{$errors->first('start')}}</span>
        @endif
        <br>
        <label class="labels" for="">
            TÉRMINO: 
            <br>
        </label>
        <input type="time" name="end" size="50"  value="{{date('H:i', strtotime($journey->end))}}"><span class="fields"></span>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
</div>
<br>
<br>
@endsection