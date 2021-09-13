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
    <div class="container" style="width: 200px;height: 50px">
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

@if($page->biography == 1)
@section('biography')
<div class="row">
	<div class="col-6"  style='
		 height:200px;
		 background-color: {{$page->complementary_color}};
		 '>
		@if($page->logo)
        <img src="{{asset($user->image->path)}}" height="100%" width="100%">
        @else
		{{strtoupper($page->name)}}
		@endif
	</div>
	<div class="col-6" style='
		 height:200px;
		 background-color: {{$page->complementary_color}};
		 ' >
		<p class="pt-5 mt-3" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 28px">
            {{$page->biography_text}}
        </p>
	</div>
</div>
@endsection
@endif



@section('categories')
<div class="row " >
	<div class="col-4 p-5 d-flex justify-content-center align-items-center"  style='background-color: red '>
		<img src="{{asset($page->category_image_1->path)}}" height="30%" width="30%">
	</div>
	<div class="col-4  d-flex justify-content-center align-items-center"  style='
		 background-color: blue;
		 '>
		<img src="{{asset($page->category_image_2->path)}}" height="30%" width="30%">
	</div>
	<div class="col-4  d-flex justify-content-center align-items-center"  style='
		 background-color: green;
		 '>
		<img src="{{asset($page->category_image_3->path)}}" height="30%" width="30%">
	</div>
</div>
<div class="row" >
	<div class='col-4 text-center'  style='background-color: #66cca4'>
		<p  class="pt-5 mt-3" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 28px" >
            {{$page->category_text_1}}
        </p>
	</div>
	<div class='col-4 text-center'  style='background-color: #52d8a8'>
		<p  class="pt-5 mt-3" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 28px" >
            {{$page->category_text_2}}
        </p>
	</div>
	<div class='col-4 text-center'  style='background-color: #0abab5'>
		<p  class="pt-5 mt-3" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 28px" >
            {{$page->category_text_3}}
        </p>
	</div>
</div>
@endsection

@section('company-biography')
<div class="row">
	<div class="col-6"  style='
		 height:200px;
		 background-color: {{$page->complementary_color}};
		 '>
		@if($page->logo)
        <img src="{{asset($page->company_biography_image->path)}}" height="100%" width="100%">
        @else
		{{strtoupper($page->name)}}
		@endif
	</div>
	<div class="col-6" style='
		 height:200px;
		 background-color: {{$page->complementary_color}};
		 ' >
		<p class="pt-5 mt-3" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 28px">
            {{$page->company-biography_text}}
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