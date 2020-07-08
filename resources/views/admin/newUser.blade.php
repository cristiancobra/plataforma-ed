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

                    <br><br><br><p class="titulo-branco"> Editar Usuário</p>
                    <p class="destaque_amarelo">Este é o guia rápido da sua plataforma Empresa Digital </p>
                    <br>
                    <br>
                    <br>
                    <form action=" {{ route('user.store') }} " method="post" style="padding: 40px;color: white">
                        @csrf
                        <label for="" >Nome do usuário: </label>
                        <input type="text" name="name">
                        <br>
                        <br>
                        <label for="">Email do usuário: </label>
                        <input type="email" name="email">   
                        <br>
                        <br>
                        <label for="">Senha do usuário: </label>
                        <input type="password" name="password">   
                        <br>
                        <br>
                        <input type="submit" value="Cadastrar usuário">

                    </form>
                </div>     

                <div class="imagem">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
                </div>

            </div>
        </div>
    </body>
</html>
