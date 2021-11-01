@extends('layouts/master_blank')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/site.png')}} 
@endsection

@section('buttons')
<a class='circular-button primary' title='Visualizar página' href="{{route('page.public', ['page' => $page])}}" target='_blank'>
    <i class = 'fas fa-eye'></i>
</a>
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
<form action=' {{route('page.update', ['page' =>$page->id])}} ' method='post'  enctype='multipart/form-data'>
    @csrf
    @method('put')

    <div>
        <label class='labels' for='' >TÍTULO DA PÁGINA:</label>
        @if ($errors->has('name'))
        <input type='text' name='name' value='{{old('name')}}'>
        <span class='text-danger'>{{$errors->first('name')}}</span>
        @else
        <input type='text' name='name' size='80' value='{{$page->name}}'>
        @endif
        <br>
        * Será exibido na barra superior da janela do navegador.
        <br>
        <label class='labels' for='' >DOMÍNIO (URL):</label>
        <input type='text' name='url' size='60' value='{{$page->url}}'>
        <br>
        <label class='labels' for='' >LINK (slug):</label>
        <input type='text' name='slug' size='60' value='{{$page->slug}}'>
        <br>
        * SEM espaços e maiúsculas. Será exibido na URL da página depois do domínio.
        <br>
        <br>
    </div>
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
         background-color: {{$page->principal_color}};
         '>
        <div class='col-4 bg-white text-center mt-2 mb-1 ms-3 pt-1'>
            {{createSelectYesOrNo('MENU', 'navbar', $page->navbar)}}
            <br>
            <label class='labels' for='' >LOGOTIPO:</label>
            <select name='logo_id'>
                @if($page->logo)
                <option value='{{$page->logo->id}}'>
                    {{$page->logo->name}}
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
        @if($page->logo)
        <div class='col-6'>
            <img src="{{asset($page->logo->path)}}"  style='width: 250px;height: 60px'>
        </div>
        @endif
    </div>

    @if($page->banner == null)
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
            <label class='labels mt-5' for='' >IMAGEM PRINCIPAL:</label>
            <select name='banner_image_id'>
                @foreach($banners as $banner)
                <option value='{{$banner->id}}'>
                    {{$banner->name}}
                </option>
                @endforeach
            </select>
            <p class='pt-5 text-center' style='color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px'>
                Slogan da minha empresa
            </p>
            <textarea class='text-center' id='headline' name='headline' rows='' cols='60'>
{{$page->headline}}
            </textarea>
        </div>
    </div>
    @else
    <div class='row'>
        <div class='col-12 text-center' style='
             height:340px;
             background-image: url({{asset($page->banner->path)}});
             background-size: cover;
             background-position: center;
             background-repeat: no-repeat;
             border-left-style: solid;
             border-right-style: solid;
             border-left-width: 1px;
             border-right-width: 1px;
             '>
            <label class='labels mt-5' for='' >IMAGEM PRINCIPAL:</label>
            <select name='banner_image_id'>

                <option value='{{$page->banner_image_id}}'>
                    {{$page->banner->name}}
                </option>
                @foreach($banners as $banner)
                <option value='{{$banner->id}}'>
                    {{$banner->name}}
                </option>
                @endforeach
            </select>
            <p class='pt-5 text-center' style='color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px'>
                Slogan da minha empresa
            </p>
            <textarea class='text-center' id='headline' name='headline' rows='' cols='60'>
{{$page->headline}}
            </textarea>
        </div>
    </div>
    @endif

    <div class='row' style='
         border-style: solid;
         border-width: 1px;
         background-color: {{$valueOfferBackgroundColor}}
         '>
        <div class='row pt-3'>
            <div class='col'>
                @if($valueOffer == null)
                <span class='labels'>PROPOSTA DE VALOR: </span>não possui texto
                <input type='hidden' name='text_value_offer' value='0'>
                @else
                {{createSelectYesOrNo('PROPOSTA DE VALOR', 'text_value_offer', $page->text_value_offer)}}
                @endif
                <p style='font-size:14px'>
                    * Qual a dor que seu produto resolve
                </p>
            </div>
        </div>
        <div class='row pb-5'>
            <div class='col'>
                <p class='text-center' style='color: {{$valueOfferOppositeColor}};font-size: 22px'>
                    @if($valueOffer == null)
                    <a class='circular-button primary' title='criar uma proposta de valor' href='{{route('text.create', ['type' => 'proposta de valor'])}}'>
                        <i class='fa fa-plus' aria-hidden='true'></i>
                    </a>
                    @else
                    {{$valueOffer->text}}
                    @endif
                </p>
            </div>
        </div>
    </div>


    @if($about == null)
    <div class='row' style='
         border-style: solid;
         border-width: 1px;
         background-color: lightgray;
         '>
        <div class='row pt-3'>
            <div class='col'>
                <span class='labels'>APRESENTAÇÃO EMPRESA: </span>não possui texto
                <input type='hidden' name='company_about' value='0'>
            </div>
        </div>
        <div class='row pb-5 pt-2'>
            <div class='col d-flex justify-content-center align-items-center'>
                <p class='text-center' style='color: {{$page->opposite_color}};font-size: 22px'>
                    <a class='circular-button primary' title='criar um texto de apresentação' href='{{route('text.create', ['type' => 'apresentação da empresa'])}}'>
                        <i class='fa fa-plus' aria-hidden='true'></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
    @elseif($about->status != 'aprovado' AND $about->status != 'indisponível')
    <div class='row' style='
         border-style: solid;
         border-width: 1px;
         background-color: lightgray;
         '>
        <div class='row pt-3'>
            <div class='col'>
                <span class='labels'>APRESENTAÇÃO EMPRESA: </span>texto precisa de revisão
                <input type='hidden' name='company_about' value='0'>
            </div>
            <div class='row pb-5 pt-2'>
                <div class='col-5 d-flex px-5'>
                    <img  src='{{asset('images/banner-example.jpg')}}' width="320px" height="320px" style="border-radius: 50%">
                </div>
                <div class='col-7 d-flex justify-content-center align-items-center'>
                    <p class='text-center' style='color: {{$page->principal_color}};font-size: 22px'>
                        {{$about->text}}
                        <br>
                        <br>
                        <a class='circular-button primary' title='editar o texto' href='{{route('text.edit', ['text' => $about->id])}}'>
                            <i class='fa fa-edit' aria-hidden='true'></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @elseif($page->company_about == 1)
    <div class='row'>
        <div class='row pt-3'>
            <div class='col'>
                {{createSelectYesOrNo('APRESENTAÇÃO EMPRESA', 'company_about', $page->company_about)}}
                <span class='labels ms-5'>IMAGEM: </span>
                {{createSelectIdName('about_image_id', 'fields', $marketingImages, null, $page->aboutImage)}}
            </div>
            <div class='row pb-5 pt-2'>
                <div class='col-5 d-flex px-5'>
                    @if($page->aboutImage)
                    <img  src='{{asset($page->aboutImage->path)}}' width="300px" height="300px" style="border-radius: 50%">
                    @else
                    <img  src='{{asset('images/banner-example.jpg')}}' width="300px" height="300px" style="border-radius: 50%">
                    @endif
                </div>
                <div class='col-7 d-flex justify-content-center align-items-center'>
                    <p class='text-center' style='color: {{$page->principal_color}};font-size: 22px'>
                        {{$about->text}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class='row' style='
         border-style: solid;
         border-width: 1px;
         background-color: lightgray;
         '>
        <div class='row pt-3'>
            <div class='col'>
                {{createSelectYesOrNo('APRESENTAÇÃO EMPRESA', 'company_about', $page->company_about)}}
            </div>
            <div class='row pb-5 pt-2'>
                <div class='col-5 d-flex px-5'>
                    <img  src='{{asset('images/banner-example.jpg')}}' style="
                          width:300px;
                          height:300px;
                          border-radius: 50%;
                          filter: gray; /* IE6-9 */
                          -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
                          filter: grayscale(1); /* Microsoft Edge and Firefox 35+ */
                          ">
                </div>
                <div class='col-7 d-flex justify-content-center align-items-center'>
                    <p class='text-center' style='color: gray;font-size: 22px'>
                        {{$about->text}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif


    @if(!$strengths)
    <div class='row' style='
         border-style: solid;
         border-width: 1px;
         background-color: lightgray;
         '>
        <div class='row pt-3'>
            <div class='col'>
                <span class='labels'>PONTOS FORTES: </span>não possui texto
                <input type='hidden' name='' value='0'>
            </div>
        </div>
        <div class='row pb-5 pt-2'>
            <div class='col d-flex justify-content-center align-items-center'>
                <p class='text-center' style='color: {{$page->principal_color}};font-size: 22px'>
                    <a class='circular-button primary' title='criar um ponto forte da empresa' href='{{route('text.create', ['type' => 'força'])}}'>
                        <i class='fa fa-plus' aria-hidden='true'></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
    @elseif($page->company_strengths == 1)
    <div class='row'>
        <div class='row pt-3'>
            <div class='col'>
                {{createSelectYesOrNo('PONTOS FORTES', 'company_strengths', $page->company_strengths)}}
                <span class='labels ms-5'>IMAGEM: </span>
                {{createSelectIdName('about_image_id', 'fields', $marketingImages, null, $page->aboutImage)}}
            </div>
            <div class='row pb-5 mt-5'>
                @foreach($strengths as $strenght)
                <div class='col text-center'>
                    <img src='{{asset('images/user.png')}}'  style='
                         color: {{$page->opposite_color}};
                         font-size: 22px;
                         width:80px;
                         height:80px;
                         margin-bottom: 20px;
                         '>
                    <p class='text-center' style='color: {{$page->principal_color}};font-size: 22px'>
                        {{$strenght->text}}
                    </p>
                </div>
                @endforeach
                <div class='row pb-0 pt-2'>
                    <div class='col d-flex justify-content-center align-items-center'>
                        <p class='text-center' style='color: {{$page->principal_color}};font-size: 22px'>
                            <a class='circular-button primary' title='criar um ponto forte da empresa' href='{{route('text.create', ['type' => 'força'])}}'>
                                <i class='fa fa-plus' aria-hidden='true'></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class='row' style='
         border-style: solid;
         border-width: 1px;
         background-color: lightgray;
         '>
        <div class='row pt-3'>
            <div class='col'>
                {{createSelectYesOrNo('PONTOS FORTES', 'company_strengths', $page->company_strengths)}}
            </div>
            <div class='row pb-5 mt-5'>
                @foreach($strengths as $strenght)
                <div class='col text-center'>
                    <img src='{{asset('images/user.png')}}'  style='
                         color: {{$page->opposite_color}};
                         font-size: 22px;
                         width:80px;
                         height:80px;
                         margin-bottom: 20px;
                         filter: gray; /* IE6-9 */
                         -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
                         filter: grayscale(1); /* Microsoft Edge and Firefox 35+ */
                         '>
                    <p class='text-center' style='color: grey;font-size: 22px'>
                        {{$strenght->text}}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif


    <div class='row' style='
         border-style: solid;
         border-width: 1px;
         background-color: {{$shopBackgroundColor}}
         '>
        <div class='row pt-3'>
            <div class='col'>
                @if($products == null)
                <span class='labels'>LOJA: </span>não possui produtos
                <input type='hidden' name='shop' value='0'>
                @else
                {{createSelectYesOrNo('LOJA', 'shop', $page->shop)}}
                @endif
                <p style='font-size:14px'>
                    * Qual a dor que seu produto resolve
                </p>
            </div>
        </div>
        <div class='row pb-5'>
            <div class='col'>
                <p class='text-center' style='color: {{$shopOppositeColor}};font-size: 22px'>
                    @if($products == null)
                    <a class='circular-button primary' title='criar produto' href='{{route('text.create', ['type' => 'proposta de valor'])}}'>
                        <i class='fa fa-plus' aria-hidden='true'></i>
                    </a>
                    @else
                                <div class='row pb-5 mt-5'>
                    @foreach($products as $product)
                <div class='col text-center'>
                    <img src='{{asset('images/user.png')}}'  style='
                         color: {{$page->opposite_color}};
                         font-size: 22px;
                         width:80px;
                         height:80px;
                         margin-bottom: 20px;
                         filter: gray; /* IE6-9 */
                         -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
                         filter: grayscale(1); /* Microsoft Edge and Firefox 35+ */
                         '>
                    <p class='text-center' style='color: grey;font-size: 22px'>
                        {{$product->name}}
                    </p>
                </div>
                @endforeach
                </div>
                @endif
                </p>
            </div>
        </div>
    </div>




    @if($page->form == 1)
    <div class='row' style='background-color: {{$page->opposite_color}}'>
        <div class='row mt-2'>
            <div class='col'>
                {{createSelectYesOrNo('FORMULÁRIO DE CAPTAÇÃO', 'form', $page->form)}}
            </div>
        </div>
        <div class='col-4'>
            @foreach($formFields as $formField)
            <div class='row'>
                <div class='col'>
                    {{createCheckboxEdit($formField['name'], $formField['value'])}}  {{$formField['label']}}
                </div>
            </div>
            @endforeach
        </div>

        <div class='col-8 text-center mt-5 pb-5'>
            @foreach($formFields as $formField)
            @if($formField['name'] == 'contact_state' AND $formField['value'] == 1)
            <div class='row pt-1'>      
                <div class='col-3 d-flex justify-content-start'>
                    <label class='labels' for='contact_state_example'>{{$formField['label']}}:</label>
                </div>
                <div class='col-4 d-flex justify-content-start'>
                    {{createDoubleSelect('contact_state_example', 'fields', $states)}}
                </div>
            </div>           
            @elseif($formField['name'] == 'contact_upload_image' AND $formField['value'] == 1)
            <div class='row pt-1'>   
                <div class='col-3 d-flex justify-content-start'>
                    <label class='labels' for=''>{{$formField['label']}}:</label>
                </div>
                <div class='col-4 d-flex justify-content-start'>
                    <input type='file' name=''>
                </div>
            </div>
            @elseif($formField['value'] == 1)
            <div class='row pt-1'>   
                <div class='col-3 d-flex justify-content-start'>
                    <label class='labels' for=''>{{$formField['label']}}:</label>
                </div>
                <div class='col-4 d-flex justify-content-start'>
                    <input type='text' name=''>
                </div>
            </div>
            @endif
            @endforeach
            <div class='row'>
                <div class='col-4 mt-4 pb-2 text-center'>
                    <button class='text-button' style='background-color: {{$page->complementary_color}}'>
                        CADASTRAR
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class='row' style='
         background-color: lightgray;
         border-left-style: solid;
         border-right-style: solid;
         border-bottom-style: solid;
         border-left-width: 1px;
         border-right-width: 1px;
         border-bottom-width: 1px;
         '>
        <div class='row mt-2'>
            <div class='col'>
                {{createSelectYesOrNo('FORMULÁRIO DE CAPTAÇÃO', 'form', $page->form)}}
            </div>
        </div>
        <div class='row'>
            <div class='col-4 mt-2 mb-2'>
                @foreach($formFields as $formField)
                <div class='row ms-2'>
                    {{createCheckboxEdit($formField['name'], $formField['value'])}}  {{$formField['label']}}
                </div>
                @endforeach            
            </div>

            <div class='col-8 text-center mt-3 pb-5'>
                @foreach($formFields as $formField)
                @if($formField['name'] == 'contact_state' AND $formField['value'] == 1)
                <div class='row pt-1'>      
                    <div class='col-3 d-flex justify-content-start'>
                        <label class='labels' for='contact_state_example'>{{$formField['label']}}:</label>
                    </div>
                    <div class='col-4 d-flex justify-content-start'>
                        {{createDoubleSelect('contact_state_example', 'fields', $states)}}
                    </div>
                </div>                    
                @elseif($formField['name'] == 'contact_upload_image' AND $formField['value'] == 1)
                <div class='row pt-1'>   
                    <div class='col-3 d-flex justify-content-start'>
                        <label class='labels' for=''>{{$formField['label']}}:</label>
                    </div>
                    <div class='col-4 d-flex justify-content-start'>
                        <input type='file' name=''>
                    </div>
                </div>
                @elseif($formField['value'] == 1)
                <div class='row pt-1'>   
                    <div class='col-3 d-flex justify-content-start'>
                        <label class='labels' for='' style="color: gray">{{$formField['label']}}:</label>
                    </div>
                    <div class='col-4 d-flex justify-content-start'>
                        <input type='text' name=''>
                    </div>
                </div>
                @endif
                @endforeach

                @if($formFields)
                <div class='row'>
                    <div class='col-4 mt-4 pb-2 text-center'>
                        <button class='text-button' style='background-color: gray'>
                            CADASTRAR
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!--autorizações do formulário-->
    @if($page->form == 1)
    <div class='row' style='
         background-color: white;
         border-bottom-style: solid;
         border-bottom-width: 1px;
         '>
        <div class='col-4'>
            <label class='labels mt-4' for='' >AUTORIZAÇOES:</label>
            <br>
            {{createCheckboxReadOnly('authorization_data', 1)}}
            <span class='labels'>Armazenar:</span>
            <br>
            <span style='font-size: 14px;font-style: italic'>* Obrigatório pela Lei Geral de Proteção de Dados.</span>
            <br>
            {{createCheckboxEdit('authorization_contact', $page->authorization_contact)}}
            <span class='labels'>Contato:</span>
            <br>
            {{createCheckboxEdit('authorization_newsletter', $page->authorization_newsletter)}}
            <span class='labels'>Newsletter:</span>
            <br>
        </div>
        <div class='col-8'>
            <div class='col pb-5 d-flex justify-content-center'>
                <div class='col pb-5'>
                    <br>
                    <input type='checkbox' name='authorization_data_example'> Autorizo o armazenamento dos meus dados.
                    <br>
                    <input type='checkbox' name='authorization_contact_example'> Permito que a empresa entre em contato comigo.
                    <br>
                    <input type='checkbox' name='authorization_newsletter_example'> Quero receber notícias sobre a empresa e seus produtos/serviços.
                    <br>
                    * você poderá alterar isso a qualquer momento.
                </div>
            </div>
        </div>
    </div>
    @else
    <div class='row' style='
         background-color: lightgray;
         border-left-style: solid;
         border-right-style: solid;
         border-bottom-style: solid;
         border-left-width: 1px;
         border-right-width: 1px;
         border-bottom-width: 1px;
         '>
        <div class='col-4'>
            <label class='labels mt-4' for='' >AUTORIZAÇOES:</label>
            <br>
            {{createCheckboxReadOnly('authorization_data', 1)}}
            <span class='labels'>Armazenar:</span>
            <br>
            <span style='font-size: 14px;font-style: italic'>* Obrigatório pela Lei Geral de Proteção de Dados.</span>
            <br>
            {{createCheckboxEdit('authorization_contact', $page->authorization_contact)}}
            <span class='labels'>Contato:</span>
            <br>
            {{createCheckboxEdit('authorization_newsletter', $page->authorization_newsletter)}}
            <span class='labels'>Newsletter:</span>
            <br>
        </div>
        <div class='col-8'>
            <div class='col pb-5 d-flex justify-content-center'>
                <div class='col pb-5'>
                    <br>
                    <input type='checkbox' name='authorization_data_example'> Autorizo o armazenamento dos meus dados.
                    <br>
                    <input type='checkbox' name='authorization_contact_example'> Permito que a empresa entre em contato comigo.
                    <br>
                    <input type='checkbox' name='authorization_newsletter_example'> Quero receber notícias sobre a empresa e seus produtos/serviços.
                    <br>
                    * você poderá alterar isso a qualquer momento.
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-5">
        <div class="col">
            <label class='labels' for='' >SITUAÇAO:</label>
            {{createSimpleSelect('status', 'fields', $status, $page->status)}}
        </div>
    </div>
    <div class="row mt-5"> 
        <div class="col">
            <input class='btn btn-secondary' type='submit' value='ATUALIZAR'>
            </form>
        </div>
    </div>
    @endsection
