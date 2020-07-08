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

        <div id="main">     <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->

            <div class="grid" > 

                <div class="header">

                    <div class="botao-ativar">
                        <!-- Use any element to open the sidenav -->
                        <span onclick="openNav()"><i class="fas fa-rocket"></i></span>
                    </div>

                    <p class="titulo-branco" style="padding-top: 7%"> Olá {{ $user->name }} </p>
                    <p class="destaque_amarelo">Este é o guia rápido da sua plataforma Empresa Digital </p>

                </div>

                <div class="imagem">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="250px" height="250px">
                </div>


                <div class="tarefas">
                    <p class="numeros_painel">  {{ $totalTasks }}</p>                        <p class="subtitulo-branco"> tarefas pendentes </p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/crm" style="color: yellow">fazer</a></p>
                </div>

                <div class="potenciais">
                    <p class="numeros_painel">  {{  $openLeads }} </p>                        <p class="subtitulo-branco"> potenciais aguardando </p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/crm" style="color: yellow">contatar</a></p>
                </div>

                <div class="oportunidades">
                    <p class="numeros_painel"  style="font-size: 40px">  R$ {{  $totalOpportunities }} </p>                        <p class="subtitulo-branco"> em<br>oportunidades</p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/oportunidades" style="color: yellow">vender</a></p>
                </div>

                <div class="imagem-destaque">
                    <img src=" {{ asset('imagens/plataforma.png') }} " width="100px" height="100px">
				</div>

				<div class="destaque">
										@foreach($myTasks as $myTask)
										<p>Tarefa: {{ $myTask->name }} <br></p>
						@endforeach

				
					<p style="color:purple; font-weight: 400;line-height: 2;padding-top: 4%"> Clique no ícone do <b>FOGUETE </b>no <b>canto superior esquerdo </b> para acessar seus fluxos e ferramentas a qualquer momento.</p>
                </div>

            </div>
        </div>
    </body>
</html>
