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


        @include('painel')

        <div class="grid-admin">
            <div class="financeiro">
                <p class="subtitulo-roxo">FINANCEIRO</p>
                <br>
                <a href="/gerenciador-financeiro">
                    <button class="botao-roxo">GERENCIAR</button></a><br>
            </div>

            <div class="contratos">
                <p class="subtitulo-roxo">CONTRATOS DIGITAIS</p>
                <br>
                <a href="https://painel.autentique.com.br/" target="blank">
                    <button class="botao-roxo">ACESSAR</button></a><br>
            </div>

            <div class="nova-plataforma" >
                <p class="subtitulo-branco">NOVA PLATAFORMA</p>
                <br>
                <a href="/instalar-plataforma" target="blank">
                    <button class="botao-claro">CRIAR</button></a><br>
            </div>

            <div class="usuarios-plataforma" >
                <p class="subtitulo-branco">USUÁRIOS DA PLATAFORMA</p>
                <br>
                <a href="/usuarios" target="blank">
                    <button class="botao-claro">VER LISTA</button></a><br>
            </div>

            <div class="emails">
                <p class="subtitulo-branco">GERENCIAR EMAILS</p>
                <br>
                <a href="https://acadia.mxroute.com:2083/" target="blank">
                    <button class="botao-claro">CRIAR CONTAS</button></a><br>
                login: solucoes
                <br>
            </div>

            <div class="migracoes">
                <p class="subtitulo-roxo">MIGRAÇÕES</p>
                <br>
                <a href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Empresa%20Digital/operacional/plataforma&fileid=8431" target="blank">
                    <button class="botao-roxo">ACESSAR</button></a><br>
                login: xxxxxx
            </div>

            <div class="servidores">
                <p class="subtitulo-roxo">SERVIDORES</p>
                <br>
                <a href="https://62.171.185.126:8090/" target="blank">
                    <button class="botao-roxo">SERVIDOR NOVO</button></a><br>
                login: admin
                <br>
                <br>
                <a href="https://167.86.97.159:2087" target="blank">
                    <button class="botao-roxo">SERVIDOR ANTIGO</button></a><br>
                login: root
            </div>

            <div class="vendas">
                <p class="subtitulo-branco">FUNIL DE VENDAS</p>
                <br>
                <a href="/funil-vendas" target="blank">
                    <button class="botao-claro">INICIAR</button></a><br>
            </div>


        </div>
    </body>
</html>