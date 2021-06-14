@extends('layouts/master')

@section('title','QUESTÕES')

@section('image-top')
{{ asset('imagens/question.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('question.create')}}">
    CRIAR
</a>
@endsection

@section('main')
<div>
    <br>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 20%">
                CRITÉRIO
            </td>
            <td   class="table-list-header" style="width: 60%">
                QUESTÃO
            </td>
            <td   class="table-list-header"style="width: 20%">
                STATUS
            </td>
        </tr>

        @foreach ($questions as $question)
        <tr style="font-size: 16p">
            <td class="table-list-left" style="padding-top: 40px;padding-bottom: 10px">
                <a class="button-round" href=" {{route('question.edit', ['question' => $question])}}">
                    <i class='fa fa-edit'></i>
                </a>
                {{$question->criterion}}
            </td>
            <td class="table-list-left">
                {!!html_entity_decode($question->question)!!}
            </td>
            <td class="button-active">
                {{$question->status }}
            </td>
        <tr>
            <td class="table-list-left" colspan="3">
                RESPOSTA 1:
                <br>
                <br>
                	{!!html_entity_decode($question->answer1)!!}
            </td>
        </tr>
        <tr>
            <td class="table-list-left" colspan="3">
                RESPOSTA 2:
                <br>
                <br>
                {!!html_entity_decode($question->answer2)!!}
            </td>
        </tr>
        <tr>
            <td class="table-list-left" colspan="3">
                RESPOSTA 3:
                <br>
                <br>
                {!!html_entity_decode($question->answer3)!!}
            </td>
        </tr>
        @endforeach
    </table>
</div>
<br>
@endsection
