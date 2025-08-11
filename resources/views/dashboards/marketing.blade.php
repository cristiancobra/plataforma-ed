@extends('layouts/master')

@section('title','MARKETING')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')

<!--     linha 1 de blocos-->
<div class='row'>

    <!--     começo bloco de TEXTOS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-bullhorn' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                TEXTOS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('text.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo texto'></i>
                </a>
                <a style='text-decoration:none' href='{{route('text.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos os textos'></i>
                </a>
                <a style='text-decoration:none' href='{{route('text.index', [
                                                                                                                            'user_id' => auth()->user()->id
                                                                                                                            ])}}'>
                    <i class='fas fa-paperclip ps-2 pe-2' title='meus textos'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de TEXTOS-->

    
    <!--     começo bloco de IMAGENS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-images' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                IMAGENS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('image.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='subir nova imagem'></i>
                </a>
                <a style='text-decoration:none' href='{{route('image.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas as imagens'></i>
                </a>
                <a style='text-decoration:none' href='{{route('image.index', [
                                                                                                                            'user_id' => auth()->user()->id
                                                                                                                            ])}}'>
                    <i class='fas fa-paperclip ps-2 pe-2' title='minhas imagens'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de IMAGENS-->
    
    
    <!--     começo bloco de REDES SOCIAIS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fab fa-facebook' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                REDES SOCIAIS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('socialmedia.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova rede social'></i>
                </a>
                <a style='text-decoration:none' href='{{route('socialmedia.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos as redes'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de REDES SOCIAIS-->

    <!--     começo bloco de PÁGINAS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-window-maximize' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                PÁGINAS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none' href='{{route('page.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='nova página'></i>
                </a>
                <a style='text-decoration:none' href='{{route('page.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todas as páginas'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de PÁGINAS-->


    <!--     começo bloco de LOJA-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$complementaryColor}};
         background-color:{{$complementaryColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 10px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-store' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                LOJA
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                @if($shop == null)
                <a style='text-decoration:none' href='{{route('shop.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='criar loja'></i>
                </a>
                @else
                <a style='text-decoration:none' href='{{route('shop.edit', ['shop' => $shop])}}'>
                    <i class='fas fa-edit ps-2 pe-2' title='editar loja'></i>
                </a>
                @endif
                <a style='text-decoration:none' href='{{route('product.index', ['variation' => 'receita'])}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='ver produtos'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de LOJA-->

    <!--fim da LINHA 1 de blocos-->    
</div>


<!--     linha 2 de blocos-->
<div class='row mt-4'>
    
    
    <!--     começo bloco de RELATÓRIOS-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$oppositeColor}};
         background-color:{{$oppositeColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-chart-bar' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                RELATÓRIOS
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none;color: {{$oppositeColor}}' href='{{route('report.create')}}'>
                    <i class='fas fa-plus-circle ps-2 pe-2' title='novo relatório'></i>
                </a>
                <a style='text-decoration:none;color: {{$oppositeColor}}' href='{{route('report.index')}}'>
                    <i class='fas fa-list-alt ps-2 pe-2' title='todos os relatórios'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de RELATÓRIOS-->


    <!--     começo bloco de PÚBLICO-ALVO-->
    <div class='col-2' style='
         text-shadow: 2px 2px 4px #000000;
         border-color:{{$oppositeColor}};
         background-color:{{$oppositeColor}};
         border-style: solid;
         border-width: 4px;
         margin-left: 20px;
         margin-right: 20px;
         margin-top: 10px;
         padding-top: 10px;
         border-radius: 10px;
         box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         text-decoration:none;
         '>
        <!--lícone do título-->
        <div class='row'>
            <div class='col panel-text pt-2'>
                <i class='fas fa-user-plus' style='font-size:36px; color:white'></i>
            </div>
        </div>
        <!--linha do título-->
        <div class='row pb-2'>
            <div class='col panel-text pt-3'>
                PÚBLICO-ALVO
            </div>
        </div>
        <!--linha dos botoes-->
        <div class='row d-flex justify-content-center' style='
             font-size: 20px;
             font-weight: 600;
             color: {{$complementaryColor}};
             background-color: white;
             text-shadow: none;
             padding-top: 10px;
             padding-bottom: 10px;
             text-align: center;
             border-radius: 0px 0px 10px 10px;
             '>
            <div class="col d-inline-block">
                <a style='text-decoration:none;color: {{$oppositeColor}}' href='{{route('contact.target')}}'>
                    <i class='fas fa-users ps-2 pe-2' title='ver público-alvo'></i>
                </a>
            </div>
        </div>
    </div>
    <!--fim do bloco de PÚBLICO-ALVO-->

    

    <!--fim da LINHA 2 de blocos-->    
</div>

@endsection