@extends('layouts/show')

@section('title','TEXTOS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')

{{createButtonTrash($text, 'text')}}
{{createButtonEdit('text', 'text', $text)}}
{{createButtonList('text')}}
@endsection

@section('name', $text->name)



@section('priority', $priority)


@section('status', $status)


@section('fieldsId')
<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>

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

<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
    <div class='show-label'>
        PÁGINAS
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>
    <div class='show-field-end'>
        {{$text->department}}
    </div>
    @if($pages == null)
    <div class='show-field-end'>
        não vinculado
    </div>
    @else
    @foreach($pages as $page)
    <a href=' {{route('page.edit', ['page' => $page])}}'>
        <div class='show-field-end'>
            {{$page->name}}
        </div>
    </a>
    @endforeach
    @endif
</div>
@endsection


@section('description')
<br>
{!!html_entity_decode($text->title)!!}
<br>
<br>
          {!!html_entity_decode($text->text)!!}

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
