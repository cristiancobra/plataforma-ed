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
            <div class=''>
                <p>

                    1. CONFIGURAR DOMÍNIO													
                    1.1. Logar no cloudflare com login: contato@empresadigital.net.br
                    1.2. Clicar em ADD SITE, colocar domínio e plano FREE.
                    1.3. Adicionar RECORD A:
                    No primeiro campo = A
                    NAME = @
                    Ipv4 = 167.86.97.159
                    Clique em “Add Record”
                    1.4. Adicionar CNAME:
                    No primeiro campo = CNAME
                    NAME = www
                    Domain Name = @
                    Clique em “Add Record”
                    1.5. Adicionar primeira MX:
                    No primeiro campo = MX
                    NAME SERVER = acadia.mxroute.com
                    Priority = 10
                    Clique em “Add Record”
                    1.6. Adicionar segunda MX:
                    No primeiro campo = MX
                    NAME SERVER = acadia-relay.mxroute.com 
                    Priority = 20
                    Clique em “Add Record”
                    1.7. Adicionar segunda TXT:
                    No primeiro campo = TXT
                    NAME = @
                    TEXT = v=spf1 ip4:167.86.97.159 include:mxroute.com -all
                    Clique em “Add Record”
                    1.8. Direcionar DNS do domínio no site registro.br com os dados fornecidos pelo cloudflare.
                    2. CRIAR EMAILS															
                    2.1. Logar via navegador https://acadia.mxroute.com:2083/ com login solucoes
                    2.2. Clicar em CONTA > DOMAINS. Adicionar nome da empresa do cliente ao domínio @empresadigital.net.br.
                    2.3. Voltar e acessar EMAILS > CONTAS DE EMAIL clicar em criar e inserir os e-mails indicados pelo cliente.
                    2.4. Criar pasta do cliente na nuvem (usar pasta modelo) e salvar logins e senhas.
                    3. CONFIGURAR NEXTCLOUD										
                    3.1. Logar no Nextcloud com login: empresadigital
                    3.2. Criar usuário com nome do cliente, cota 1G para plataformas livre e 10GB Premium e usar a mesma senha do e-mail principal.
                    3.3. Criar grupo com nome da empresa do cliente e adicionar o usuário Empresa Digital neste grupo também.
                    3.4. Sair e logar com a conta do cliente.
                    3.5. Apagar a pasta Photos e Documents 
                    3.6. Mudar LINGUAGEM e LOCALIZAÇÃO para português brasileiro.
                    3.7. Colocar foto do perfil
                    3.8. Clonar a pasta empresa digital 
                    3.9. criar registro na PLATAFORMA com mesmo login e senha
                    3.10. colocar foto no perfil da PLATAFORMA
                    3.11. criar um GRUPO DE SEGURANÇA no CRM
                    3.12. nome da empresa – atribuído á: Administrador 
                    3.13. 

                </p>


                <h2>CONFIGURAR WORDPRESS </h2>
                <ol><li><a href="https://empresadigital.net.br/wp-admin/network/site-new.php" target="blank">Criar novo site na Rede de Sites.</a></li>
                    <li><a href="https://62.171.185.126:8090/websites/empresadigital.net.br" target="blank">Criar um child domain em ADD DOMAINS (dentro do site Empresa Digital).</a>
                        <li>Entrar no child domain WEBSITE > LISTAR CHILD DOMAINS, e clicar em VHOSTS:
                            Na primeira linha apagar o nome do domínio:
                            docRoot                   /home/empresadigital.net.br/public_html/sintufscar.empresadigital.net.br
                            GUARDAR
                            Configurar dominio no DOMAIN MAPPING
                        </li>
                    </ol>

                    4.4. Criar banco de dados (usuário novo)
                    a) Logar no Cyberpanel https://62.171.185.126:8090 
                    b) Coluna esquerda BANCO DE DADOS > CRIAR BASE DE DADOS > Escolher o site.
                    c) Colocar o NOME do banco de dados com wordpress e USUÁRIO também wordpress
                    d) Gerar senha no botão GERENTE e salvar logins e senhas no arquivo LOGINS E SENHAS na nuvem do cliente.
                    4.5. Instalar Wordpress
                    a) Logar via SSH na pasta themes:
                    ssh root@62.171.185.126 -p 2222
                    git clone https://github.com/cristiancobra/tema-empresadigital.git .
                    chown -R usuario:usuario .
                    b) Editar o arquivo com:  nano wp-config.php
                    c) Alterar os valores abaixo em amarelo pelo nome do banco de dados e o nome do usuário (que é igual) e a senha:
                    define( 'DB_NAME', 'nome-cliente_site' ); 
                    define( 'DB_USER', 'nome-cliente_site' ); 
                    define( 'DB_PASSWORD', 'senha-do-banco' );
                    d) Alterar proprietário dos arquivos via SSH:
                    sudo chown -R usuario:usuario *
                    e) Alterar Rewrite ruless /.htaccess ??????
                    f) Gerar SSL ??????????????
                    4.6. Importar banco de dados
                    4.7. Logar no CWPanel via navegador: https://167.86.97.159:2031/
                    4.8. Acessar SQL SERVERS > PHPMYADMIN. Fazer backup do banco de dados empresad_wpmod e exportar/salvar no Nextcloud, pasta backups.
                    4.9. Importar o banco de dados empresad_wpmod que foi salvo e importar no banco de dados do cliente: nome-cliente_site
                    4.10. Abrir no banco de dados do cliente a tabela  wp_optins e trocar site_url e home pelo domínio do cliente (com https://)
                    4.11. Logar no Wordpress do cliente com login empresadigital e criar login administrativo com nome do cliente. Usar e-mail padrão.
                    5. CONFIGURAR MAUTIC
                    5.1. Logar no Cyberpanel https://62.171.185.126:8090
                    5.2. Criar novo banco de dados em BANCO DE DADOS > CRIAR BASE DE DADOS > Escolher o site.
                    5.3. Colocar o NOME do banco de dados com nome-do-cliente e USUÁRIO também  nome-do-cliente
                    5.4. Gerar senha no botão GERENTE e salvar logins e senhas no arquivo LOGINS E SENHAS na nuvem do cliente.
                    5.5. Acessar SQL SERVERS > PHPMYADMIN. Fazer backup do banco de dados empresad_mautMOD e exportar/salvar no Nextcloud, pasta backups.
                    5.6. Importar o banco de dados empresad_mautMOD que foi salvo e importar no banco de dados do cliente: nome-cliente_mautic
                    5.7. Logar via SSH:
                    ssh root@62.171.185.126 -p 2222
                    5.8. Executar:
                    git clone https://github.com/cristiancobra/mautic-empresadigital.git .
                    5.9. Editar o arquivo com:
                    nano /home/dominio-do-cliente/public_html/app/config/local.php
                    5.10. Alterar os valores abaixo em amarelo pelo nome do banco de dados e o nome do usuário (que é igual) e a senha:
                     'db_name' => 'nome-cliente_mautic', 
                           'db_user' => 'nome-cliente_mautic', 
                           'db_password' => 'senha-do-banco',
                           'site_url' => 'https://dominio-cliente/modelo/mautic', 
                           'cache_path' => '/home/pasta-cliente/public_html/modelo/mautic/app/cache',         'log_path' => '/home/pasta-cliente/public_html/modelo/mautic/app/logs', 
                    'tmp_path' => '/home/pasta-cliente/public_html/teste/mautic/app/cache',
                    'report_temp_dir' => '/home/pasta-cliente/public_html/teste/mautic/app/../media/files/temp',  
                    'saml_idp_entity_id' => 'https://dominio-cliente',
                    5.11. Alterar proprietário dos arquivos via SSH:
                    sudo chown -R usuario:usuario *
                    5.12. Logar no Mautic do cliente (dominio.com.br/mautic) com login empresadigital
                    5.13. Substituir dados do usuário convidado pelos dados do cliente (usar login e senha padrão do cliente). Atribuir a função  usuario
                    5.14. Alterar CONFIGURAÇÕES DE SISTEMA
                    5.15. Alterar CONFIGURAÇÕES DE EMAIL
                    6. 
                    7. 7.1.2 ativar PLUGINS
                    7.4 configurar MAUTIC
                    8. CONFIGURAR AKAUNTING
                    8.1. Logar no Cyberpanel https://62.171.185.126:8090
                    8.2. Criar novo banco de dados em BANCO DE DADOS > CRIAR BASE DE DADOS > Escolher o site.
                    8.3. Colocar o NOME do banco de dados com nome-do-cliente e USUÁRIO também  nome-do-cliente
                    8.4. Gerar senha no botão GERENTE e salvar logins e senhas no arquivo LOGINS E SENHAS na nuvem do cliente.
                    8.5. Acessar SQL SERVERS > PHPMYADMIN. Fazer backup do banco de dados XXXXXMOD e exportar/salvar no Nextcloud, pasta backups.
                    8.6. Importar o banco de dados eXXXXXX que foi salvo e importar no banco de dados do cliente: nome-cliente_mautic
                    8.7. Logar via SSH:
                    ssh root@62.171.185.126 -p 2222
                    8.8. Executar:
                    git clone https://github.com/cristiancobra/akaunting-empresadigital.git .
                    8.9. Editar o arquivo com:
                    nano /home/dominio-do-cliente/public_html/.env
                    8.10. Alterar os valores abaixo em amarelo pelo nome do banco de dados e o nome do usuário (que é igual) e a senha:
                     'db_name' => 'nome-cliente_mautic', 
                           'db_user' => 'nome-cliente_mautic', 
                           'db_password' => 'senha-do-banco',
                           'site_url' => 'https://dominio-cliente/modelo/mautic', 

                    9. Alterar proprietário dos arquivos via SSH:
                    sudo chown -R usuario:usuario *
                    PROBLEMAS:
                    3. criar um SCRIPT pra gerar MODELO
                    5. SCRIPT -Criar um BANCO DE DADOS no CWPANEL e configurar para cada PROGRAMA da plataforma 

                    10. 





                    </p>  

            </div>
        </div>

    </body>
</html>
