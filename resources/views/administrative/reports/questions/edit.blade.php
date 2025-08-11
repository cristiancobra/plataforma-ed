@extends('layouts/master')

@section('title','QUESTÕES')

@section('image-top')
{{asset('images/question.png')}} 
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('question.index')}}">
    VOLTAR
</a>
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
    <form action="{{route('question.update', ['question' => $question])}}" method="post">
        @csrf
        @method('put')
        <label class="labels" for="" >CRITÉRIO:</label>
        <input type='text' class='fields' name='criterion' size='50' value='{{$question->criterion}}'>
        <br>
        <label class="labels" for="" >QUESTÃO:</label>
        <br>
        <textarea id="question" name="question" rows="10" cols="90">
{{$question->question}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('question');
        </script>
        <br>
        <br>
        <label class="labels" for="" >RESPOSTA 1:</label>
        <br>
        <textarea id="answer1" name="answer1" rows="10" cols="90">
{{$question->answer1}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('answer1');
        </script>
        <br>
        <br>
        <label class="labels" for="" >RESPOSTA 2:</label>
        <br>
        <textarea id="answer2" name="answer2" rows="10" cols="90">
{{$question->answer2}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('answer2');
        </script>
        <br>
        <br>
        <label class="labels" for="" >RESPOSTA 3:</label>
        <br>
        <textarea id="answer3" name="answer3" rows="10" cols="90">
{{$question->answer3}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('answer3');
        </script>
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
            {{createSimpleSelect('status', 'fields', $status, $question->status)}}
            <br>
            <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
    <br>
    <br>
</div>
<!--===================================     FOOTER     ===================================--> 

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;color: black;display: inline-block" action="{{ route('question.destroy', ['question' => $question->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href="{{route('question.index')}}">
		<i class="fas fa-arrow-left"></i>
	</a>
</div>
@endsection