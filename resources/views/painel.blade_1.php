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



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">

            <div class="botao-ativar">
                <!-- Use any element to open the sidenav -->
                <span onclick="openNav()"><i class="fas fa-rocket"></i></span>
            </div>

            <div class="secao-roxa">
                <div class="coluna-esquerda" style="width: 55vw; margin-left: 10vw">
                    
                    <br><br><br><p class="titulo-branco"> Olá {{ $user->name }} </p>
                    <p class="destaque_amarelo">Este é o guia rápido da sua plataforma Empresa Digital </p>
                </div>
                <div class="coluna-direita" style="margin-top: 10px; text-align: left">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="280px" height="280px">
                </div>
            </div>
            <div class="secao-branca">
                <div class="coluna-4-branco">
                    <p class='subtitulo-roxo'> 1 <br> REUNIÕES: </p>
                    <p style="color: #874983">Verifique primeiro a AGENDA. Reuniões são PRIORIDADE e devem estar no topo da lista de atenção do dia. Certifique-se o seu cliente aceitou o convite de reunião. Assim você evita cancelamentos de última hora!</p>
                </div>
                <div class="coluna-4-branco">
                    <p class='subtitulo-roxo'> 2 <br> PROJETOS: </p>
                    <p style="color: #874983">Verifique as Tarefas de projetos em aberto e suas data limites. Tarefas de projeto são PRIORIDADE pois existem pessoas que dependem do fechamento da sua tarefapara dar proseguimento. Distribua suas tarefas de projeto que serão possíveis trabalhar ao longo do dia e marque em sua agenda.</p>
                </div>
                <div class="coluna-4-branco">
                    <p class='subtitulo-roxo'> 3 <br> TAREFAS: </p>
                    <p style="color: #874983">Verifique quais tarefas devem ser executadas por prioridade; Primeiro as que estão em atraso e depois as emergenciais. Distribua ao longo do dua e marque em sua agenda. </p>
                </div>
                <div class="coluna-4-branco">
                    <p class='subtitulo-roxo'> 4 <br> NOVA TAREFA: </p>
                    <p style="color: #874983">Antes de acrescentar novas tarefas comunique-se com toda a equipe e veja se existe alguma emergencia que necessita da sua expertisse para ser resolvida. E registre a tarefa a ser executada.</p>
                </div>
            </div>
            <div class="secao-roxa">
                <div class="coluna-esquerda">
                    <!--    5- FAÇA CONTATO: Responda emails e ligações pendentes e registre. -->

                </div>
            </div>
        </div>

    </body>
</html>
