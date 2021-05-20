@extends('layouts/master')

@section('title','IMAGENS')

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
<div>
    <form action=" {{route('image.update', ['image' =>$image->id])}} " method="post" enctype='multipart/form-data'>
        @csrf
        @method('put')
        <div class='col-lg-12 col-xs-6' style='text-align: center'>
        <div class='container text-center'>
            <div class='image-show'>
                <img src='{{asset($image->path)}}' width='100%' height='100%'>
            </div>
            <input  type='file' name='image'>
        </div>
        <br>
        <br>
        <label class="labels" for="" >EMPRESA:</label>
        <select name="account_id">
            <option  class="fields" value="{{$image->account_id}}">
                {{$image->account->name}}
            </option>
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >NOME:</label>
        <input type='text' class='fields' name='name' size='50' value='{{$image->name}}'>
        <br>
        <label class="labels" for="" >TEXTO ALTERNATIVO:</label>
        <br>
        @if ($errors->has('alt'))
        <span class="text-danger">{{ $errors->first('alt') }}</span>
        @endif
        <textarea id="alt" name="message" rows="10" cols="90" >
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