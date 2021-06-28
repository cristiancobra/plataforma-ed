@extends('layouts/master')

@section('title','BANCOS')


@section('image-top')
{{asset('images/bank.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('bank')}}
@endsection

@section('main')
<div>
    <form action=" {{route('bank.update', ['bank' =>$bank->id])}} " method="post">
        @csrf
        @method('put')
          <label class="labels" for="" >NOME:</label>       
        <input type="text" name="name" style="width:500px" value="{{$bank->name}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class="labels" for="" >CÓDIGO:</label>       
        <input type="text" name="bank_code" style="width:150px" value="{{$bank->bank_code}}">
        @if ($errors->has('bank_code'))
        <span class="text-danger">{{$errors->first('bank_code')}}</span>
        @endif
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
</div>
<br>
<br>
@endsection