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
                             <br>
                    <br>
                    <br>
              	  <form action=" {{ route('tutorial_plataforma') }} " method="post" style="padding: 40px;color: white">
                        @csrf
                        <label for="" >Nome do cliente: </label>
                        <input type="text" name="novo_nome">
                        <br>
                        <br>
                        <label for="">Sobrenome: </label>
                        <input type="text" name="novo_sobrenome">   
                        <br>
                        <br>
						<a href="https://passwordsgenerator.net/pt/" target="_blank" style="color: yellow">LINK PARA GERAR SENHA</a>
						<br><br>
                        <label for="">Senha do cliente: </label>
                        <input type="text" name="nova_senha">   
                        <br>
                        <br>
                        <input type="submit" value="iniciar instalação">

                    </form>
                </div>     

                <div class="imagem">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
                </div>

            </div>
        </div>
    </body>
</html>
