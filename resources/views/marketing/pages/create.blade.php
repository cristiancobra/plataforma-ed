@extends('layouts/master')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/site.png')}}
@endsection

@section('buttons')

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
        <label class="labels" for="" >TÍTULO DA PÁGINA</label>
        <input type="text" name="name" style="width: 600px" value="{{old('name')}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        * Será exibido na barra superior da janela do navegador.
        <br>
        <label class='labels' for='' >DOMÍNIO (URL)</label>
        <input type='text' name='url' size='60' value='{{old('url')}}'>
        <br>
        <label class='labels' for='' >LINK (slug)</label> * sem espaços e maiúsculas.
        <input type='text' name='slug' size='60' value='{{old('slug')}}'>
        @if ($errors->has('slug'))
        <span class="text-danger">{{$errors->first('slug')}}</span>
        @endif
        <br>
        * SEM espaços e maiúsculas. Aparece na URL da página depois do domínio.
        <br>
        <br>
        <label class='labels' for='' >COR PRINCIPAL</label>
        <input type='text' name='principal_color' size='10' value='{{old('principal_color', optional(auth()->user()->account)->principal_color)}}'>
        <br>
        <label class='labels' for='' >COR SECUNDÁRIA</label>
        <input type='text' name='complementary_color' size='10' value='{{old('complementary_color', optional(auth()->user()->account)->complementary_color)}}'>
        <br>
        <label class='labels' for='' >COR OPOSTA</label>
        <input type='text' name='opposite_color' size='10' value='{{old('opposite_color', optional(auth()->user()->account)->opposite_color)}}'>

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
                {{createSelectYesOrNo('MENU', 'navbar')}}
                <br>
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
                <label class='labels mt-5' for='' >IMAGEM PRINCIPAL:</label>
                {{createSelectIdName('banner_image_id', 'fields', $banners, 'não')}}

                <p class='pt-5 text-center' style='color: #49d194;text-shadow: 2px 2px 4px #000000;font-size: 38px'>
                    Slogan da minha empresa
                </p>
                <textarea class='text-center' id='headline' name='headline' rows='' cols='60'>
Slogan da minha empresa
                </textarea>
            </div>
        </div>


        @if($valueOffer == null)
        <div class='row' style='
             border-style: solid;
             border-width: 1px;
             background-color: lightgray;
             '>
            <div class='row pt-3'>
                <div class='col'>
                    <span class='labels'>PROPOSTA DE VALOR: </span>não possui texto
                    <input type='hidden' name='text_value_offer' value='0'>
                    <p style='font-size:14px'>
                        * Qual a dor que seu produto resolve
                    </p>
                </div>
            </div>
            <div class='row pb-5'>
                <div class='col'>
                    <p class='text-center' style='color: #49d194;font-size: 22px'>
                        <a class='circular-button primary' title='criar uma proposta de valor' href='{{route('text.create', ['type' => 'proposta de valor'])}}'>
                            <i class='fa fa-plus' aria-hidden='true'></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        @else
        <div class='row'  style='background-color: #49d194'>
            <div class='row pt-3'>
                <div class='col'>
                    {{createSelectYesOrNo('PROPOSTA DE VALOR', 'text_value_offer')}}
                    <p style='font-size:14px'>
                        * Qual a dor que seu produto resolve
                    </p>
                </div>
            </div>
            <div class='row pb-5'>
                <div class='col'>
                    <p class='text-center' style='color: #49d194;;font-size: 22px'>
                        {{$valueOffer->text}}
                    </p>
                </div>
            </div>
        </div>
        @endif

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
                    <p class='text-center' style='color: #49d194;font-size: 22px'>
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
                        <p class='text-center' style='color: #49d194;font-size: 22px'>
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
        @else
        <div class='row' style='
             border-style: solid;
             border-width: 1px;
             '>
            <div class='row pt-3'>
                <div class='col'>
                    {{createSelectYesOrNo('APRESENTAÇÃO EMPRESA', 'company_about')}}
                    <span class='labels ms-5'>IMAGEM: </span>
                    {{createSelectIdName('about_image_id', 'fields', $marketingImages, null)}}
                </div>
                <div class='row pb-5 pt-2'>
                    <div class='col-5 d-flex px-5'>
                        <img  src='{{asset('images/banner-example.jpg')}}' style="
                              width:300px;
                              height:300px;
                              border-radius: 50%;
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




        @if($strengths->isEmpty())
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
                    <p class='text-center' style='color: #49d194;font-size: 22px'>
                        <a class='circular-button primary' title='criar um ponto forte da empresa' href='{{route('text.create', ['type' => 'força'])}}'>
                            <i class='fa fa-plus' aria-hidden='true'></i>
                        </a>
                    </p>
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
                    {{createSelectYesOrNo('PONTOS FORTES', 'company_strengths')}}
                </div>
                <div class='row pb-5 mt-5'>
                    @foreach($strengths as $strenght)
                    <div class='col text-center'>
                        <img src='{{asset('images/user.png')}}'  style='
                             color: #49d194;
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
                    {{createSelectYesOrNo('FORMULÁRIO DE CAPTAÇÃO', 'form')}}
                </div>
            </div>
            <div class='row'>
                <div class='col-4 mt-2 mb-2'>
                    @foreach($formFields as $formField)
                    <div class='row ms-2'>
                        {{createCheckboxEdit($formField['name'], 0)}}  {{$formField['label']}}
                    </div>
                    @endforeach            
                </div>

                <div class='col-8 text-center mt-3 pb-5'>
                    @foreach($formFields as $formField)
                    @if($formField['name'] != 'contact_state' AND $formField['name'] != 'contact_upload_image')
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

                    <div class='row pt-1'>      
                        <div class='col-3 d-flex justify-content-start'>
                            <label class='labels' for='contact_state_example'>Estado:</label>
                        </div>
                        <div class='col-4 d-flex justify-content-start'>
                            {{createDoubleSelect('contact_state_example', 'fields', $states)}}
                        </div>
                    </div>

                    <div class='row pt-1'>   
                        <div class='col-3 d-flex justify-content-start'>
                            <label class='labels' for='{{$formField['name']}}'>Enviar imagem:</label>
                        </div>
                        <div class='col-4 d-flex justify-content-start'>
                            <input type='file' name='{{$formField['name']}}'>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-4 mt-4 pb-2 text-center'>
                            <button class='text-button' style='background-color: gray'>
                                CADASTRAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--autorizações do formulário-->
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
                {{createCheckboxEdit('authorization_contact')}}
                <span class='labels'>Contato:</span>
                <br>
                {{createCheckboxEdit('authorization_newsletter')}}
                <span class='labels'>Newsletter:</span>
                <br>
            </div>
            <div class='col-8'>
                <div class='col pb-5 d-flex justify-content-center'>
                    <div class='col pb-5'>
                        <br>
                        <input type='checkbox' name='authorization_data'> Autorizo o armazenamento dos meus dados.
                        @if ($errors->has('authorization_data'))
                        <span class='text-danger'>{{$errors->first('authorization_data')}}</span>
                        @endif
                        <br>
                        <input type='checkbox' name='authorization_contact'> Permito que a empresa entre em contato comigo.
                        <br>
                        <input type='checkbox' name='authorization_newsletter'> Quero receber notícias sobre a empresa e seus produtos/serviços.
                        <br>
                        * você poderá alterar isso a qualquer momento.
                    </div>
                </div>
            </div>
        </div>


        <br>
        <br>
        <label class="labels" for="" >SITUAÇAO</label>
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