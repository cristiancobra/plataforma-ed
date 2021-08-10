@extends('layouts/master_blank')

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
    </div>
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
    <br>
    <div class='row'>
        <div class='col-3'>
            <label class='labels' for='' >LOGOTIPO:</label>
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
        </div>
        <div class='col-9 justify-content-start' style='
             height: 50px;
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
             background-color: {{$page->principal_color}}
'>
            <div class='container bg-white text-center mt-1 mb-1 pt-1' style='width: 150px;height: 40px'>
                MEU LOGO
            </div>
        </div>
        <div class='col-3 mt-5'>
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
            <label class='labels' for='' >SLOGAN:</label>
            <textarea id='headline' name='headline' rows='4' cols='23'>
{{$page->headline}}
            </textarea>
        </div>

        <div class='col-9 justify-content-start' style='
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
            <p class='mt-5 pt-5 text-center' style='color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px'>
                Slogan da minha empresa
            </p>

        </div>
    </div>



    <div class='row'>
        <div class='col-3 mt-2'>
            <label class='labels' for='' >TEXTO 1:</label>
            <br>
            <textarea id='description' name='text1' rows='4' cols='23'>
{{$page->text1}}
            </textarea>
        </div>
        <div class='col-9' style='
             height:200px;
             background-color: {{$page->complementary_color}};
             '>           
            <p class="pt-5 pb-4 text-center" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 22px">
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            </p>
        </div>
    </div>


    <div class='row'>
        <div class='col-3 mt-2'>
            <label class='labels' for='' >TEXTO 2:</label>
            <br>
            <textarea id='description' name='text2' rows='4' cols='23'>
{{$page->text2}}
            </textarea>
        </div>
        <div class='col-9' style='
             height:200px;
             background-color: {{$page->opposite_color}};
             border-left-style: solid;
             border-right-style: solid;
             border-left-width: 1px;
             border-right-width: 1px;
             '>           
            <p class="pt-5 pb-4 text-center" style="color: {{$page->principal_color}};font-size: 22px">
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            </p>
        </div>
    </div>


    <div class='row'>
        <div class='col-3 mt-2'>
            <div class="row">
                <label class='labels' for='' >FORMULÁRIO DE CAPTAÇÃO:</label>
            </div>
            @foreach($formFields as $formField)
            <div class="row">
                <div class="col">
                    {{createCheckboxEdit($formField['name'])}}  {{$formField['label']}}
                </div>
            </div>
            @endforeach            
        </div>
        <div class='col-9' style='
             height:300px;
             background-color: {{$page->opposite_color}};
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
            {{createCheckboxEdit('authorization_contact', $page->authorization_contact)}}
            <span class='labels'>Contato:</span>
            Permito que a empresa entre em contato comigo.
            <br>
            {{createCheckboxEdit('authorization_newsletter', $page->authorization_newsletter)}}
            <span class='labels'>Newsletter:</span>
            Quero receber notícias sobre a empresa e seus produtos/serviços.
            <br>
        </div>
    </div>
    <br>
    <br>
    <br>
    <label class='labels' for='' >SITUAÇAO:</label>
    {{createSimpleSelect('status', 'fields', $status, $page->status)}}
    <br>
    <br>
    <input class='btn btn-secondary' type='submit' value='ATUALIZAR'>
</form>
<br>
<br>
</div>     
@endsection
