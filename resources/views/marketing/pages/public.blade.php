@extends("layouts/templatesPage/$page->template")

@section('page_name', $page->name)


@section('errors')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success">
    {{Session::get('success')}}
    @php
    Session::forget('success');
    @endphp
</div>
@endif
@endsection


@section('banner')
<div class="row justify-content-start" style="
     height: 60px;
     width: 100%;
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
@if($page->image)
<div class='row pt-5' style='
     height:600px;
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
@else
<div class='row pt-5' style='
     height:500px;
     background-color: {{$page->principal_color}};
     '>
    <div class='col text-center'>
        <p class="mt-5 pt-5" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px">
            {{$page->headline}}
        </p>
    </div>
</div>
@endif
@endsection

@section('text1')
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
@endsection

@section('text2')
<div class='row' style='
     background-color: {{$page->opposite_color}};
     '>
    <div class='col  text-center'>
        <p class="pt-5 mt-3" style="color: {{$page->principal_color}};font-size: 28px">
            {{$page->text2}}
        </p>
    </div>
</div>
@endsection

@section('form')
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

@yield('js-scripts')