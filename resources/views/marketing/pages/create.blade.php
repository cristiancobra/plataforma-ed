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
      <div class='row'>
        <div class='col-3 mt-2'>
            <div class="row">
                <label class='labels' for='' >FORMULÁRIO DE CAPTAÇÃO:</label>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_first_name')}}  Primeiro nome
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_last_name')}}  Sobrenome
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_email')}}  Email
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_phone')}}  Telefone
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_site')}}  Site
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_address')}}  Endereço
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_neighborhood')}}  Bairro
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_city')}}  Cidade
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_state')}}  Estado
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit('contact_country')}}  País
                </div>
            </div>
        </div>
        <div class='col-9' style='
             height:300px;
             border-left-style: solid;
             border-right-style: solid;
             border-bottom-style: solid;
             border-left-width: 1px;
             border-right-width: 1px;
             border-bottom-width: 1px;
             '>
            <div class='col  text-center  pb-5'>
                <div class='offset-4 col-5 pb-5'>
                    <br>
                    <input type="checkbox" name="authorization_data"> Autorizo o armazenamento dos meus dados.
                    @if ($errors->has('authorization_data'))
                    <span class='text-danger'>{{$errors->first('authorization_data')}}</span>
                    @endif
                    <br>
                    <input type="checkbox" name="authorization_contact"> Permito que a empresa entre em contato comigo.
                    <br>
                    <input type="checkbox" name="authorization_newsletter"> Quero receber notícias sobre a empresa e seus produtos/serviços.
                    <br>
                    * você poderá alterar isso a qualquer momento.
                </div>
                <div class='offset-4 col-4 pb-5 text-center'>
                    <button class="text-button primary" type='submit'>
                        CADASTRAR
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col mt-2'>
            <label class='labels' for='' >AUTORIZAÇOES:</label>
            <br>
            {{createCheckboxReadOnly('authorization_data', 1)}}
            <span class='labels'>Armazenar:</span>
            Autorizo o armazenamento dos meus dados. * Obrigatório segundo a Lei Geral de Proteção de Dados.
            <br>
            {{createCheckboxEdit('authorization_contact')}}
            <span class='labels'>Contato:</span>
            Permito que a empresa entre em contato comigo.
            <br>
            {{createCheckboxEdit('authorization_newsletter')}}
            <span class='labels'>Newsletter:</span>
            Quero receber notícias sobre a empresa e seus produtos/serviços.
            <br>
        </div>
    </div>
    <br>
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