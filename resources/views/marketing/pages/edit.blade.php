@extends('layouts/master')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/page.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('page')}}
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
<form action=' {{route('page.update', ['page' =>$page->id])}} ' method='post'>
    @csrf
    @method('put')
    <div>
        <label class='labels' for='' >NOME DA PÁGINA:</label>
        @if ($errors->has('name'))
        <input type='text' name='name' value='{{old('name')}}'>
        <span class='text-danger'>{{$errors->first('name')}}</span>
        @else
        <input type='text' name='name' size='80' value='{{$page->name}}'>
        @endif
        <br>
        <label class='labels' for='' >DOMÍNIO (URL):</label>
        <input type='text' name='url' size='60' value='{{$page->url}}'>
        <br>
        <label class='labels' for='' >NOME CURTO (slug):</label> * sem espaços e maiúsculas.
        <input type='text' name='slug' size='60' value='{{$page->url}}'>
        <br>
        <br>
        <label class='labels' for='' >MODELO:</label>
        <select name='template'>
            @if($page->template)
            <option value='{{$page->template}}'>
                {{$currentTemplate}}
            </option>
            @endif
            @foreach($templates as $key => $value)
            <option value='{{$key}}'>
                {{$value}}
            </option>
            @endforeach
        </select>
        <br>
        <label class='labels' for='' >SLOGAN:</label>
        <input type='text' name='headline' size='100' value='{{$page->headline}}'>
        <br>
        <label class='labels' for='' >LOGOMARCA:</label>
        <select name='logo_id'>
            @if($page->image == null)
            <option value='{{$page->logo_id}}'>
                {{$page->logo->name}}
            </option>
            @endif
            <option value=''>
                não usar
            </option>
            @foreach($logos as $logo)
            <option value='{{$logo->id}}'>
                {{$logo->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class='labels' for='' >IMAGEM DO CABEÇALHO:</label>
        <select name='image_id'>
            @if($page->image)
            <option value='{{$page->image_id}}'>
                {{$page->image->name}}
            </option>
            @endif
            @foreach($images as $image)
            <option value='{{$image->id}}'>
                {{$image->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class='labels' for='' >COR PRINCIPAL:</label>
        <input type='text' name='principal_color' size='10' value='{{$page->principal_color}}'>
        <br>
        <label class='labels' for='' >COR SECUNDÁRIA:</label>
        <input type='text' name='complementary_color' size='10' value='{{$page->complementary_color}}'>
        <br>
        <label class='labels' for='' >COR OPOSTA:</label>
        <input type='text' name='opposite_color' size='10' value='{{$page->opposite_color}}'>
        <br>
        <br>
        <label class='labels' for='' >TEXTO 1:</label>
        <br>
        <textarea id='description' name='text1' rows='6' cols='90'>
{{$page->text1}}
        </textarea>
        <br>
        <br>
        <label class='labels' for='' >TEXTO 2:</label>
        <br>
        <textarea id='description' name='text2' rows='6' cols='90'>
{{$page->text2}}
        </textarea>
        <br>
        <br>
        <label class='labels' for='' >FORMULÁRIO DE CAPTAÇÃO:</label>
        <br>
        <input type='checkbox' name='use_form'>
        não quero usar formulário
        <br>
        <br>
        {{createSelectYesOrNo('Primeiro nome', 'contact_first_name', $page->contact_first_name)}}
        {{createSelectYesOrNo('Sobrenome', 'contact_last_name', $page->contact_last_name)}}
        {{createSelectYesOrNo('Email', 'contact_email', $page->contact_email)}}
        {{createSelectYesOrNo('Telefone', 'contact_phone', $page->contact_phone)}}
        {{createSelectYesOrNo('Site', 'contact_site', $page->contact_site)}}
        {{createSelectYesOrNo('Endereço', 'contact_address', $page->contact_address)}}
        {{createSelectYesOrNo('Bairo', 'contact_neighborhood', $page->contact_neighborhood)}}
        {{createSelectYesOrNo('Cidade', 'contact_city', $page->contact_city)}}
        {{createSelectYesOrNo('Estado', 'contact_state', $page->contact_state)}}
        {{createSelectYesOrNo('País', 'contact_country', $page->contact_country)}}
        <br>
        <br>
        <label class="labels" for="" >SITUAÇAO:</label>
        {{createSimpleSelect('status', 'fields', $status, $page->status)}}
        <br>
        <input class='btn btn-secondary' type='submit' value='ATUALIZAR'>
        </form>
        <br>
        <br>
        <br>
    </div>     
    @endsection
