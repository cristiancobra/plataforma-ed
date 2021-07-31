@extends('layouts/master')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('page')}}
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
    <form action=" {{route('page.store')}} " method="post" enctype='multipart/form-data'>
        @csrf
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" style="width: 600px" value="{{old('name')}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        <br>
        <label class='labels' for='' >DOMÍNIO (URL):</label>
        <input type='text' name='url' size='60' value='{{old('url')}}'>
        <br>
        <label class='labels' for='' >NOME CURTO (slug):</label> * sem espaços e maiúsculas.
        <input type='text' name='slug' size='60' value='{{old('slug')}}'>
        <br>
        <br>
        <label class='labels' for='' >MODELO:</label>
        <select name='template'>
            @foreach($templates as $key => $value)
            <option value='{{$key}}'>
                {{$value}}
            </option>
            @endforeach
        </select>
        <br>
        <label class='labels' for='' >SLOGAN:</label>
        <input type='text' name='headline' size='100' value='{{old('headline')}}'>
        <br>
        <label class='labels' for='' >LOGOMARCA:</label>
        <select name='logo_id'>
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
        <br>
        <label class='labels' for='' >IMAGEM DO CABEÇALHO:</label>
        <select name='image_id'>
            @foreach($images as $image)
            <option value='{{$image->id}}'>
                {{$image->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class='labels' for='' >COR PRINCIPAL:</label>
        <input type='text' name='principal_color' size='10' value='{{old('principal_color')}}'>
        <br>
        <label class='labels' for='' >COR SECUNDÁRIA:</label>
        <input type='text' name='complementary_color' size='10' value='{{old('complementary_color')}}'>
        <br>
        <label class='labels' for='' >COR OPOSTA:</label>
        <input type='text' name='opposite_color' size='10' value='{{old('opposite_color')}}'>
        <br>
        <br>
        <label class='labels' for='' >TEXTO 1:</label>
        <br>
        <textarea id='description' name='text1' rows='6' cols='90'>
		{{old('text1')}}
        </textarea>
        <br>
        <br>
        <label class='labels' for='' >TEXTO 2:</label>
        <br>
        <textarea id='description' name='text2' rows='6' cols='90'>
		{{old('text2')}}
        </textarea>
        <br>
        <br>
        <label class='labels' for='' >FORMULÁRIO DE CAPTAÇÃO:</label>
        <br>
        <input type='checkbox' name='use_form'>
        não quero usar formulário
        <br>
        <br>
        {{createSelectYesOrNo('Primeiro nome', 'contact_first_name')}}
        {{createSelectYesOrNo('Sobrenome', 'contact_last_name')}}
        {{createSelectYesOrNo('Email', 'contact_email')}}
        {{createSelectYesOrNo('Telefone', 'contact_phone')}}
        {{createSelectYesOrNo('Site', 'contact_site')}}
        {{createSelectYesOrNo('Endereço', 'contact_address')}}
        {{createSelectYesOrNo('Bairro', 'contact_neighborhood')}}
        {{createSelectYesOrNo('Cidade', 'contact_city')}}
        {{createSelectYesOrNo('Estado', 'contact_state')}}
        {{createSelectYesOrNo('País', 'contact_country')}}
        <br>
        <br>
        <label class="labels" for="" >SITUAÇAO:</label>
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