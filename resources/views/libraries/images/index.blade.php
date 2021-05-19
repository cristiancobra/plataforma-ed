@extends('layouts/master')

@section('title','IMAGENS')

@section('image-top')
{{asset('imagens/image.png')}} 
@endsection


@section('buttons')
<a class="circular-button primary"  href="{{route('image.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div class='row'>
    <div class='tb tb-header-start col-2'>
        IMAGEM
    </div>
    <div class='tb tb-header col-4'>
        NOME
    </div>
    <div class='tb tb-header col-4'>
        TEXTO ALTERNATIVO
    </div>
    <div class='tb tb-header col-1'>
        TIPO
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($images as $image)
<div class='row'>
    <div class='tb col-2'>
        <div class='product-image-small'>
            <a href=' {{route('image.show', ['image' => $image->id])}}'>
                <image src='{{$image->path}}' width='100%' heigh='100%'>
            </a>
        </div>
    </div>
    <div class='tb col-4'>
        {{$image->name}}
    </div>
    <div class='tb col-4'>
        {{$image->alt}}
    </div>
    <div class='tb col-1'>
        {{$image->type}}
    </div>
    <div class='tb col-1'>
        {{$image->status}}
    </div>
</div>
@endforeach
    <div class='row'>
        <div class='tb-footer'></div>
    </div>
<br>
@endsection
