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
            <div class="financeiro" style="padding-top: 1%; padding-bottom: 2%">
                <p class="subtitulo-branco">FINANCEIRO</p>
                <br>
                <a href="/gerenciador-financeiro">
                    <button class="botao-claro">GERENCIAR</button></a><br>
            </div>

            <div class="contratos" style="padding-top: 1%; padding-bottom: 2%">
                <p class="subtitulo-branco">CONTRATOS DIGITAIS</p>
                <br>
                <a href="https://painel.autentique.com.br/" target="blank">
                    <button class="botao-claro">ACESSAR</button></a><br>
            </div>

            <div class="nova-plataforma" style="padding-top: 1%; padding-bottom: 2%">
                <p class="subtitulo-branco">NOVA PLATAFORMA</p>
                <br>
                <a href="/instalar-plataforma" target="blank">
                    <button class="botao-claro">CRIAR</button></a><br>
            </div>

            <div class="emails" style="padding-top: 1%; padding-bottom: 2%">
                <p class="subtitulo-branco">GERENCIAR EMAILS</p>
                <br>
                <a href="https://acadia.mxroute.com:2083/" target="blank">
                    <button class="botao-claro">CRIAR CONTAS</button></a><br>
                login: solucoes
            </div>

            <div class="migracoes" style="padding-top: 1%; padding-bottom: 2%">
                <p class="subtitulo-branco">MIGRAÇÕES</p>
                <br>
                <a href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Empresa%20Digital/operacional/plataforma&fileid=8431" target="blank">
                    <button class="botao-claro">ACESSAR</button></a><br>
                login: xxxxxx
            </div>

            <div class="servidores" style="padding-top: 1%; padding-bottom: 2%">
                <p class="subtitulo-branco">SERVIDORES</p>
                <br>
                <a href="https://62.171.185.126:8090/" target="blank">
                    <button class="botao-claro">SERVIDOR NOVO</button></a><br>
                login: admin
                <br>
                <a href="https://167.86.97.159:2087" target="blank">
                    <button class="botao-claro">SERVIDOR ANTIGO</button></a><br>
                login: root
            </div>
        </div>
    </body>
</html>