@extends('layouts/master')

@section('title','EMAIL')

@section('image-top')
{{asset('images/email.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('email')}}
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
	<form action="{{route('email.store')}}" method="post" style="color: #874983">
		@csrf
		<label class="labels" for="" >EMPRESA: </label>
		@if(!empty(app('request')->input('taskAccountId')))
		{{app('request')->input('taskAccountName')}}
		<input type="hidden" name="account_id" value="{{app('request')->input('taskAccountId')}}">
		@else
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
			@endif
		</select>
		<br>
		<label class="labels" for="" >FUNCIONÁRIO: </label>
		{{Auth::user()->contact->name}}
		<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
		<br>
		<br>
		<label class="labels" for="" >TÍTULO:</label>
		<input type='text' class='fields' name='title' size='50'>
		<br>
		<label class="labels" for="" >MENSAGEM:</label>
		<br>
		@if ($errors->has('message'))
		<span class="text-danger">{{ $errors->first('message') }}</span>
		@endif
		<textarea id="description" name="message" rows="10" cols="90"  value="{{old('message')}}">
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('message');
		</script>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
	<br>
	<br>
</div>     
@endsection