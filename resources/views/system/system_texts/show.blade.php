@extends('layouts/show')

@section('title','TEXTOS DO SISTEMA')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonEdit('systemText', 'systemText', $systemText)}}
{{createButtonList('systemText')}}
@endsection

@section('name', $systemText->name)

@section('priority')
@endsection


@section('status')
{{formatShowStatus($systemText)}}
@endsection


@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        {{$systemText->department}}
    </div>
</div>
@endsection


@section('description')
<br>
{!!html_entity_decode($systemText->title)!!}
<br>
<br>
          {!!html_entity_decode($systemText->text)!!}

<br>
<br>
@endsection

@section('editButton', route('systemText.edit', ['systemText' => $systemText->id]))

@section('backButton', route('systemText.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($systemText->created_at))}}
    </div>
</div>
@endsection
