@extends('layouts/master')

@section('title','IMAGENS')

@section('image-top')
{{asset('images/image.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('image')}}
@endsection

@section('main')
<div>
    <form action=" {{route('image.update', ['image' =>$image->id])}} " method="post" enctype='multipart/form-data'>
        @csrf
        @method('put')
        <div class='container text-center'>
            <div class='image-show'>
                <img src='{{asset($image->path)}}' width='100%' height='100%'>
            </div>
            <input  type='file' name='image'>
        </div>
        <br>
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
        <select name="user_id">
            <option  class="fields" value="{{$image->user_id}}">
                {{$image->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->name}}
            </option>
            @endforeach
        </select>
         <br>
        <label class="labels" for="" >NOME:</label>
        <input type='text' class='fields' name='name' size='50' value='{{$image->name}}'>
        <br>
        <br>
        <label class="labels" for="" >TEXTO ALTERNATIVO:</label>
        <br>
        @if ($errors->has('alt'))
        <span class="text-danger">{{ $errors->first('alt') }}</span>
        @endif
        <textarea id="alt" name="alt" rows="10" cols="90" >
{{$image->alt}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('alt');
        </script>
        <br>
        <br>
        <label class="labels" for="">TIPO:</label>
        {{createSimpleSelect('type', 'fields', $types, $image->type)}}
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status, $image->status)}}
        <br>
        <br>
        <div>
            <input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">
            </form>
            <a class="btn btn-secondary" style="display:inline-block" href=" https://acadia.mxroute.com:2083/" target="_blank">
                <i class='fa fa-edit'></i>EDITAR
            </a>
        </div>
</div>
<br>
<br>
@endsection