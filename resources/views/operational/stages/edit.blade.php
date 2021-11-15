@extends('layouts/master')

@section('title', $title)

@section('image-top')
{{asset('images/financeiro.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonList('stage')}}
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
    <form action=" {{route('stage.update', ['stage' =>$stage->id])}} " method="post">
        @csrf
        @method('put')
        @if($stage->department == 'desenvolvimento')
        <input type="hidden" name="department" value="{{$stage->department}}">
        @endif
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" style="width: 700px" value="{{$stage->name}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
        <select name="user_id">
            <option  class="fields" value="{{$stage->user_id}}">
                {{$stage->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->contact->name}}
            </option>
            @endforeach
        </select>
                <br>
        <label class="labels" for="" >
            DATA DE CRIAÇÃO:
        </label>
        <input type="date" name="start" size="20" value="{{date('Y-m-d', strtotime($stage->start))}}">
        <br>
                <label class="labels" for="" >
                    PRAZO FINAL:
                </label>
        <input type="date" name="end" size="20" value="{{date('Y-m-d', strtotime($stage->end))}}">
        @if ($errors->has('end'))
        <span class="text-danger">{{$errors->first('end')}}</span>
        @endif
        <br>
        <br>
        <label class="labels" for="" >
            DESCRIÇÃO:
        </label>
        <textarea id="description" name="description" rows="20" cols="90">
		{{$stage->description}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
        
        <label class="labels" for="" >DATA DE CONCLUSÃO:</label>
                @if($stage->date_conclusion)
        <input type="date" name="date_conclusion" size="20" value="{{date('Y-m-d', strtotime($stage->date_conclusion))}}">
        @else
        <input type="date" name="date_conclusion" size="20">
        @endif
        
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status, $stage->status)}}
        <br>
        <br>
        <div style="text-align: right">
            <input class="btn btn-secondary" style="float:right;text-align: right;margin-left: 5px" type="submit" value="SALVAR">
            </form>
            <form   style="text-decoration: none;display: inline-block" action="{{route('stage.destroy', ['stage' => $stage->id])}}" method="post">
                @csrf
                @method('delete')
                <input class="btn btn-danger" type="submit" value="APAGAR">
            </form>
            <a class="btn btn-secondary" href=" {{route('stage.index')}} "  style="text-decoration: none;color: white;display: inline-block">
                <i class='fas fa-arrow-alt-circle-left'></i><i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <br>
        </div>
        <br>
        <br>
        @endsection