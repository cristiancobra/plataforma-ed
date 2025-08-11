@extends('layouts/master')

@section('title','LOJA')

@section('image-top')
{{asset('images/site.png')}}
@endsection

@section('buttons')

{{createButtonList('shop')}}
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
    <form action=" {{route('shop.store')}} " method="post" enctype='multipart/form-data'>
        @csrf
        <label class="labels" for="" >NOME DA LOJA</label>
        <input type="text" name="name" style="width: 600px" value="{{old('name')}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        * Será exibido na barra superior da janela do navegador.
        <br>
        <div class='row mt-5' style='
             height: 80px;
             font-size: 20px;
             align-items: center;
             opacity: 0.8;
             overflow: hidden;
             border-top-style: solid;
             border-left-style: solid;
             border-right-style: solid;
             border-top-width: 1px;
             border-left-width: 1px;
             border-right-width: 1px;
             background-color: #52004d;
             '>
            <div class='col-4 bg-white text-center mt-2 mb-1 ms-3 pt-1'>
                <label class='labels' for='' >LOGOTIPO:</label>
                {{createSelectIdName('logo_id', 'fields', $logos, 'não')}}
            </div>
            <div class='col-6'>
                <img src="{{asset('/images/logo-empresa-digital.png')}}"  style='width: 250px;height: 60px'>
            </div>
        </div>

        <div class='row'>
            <div class='col-12 text-center' style='
                 height:340px;
                 background-image: url({{asset('/images/banner-example.png')}});
                 background-size: cover;
                 background-position: center;
                 background-repeat: no-repeat;
                 border-left-style: solid;
                 border-right-style: solid;
                 border-left-width: 1px;
                 border-right-width: 1px;
                 '>
                <label class='labels mt-5' for='' >BANNER (imagem de topo):</label>
                {{createSelectIdName('banner_image_id', 'fields', $banners, 'não')}}

                <p class='pt-5 text-center' style='color: #49d194;text-shadow: 2px 2px 4px #000000;font-size: 38px'>
                    Slogan da minha empresa
                </p>
                <textarea class='text-center' id='headline' name='headline' rows='' cols='60'>
Slogan da minha empresa
                </textarea>
            </div>
        </div>



        <br>
        <br>
        <label class="labels" for="" >
            SITUAÇAO
        </label>
        {{createSimpleSelect('status', 'fields', $status)}}
        <br>
        <p style="text-align: right">
            <input class="btn btn-secondary" type="submit" value="CRIAR">
        </p>
    </form>
</div>
<br>
<br>
@endsection