<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Empresa Digital</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <script src="{{ asset('js/menu.js') }}" async defer></script>

    </head>
    <body>
        @include('menu-plataforma')

        <div id="main">
            <div class="container" >     <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->

                <div class="header">

                    <div class="botao-ativar">
                        <!-- Use any element to open the sidenav -->
                        <span onclick="openNav()"><i class="fas fa-rocket"></i></span>
                    </div>

                    <br><br><br><p class="titulo-branco"> Olá {{ $user->name }} </p>
                    <p class="destaque_amarelo">Este é o guia rápido da sua plataforma Empresa Digital </p>
                    <br>
                    <br>
                    <br>

                </div>     

                <div class="imagem">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
                </div>

                <div class="tarefas">
                    <p class="numeros_painel">  {{ $total_tarefas }}</p>                        <p class="subtitulo-branco"> tarefas pendentes </p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/crm" style="color: yellow">fazer</a></p>
                </div>

                <div class="potenciais">
                    <p class="numeros_painel">  {{  $total_potenciais, }}</p>                        <p class="subtitulo-branco"> potenciais aguardando </p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/crm" style="color: yellow">contatar</a></p>
                </div>

                <div class="oportunidades">
                    <p class="numeros_painel"  style="font-size: 40px">  R$ {{ $valor_oportunidades }},00</p>                        <p class="subtitulo-branco"> em<br>oportunidades</p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/oportunidades" style="color: yellow">vender</a></p>
                </div>



                <div class="item4">
                    <p class='subtitulo-roxo'> 4 <br> TAREFAS: </p>
                    <p style="color: #874983">Verifique quais tarefas devem ser executadas por prioridade; Primeiro as que estão em atraso e depois as emergenciais. Distribua ao longo do dua e marque em sua agenda. </p>
                </div>

            </div>
        </div>
    </body>
</html>
