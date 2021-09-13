@extends('layouts/show')

@section('title','TEXTOS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonTrash($text, 'text')}}
{{createButtonEdit('text', 'text', $text)}}
{{createButtonList('text')}}
@endsection

@section('name', $text->name)

@section('priority')
{{formatShowType($text)}}
@endsection


@section('status')
{{formatShowStatus($text)}}
@endsection


@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>

    @if(isset($text->user->contact->name))
    <a href=' {{route('user.show', ['user' => $text->user_id])}}'>
        <div class='show-field-end'>
            {{$text->user->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        foi excluído
    </div>
    @endif
</div>

<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        {{$text->department}}
    </div>
</div>
@endsection


@section('description')
<br>
{{$text->title}}
<br>
<br>
{{$text->text}}
<br>
<br>
@endsection

@section('editButton', route('text.edit', ['text' => $text->id]))

@section('backButton', route('text.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($text->created_at))}}
    </div>
</div>
@endsection
