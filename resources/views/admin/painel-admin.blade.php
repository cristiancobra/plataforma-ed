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
        <script src="{{ url(mix('js/menu.js')) }}" defer></script>

    </head>
    <body>

        @include ('menu-plataforma')


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">

            <div class="botao-ativar">
                <!-- Use any element to open the sidenav -->
                <span onclick="openNav()"><i class="fas fa-rocket"></i></span>
            </div>

            <div class="secao-roxa">
                <div class="coluna-esquerda">

                    <p class="titulo_branco"> Olá {{ $user->name }} </p>
                    <p class="destaque_amarelo">Bem vindo ao Painel Administrativo </p>

                </div>

                <div class="coluna-direita" style="margin-top: 10px">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="280px" height="280px"></a>
                </div>
            </div>
            <div class="secao-branca">
                <div class="coluna-4">
                    <p style="font-size:20px">GERENCIAR EMAILS</p>
                    <a href="https://acadia.mxroute.com:2083/" target="blank">
                        <button style="background: #874983; border-radius: 9px; padding: 12px; cursor: pointer; color: #fff; border-width: 2px; border-color: #c28dbf; font-size: 14px">CRIAR CONTAS</button></a><br>
                    login: solucoes
                </div>
                <div class="coluna-4">
                    <p style="font-size:20px">MIGRAÇÕES</p>
                    <a href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Empresa%20Digital/operacional/plataforma&fileid=8431" target="blank">
                        <button style="background: #874983; border-radius: 9px; padding: 12px; cursor: pointer; color: #fff; border-width: 2px; border-color: #c28dbf; font-size: 14px">CRIAR CONTAS</button></a><br>
                    login: xxxxxx
                </div>
                <div class="coluna-4">
                    <p style="font-size:20px">CONTRATOS DIGITAIS</p>
                    <a href="https://painel.autentique.com.br/" target="blank">
                        <button style="background: #874983; border-radius: 9px; padding: 12px; cursor: pointer; color: #fff; border-width: 2px; border-color: #c28dbf; font-size: 14px">CRIAR CONTAS</button></a><br>
                    login: xxxxxx
                </div>
                <div class="coluna-4">
                    4- NOVA TAREFA: Antes de acrescentar novas tarefas comunique-se com toda a equipe e veja se existe alguma emergencia que necessita da sua expertisse para ser resolvida. E registre a tarefa a ser executada.
                </div>
            </div>
            <div class="secao-roxa">
                <div class="coluna-esquerda">
                    5- FAÇA CONTATO: Responda emails e ligações pendentes e registre.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>