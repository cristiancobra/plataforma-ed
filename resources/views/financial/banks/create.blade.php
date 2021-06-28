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
<br>

@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action=" {{route('bank.store')}} " method="post">
        @csrf
        <label class="labels" for="" >NOME:</label>       
        <input type="text" name="name" style="width:500px" value="{{old('name')}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class="labels" for="" >CÓDIGO:</label>       
        <input type="text" name="bank_code" style="width:150px" value="{{old('bank_code')}}">
        @if ($errors->has('bank_code'))
        <span class="text-danger">{{$errors->first('bank_code')}}</span>
        @endif
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
</div>
<br>
<br>
@endsection