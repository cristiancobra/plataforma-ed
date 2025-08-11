@extends('layouts/master_blank')

@section('title','LOJA')

@section('image-top')
{{asset('images/site.png')}} 
@endsection

@section('buttons')

@endsection

@section('main')
@if(Session::has('failed'))
<div class='alert alert-danger'>
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<form action=' {{route('shop.update', ['shop' =>$shop->id])}} ' method='post'  enctype='multipart/form-data'>
    @csrf
    @method('put')

    <div>
        <label class='labels' for='' >NOME DA LOJA:</label>
        @if ($errors->has('name'))
        <input type='text' name='name' value='{{old('name')}}'>
        <span class='text-danger'>{{$errors->first('name')}}</span>
        @else
        <input type='text' name='name' size='80' value='{{$shop->name}}'>
        @endif
        <br>
        * Será exibido na barra superior da janela do navegador.
        <br>
  

    <div class='row' style='
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
         background-color: {{$shop->principal_color}};
         '>
        <div class='col-4 bg-white text-center mt-2 mb-1 ms-3 pt-1'>
            {{createSelectYesOrNo('MENU', 'navbar', $shop->navbar)}}
            <br>
            <label class='labels' for='' >LOGOTIPO:</label>
            <select name='logo_id'>
                @if($shop->logo)
                <option value='{{$shop->logo->id}}'>
                    {{$shop->logo->name}}
                </option>
                @endif
                <option value=''>
                    não
                </option>
                @foreach($logos as $logo)
                <option value='{{$logo->id}}'>
                    {{$logo->name}}
                </option>
                @endforeach
            </select>
        </div>
        @if($shop->logo)
        <div class='col-6'>
            <img src="{{asset($shop->logo->path)}}"  style='width: 250px;height: 60px'>
        </div>
        @endif
    </div>

    @if(!$shop->banner)
    <div class='row'>
        <div class='col-12 text-center' style='
             height:340px;
             background-image: url({{asset('images/banner-example.jpg')}});
             background-size: cover;
             background-position: center;
             background-repeat: no-repeat;
             border-left-style: solid;
             border-right-style: solid;
             border-left-width: 1px;
             border-right-width: 1px;
             '>
            <label class='labels mt-5' for='' >BANNER (imagem de topo):</label>
            <select name='banner_id'>
                @foreach($banners as $banner)
                <option value='{{$banner->id}}'>
                    {{$banner->name}}
                </option>
                @endforeach
            </select>
            <p class='pt-5 text-center' style='color: {{$shop->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px'>
                Slogan da minha empresa
            </p>
            <textarea class='text-center' id='headline' name='headline' rows='' cols='60'>
{{$shop->headline}}
            </textarea>
        </div>
    </div>
    @else
    <div class='row'>
        <div class='col-12 text-center' style='
             height:340px;
             background-image: url({{asset($shop->banner->path)}});
             background-size: cover;
             background-position: center;
             background-repeat: no-repeat;
             border-left-style: solid;
             border-right-style: solid;
             border-left-width: 1px;
             border-right-width: 1px;
             '>
            <label class='labels mt-5' for='' >BANNER (imagem de topo):</label>
            <select name='banner_id'>

                <option value='{{$shop->banner_id}}'>
                    {{$shop->banner->name}}
                </option>
                @foreach($banners as $banner)
                <option value='{{$banner->id}}'>
                    {{$banner->name}}
                </option>
                @endforeach
            </select>
            <p class='pt-5 text-center' style='color: {{$shop->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px'>
                Slogan da minha empresa
            </p>
            <textarea class='text-center' id='headline' name='headline' rows='' cols='60'>
{{$shop->headline}}
            </textarea>
        </div>
    </div>
    @endif

    <div class="row mt-5">
        <div class="col">
            <label class='labels' for='' >SITUAÇAO:</label>
            {{createSimpleSelect('status', 'fields', $status, $shop->status)}}
        </div>
    </div>
    <div class="row mt-5"> 
        <div class="col">
            <input class='btn btn-secondary' type='submit' value='ATUALIZAR'>
            </form>
        </div>
    </div>
    @endsection
