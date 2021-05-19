@extends('layouts/show')

@section('title','IMAGENS')

@section('image-top')
{{asset('imagens/images.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('image')}}
@endsection

@section('name', $image->name)

@section('priority')
{{formatShowCategory($image)}}
@endsection


@section('status')
{{formatShowStatus($image)}}
@endsection


@section('fieldsId')
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='image-image'>
        <a href=' {{route('image.show', ['image' => $image->id])}}'>
            <image src='{{$image->path}}' width='100%' heigh='100%'>
        </a>
    </div>
</div>
<div class='col-lg-8 col-xs-6' style='text-align: center'>
    <div class='show-label-large'>
        DESCRIÇÃO
    </div>
    <div class='description-field'>
        {!!html_entity_decode($image->description)!!}
    </div>
    @endsection


    @section('execution')
    @endsection

    @section('deleteButton', route('image.destroy', ['image' => $image->id]))

    @section('editButton', route('image.edit', ['image' => $image->id]))

    @section('backButton', route('image.index'))

    @section('createdAt')
    <div class='row' style='margin-top: 30px'>
        <div class='col-12'style='padding-top: -10px'>
            Primeiro registro em: {{date('d/m/Y H:i', strtotime($image->created_at))}}
        </div>
    </div>
    @endsection