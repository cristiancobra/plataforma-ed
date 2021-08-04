@extends('layouts/master_blank')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/page.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
<a class="circular-button secondary"  href="{{route('page.public', ['page' => $page])}}" target='_blank'>
    <i class="fa fa-eye" aria-hidden="true"></i>
</a>
{{createButtonEdit('page', 'page', $page)}}
{{createButtonList('page')}}
@endsection


@section('main')
<div class="row justify-content-start" style="
     height: 60px;
     width: 77.6%;
     font-size: 20px;
     align-items: center;
     opacity: 0.8;
     position: absolute;
     overflow: hidden;
     background-color: {{$page->principal_color}}
">
    @if($page->logo)
    <div class="container" style="width: 250px;height: 50px">
        <img src="{{asset($page->logo->path)}}" height="100%" width="100%">
    </div>
    @else
    {{strtoupper($page->name)}}
    @endif
</div>
<div class='row pt-5' style='
     height:460px;
     background-image: url({{asset($page->image->path)}});
     background-size: cover;
     background-position: center;
     background-repeat: no-repeat;
     '>
    <div class='col text-center'>
        <p class="mt-5 pt-5" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px">
            {{$page->headline}}
        </p>
    </div>
</div>

<div class='row' style='
     height:200px;
     background-color: {{$page->complementary_color}};
     '>
    <div class='col  text-center'>
        <p class="pt-5 mt-3" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 28px">
            {{$page->text1}}
        </p>
    </div>
</div>

<div class='row' style='
     background-color: {{$page->opposite_color}};
     '>
    <div class='col  text-center'>
        <p class="pt-5 mt-3" style="color: {{$page->principal_color}};font-size: 28px">
            {{$page->text2}}
        </p>
    </div>
</div>

<div class='row' style='
     height:200px;
     background-color: {{$page->opposite_color}};
     '>
    <div class='col  text-center  pb-5'>
        <form action="{{route('contact.storeForm', ['page' => $page])}}" method='post'>
            @csrf
            @if($errors)
            {{createFormPage($page, $errors)}}
            @else
            {{createFormPage($page)}}
            @endif
            <br>
            <button class="text-button" type='submit'>
                CADASTRAR
            </button>
        </form>
    </div>
</div>
@endsection


@section('deleteButton')

@endsection


@section('editButton', route('page.edit', ['page' => $page->id]))

@section('backButton', route('page.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{dateBr($page->created_at)}}
    </div>
</div>
@endsection