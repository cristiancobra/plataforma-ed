
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

            <div class="secao-iframe" style="padding: 20px">
                <h2 class="subtitulo-roxo" style="text-align: left">CRIAR EMAIL PRINCIPAL</h2>
                <ol><h4>Usuário Grátis</h4>
                    <li><a href="https://acadia.mxroute.com:2083/cpsess2189633698/frontend/manager/email_accounts/index.html#/create" TARGET="blank">Criar novo email </a> seguindo o modelo:
                        <br><br>
                        <b> nome.sobrenome@empresadigital.net.br</b>
                        <br>
                        Colocar <b> 2GB</B>em <b> STORAGE SPACE</b> 
                        <br>
                        Clicar em <b> SENHA > GERAR</B>. <a href="https://vendas.empresadigital.net.br/index.php?action=index&module=Contacts&searchFormTab=basic_search&query=true&clear_query=true" TARGET="blank">Salve esta senha no CRM</a> na DESCRIÇÃO do cliente.
                </ol>

                <ol><h4>Usuário Empresa</h4>
                    <li>Fazer os passo acima e<a href="https://acadia.mxroute.com:2083/cpsess2189633698/frontend/manager/mail/addfwd.html" TARGET="blank"> CRIAR ENCAMINHAMENTO DE EMAIL </a>.
                        <br><br>
                </ol>

                <br>

                <h2 class="subtitulo-roxo" style="text-align: left">CRIAR CONTAS DO CLIENTE</h2>
                <h3>Plataforma Empresa Digital</h3>
                <ol>
                    <li><a href="/logout">Faça logout</a> e cadastre o novo usuário em register.</li>
                </ol>
                <br>


                <h3>SuiteCRM</h3>
                <ol>
                    <li><a href="https://vendas.empresadigital.net.br/index.php?module=Users&action=EditView&return_module=Users&return_action=DetailView" TARGET="blank">Criar novo usuário no SuiteCRM</a>
                        <br>Preencher apenas os campos abaixo:
                        <br>Em <b>nome de usuário </b> usar o modelo: <b> nome.sobrenome </b> (tudo minúsculo e junto. Usar dados do próprio CRM)
                        <br>Em <b>EMAIL </b> usar o modelo: <b> nome.sobrenome@empresadigital.net.br</b>
                        <br>Clicar em <b>CONFIGURAÇÕES </b> no final da página. Na aba CONTAS DE EMAIL cadastrar novo email seguindo o modelo:
                        <br>
                        <br><B>EMAIL DE ENTRADA</b>
                        <br><b>Nome da Conta de Email:</b> Nome do Cliente (maiúsculas e espaço)
                        <br><b>Usuário para Login:</b> colocar email completo
                        <br><b>Senha:</b> senha do cliente
                        <br><b>Endereço do Mail Server:</b> acadia.mxroute.com  	
                        <br><b>Protocolo de Servidor de Correio:</b> IMAP
                        <br><b>Utilize SSL:</b>  SIM (marcar)
                        <br>	
                        <br>Porta do Servidor de Correio: 993
                        <br>Pasta Monitorada: manter o padrao
                        <br>Pasta do Lixo: cliar e selecionar   INBOX/Trash
                        <br>Pasta Enviada:   	INBOX/Sent
                        <br>
                        <br>Assinaturas: padrão
                        <br>
                        <br><b>EMAIL DE SAÍDA</b>
                        <br><b>Responder para: </b>repetir email do cliente
                        <br><b>Servidor de correio SMTP de saída</b>:  system (acadia.mxroute.com)
                        <br><b>Usuário SMTP:</b> crm@empresadigital.net.br
                        <br><b>Senha SMTP</b>: senha da empresa digital
                        <br>
                    </li>
                    <br>
                    <li>Na próxima tela em <b>CONTAS DE EMAIL</b>desmarcar o email de Empresa Digital (grupo)                       
                        <br><br>
                    <li><a href="https://vendas.empresadigital.net.br/index.php?module=SecurityGroups&action=EditView&return_module=SecurityGroups&return_action=DetailView" TARGET="blank">Criar <b>GRUPO DE SEGURANÇA </a></b> com o <b>Nome da Empresa</b> e atribuido ao cliente.
                    </li>
                    <br><br>
                    <li>Na tela seguinte adicionar o cliente como <b>usuário</b> no seu <b>GRUPO DE SEGURANÇA e retirar do grupo EMPRESA DIGITAL</b> no final da página. E <b>adicionar o PERFIL "Administrador da Empresa"</b>
                    </li>
                    <br><br>
                    <li>Acessar o email do cliente e pegar a senha do SuiteCRM. Fazer login como clientee:<br>
                        <ul>alterar a senha (usar a mesma senha do email do cliente.</ul>
                        <ul>Na página INICIO do CRM do cliente apagar (clicar no X) os dashlets: Feed, MINHAS CONTAS, MINHAS LIGACOES</ul>
                        <ul>e adicionar AGENDA </ul>
                    </li>
                </ol>

                <br>
                <h3>Nextcloud</h3>
                <ol><h4>Usuário Grátis</h4>
                    <li><a href="https://nuvem.empresadigital.net.br/index.php/settings/users" TARGET="blank">Criar nova conta na nuvem</a> seguindo o modelo:
                        <br><br>

                        <b> Nome de Usuário:</b> nome.sobrenome
                        <br>
                        <b> Exibir nome:</b> Nome Sobrenome (maiúsculas e espaço)
                        <br>
                        <b> Senha:</b> mesma do email
                        <br>
                        <b> Email:</b> email do cliente
                        <br>
                        <b> Grupos:</b> criar grupo com nome da empresa (maísculas e espaço). <b>Adicionar Cobra, Nathalia, Evelym e Guilherme no grupo do cliente</b>
                        <br>
                        <b>  Grupo administrativo para:</b> não alterar
                        <br>
                        <b> Cota:</b> 5GB
                        <br>


                        Clicar em <b> SENHA > GERAR</B>. <a href="https://vendas.empresadigital.net.br/index.php?action=index&module=Contacts&searchFormTab=basic_search&query=true&clear_query=true" TARGET="blank">Salve esta senha no CRM</a> na DESCRIÇÃO do cliente.
                </ol>

                <ol><h4>Usuário Empresa</h4>
                    <li>Fazer os passo acima, mudar apenas a  <b> COTA</b> para 10GB.
                        <br><br>
                </ol>

                <h4 STYLE="color: red">Marcar tarefa como concluida no CRM e enviar mensagem para Nathalia :</h4>
                <b> PLATAFORMA CRIADA</b><br>
                NOME CLIENTE: Wendy Palo<br>
                EMAIL: wendy.palo@empresadigital.net.br<br><br>
                https://vendas.empresadigital.net.br/index.php?action=index&module=Contacts&searchFormTab=basic_search&query=true&clear_query=true
                <br><br>

                <h2 class="subtitulo-roxo" style="text-align: left">CONFIGURAR WORDPRESS </h2>
                <h3>Site novo</h3>
                <ol><li><a href="https://empresadigital.net.br/wp-admin/network/site-new.php" target="blank">Criar novo site na Rede de Sites.</a></li>
                    <li><a href="https://62.171.185.126:8090/websites/empresadigital.net.br" target="blank">Criar um child domain em ADD DOMAINS (dentro do site Empresa Digital).</a>
                    <li>Entrar no child domain WEBSITE > LISTAR CHILD DOMAINS, e clicar em VHOSTS:
                        Na primeira linha apagar o nome do domínio:
                        docRoot                   /home/empresadigital.net.br/public_html/sintufscar.empresadigital.net.br
                        GUARDAR
                        Configurar dominio no DOMAIN MAPPING
                    </li>
                </ol>
                <br>

                <h3>Migração de site</h3>
                <ol>
                    <li>Fazer backups da Rede de Sites</li>
                    <br>
                    <li>Fazer backups do site a ser migrado</li>
                    <br>
                    <li><a href="https://empresadigital.net.br/wp-admin/network/site-new.php" target="blank">Criar novo site na Rede de Sites.</a></li>
                    <br>
                    <li><a href="https://62.171.185.126:8090/websites/empresadigital.net.br" target="blank">Criar um child domain em ADD DOMAINS (dentro do site Empresa Digital).</a>
                        <br>
                    <li>Entrar no child domain WEBSITE > LISTAR CHILD DOMAINS, e clicar em VHOSTS:
                        Na primeira linha apagar o nome do domínio:
                        docRoot                   /home/empresadigital.net.br/public_html/sintufscar.empresadigital.net.br
                        GUARDAR
                        Configurar dominio no DOMAIN MAPPING
                    </li>
                    <br>

                    <li>Criar um Novo Site na Rede</li>
                    <li>Pegar ID deste novo site <br>
                        Isso é usado para identificar sua pasta no diretório wp-content/uploads/sites e também para identificar as tabelas de banco de dados para esse site.
                        Faça isso indo em Redes Admin > Sites e, em seguida, selecionando a opção de editar para o site que você acabou de criar. A URL do WordPress te dará o ID do site.
                    </li>
                    <br>
                    <li>Fazer upload dos arquivos <br>
                        Identifique os plugins utilizados pelo seu site antigo e os instale (caso eles já não estejam instalados) na rede de seu WordPress através da seção de Plugins ou envie para wp-content/plugins do backup que você tirou do seu site antigo.
                        <br>
                        Faça o mesmo para quaisquer temas que seu site esteja usando — copia eles a partir do seu backup para o diretório wp-content/themes de sua rede, ou reinstalá.
                        <br>
                        Copie os uploads do seu site antigo para o novo. Você precisará copiar os arquivos estão em wp-wp-content/uploads em seu site antigo. O local em que você vai fazer o upload dos arquivos vai depender quanto tempo a rede tem:

                        Se a rede foi criada após WordPress 3.5, terá uma pasta de sites em wp-content/uploads. Encontre a subpasta com ID do seu site e envie o conteúdo da pasta wp-content/uploads do seu site antigo para aquela.

                        Nota: você pode precisar excluir qualquer pasta que WordPress criou para seu novo site em sites ou blogs.dir para evitar qualquer conflito.

                        Uma vez que você tenha finalizado tudo isso, ative qualquer tema ou plugin no seu novo site.
                    </li>
                    <li>  Exportando Tabelas do Seu Site Antigo

                        WordPress Multisite usa tabelas de banco de dados separado para cada site na rede. Em vez de armazenar os posts em seu site em wp_posts, por exemplo, ele armazena em wp_XX_posts, onde XX é a identificação do seu site.

                        No entanto, ele não usa tabelas separadas para dados do usuário — isso é armazenado em uma tabela wp_users e wp_usermeta para toda a rede.

                        Isso significa que você precisará copiar todas as tabelas do seu site antigo do outro lado exceto as duas tabelas de usuário, e você precisará alterar os nomes dos arquivos que você está copiando. Infelizmente, você terá que criar os usuários manualmente no novo site usando as telas de admin do WordPress.

                        Para obter mais informações sobre tabelas de vários sites e banco de dados, consulte este tutorial sobre o banco de dados WordPress Multisite.

                        No PhpMyAdmin para seu antigo site, clique na tab Estrutura. Em seguida, selecione todas as tabelas exceto wp_users e wp_usermeta. Um exemplo é mostrado abaixo.
                    </li>
                    <br>
                    <li>Clique sobre a seleção:na caixa de lista suspensa, selecione Exportar e depois clique em Executar. Isto irá baixar o arquivo sql para sua máquina com o conteúdo dessas tabelas.
                    </li>
                    <li>Adicionando Usuários<br>

                        Como eu mencionei acima, você não pode copiar as tabelas wp_users e wp_usermeta como estas serão duplicadas na rede em vários locais.

                        Antes de começar a importar as tabelas que você acabou de baixar, configure os mesmos usuários em seu novo site como você tinha no antigo. Note que eles terão IDs identificações diferentes no banco de dados da rede diferentes do site antigo,o que pode causar algumas imprecisões, como atribuição de lugares para autores. Você precisará corrigir isso no final, que abordarei mais tarde.
                        Edição de Tabelas do Banco de Dados

                        Faça uma cópia do arquivo sql que foi baixado para sua máquina e de-lhe um nome que lhe diz o que é (por exemplo, adicionando copia ao nome). Abra em um editor de código.
                        Editando os Links

                        Altere todas as instâncias do domínio do site na rede em vários locais para seu novo domínio em vários locais. Por exemplo, se seu site for http://mysite.com, altere para http://network.com/mysite. Se sua rede usa subdomínios você precisará alterá-lo para http://mysite.network.com. Salve seu arquivo.
                        Edição de Tabela de Referências

                        As tabelas de banco de dados no seu novo Multisite precisará de prefixos para a identificação do local. No seu arquivo sql, substitua todas as instâncias do wp_ para wp_XX_, onde XX é o seu ID do local.

                        Agora salve o arquivo sql.
                    </li>

                    <li>Importação de Tabelas Para o Novo Banco de Dados<br>

                        Agora que você já instalou os seus temas e plugins e exportou seus dados, você precisará importar as tabelas de banco de dados para sua rede Multisite.
                        Descartando as Tabelas Existentes

                        Antes de enviar as tabelas do seu site antigo, você precisará excluir as tabelas duplicada que o WordPress tenha adicionado ao seu novo site.

                        No phpMyAdmin, descarte quaisquer tabelas que são prefixadas com wp_XX_, onde XX é o ID do seu site. Estas incluem as seguintes, mas também pode incluir tabelas criadas por plugins:

                        wp_XX_commentmeta
                        wp_XX_comments
                        wp_XX_links
                        wp_XXoptions
                        wp_postmeta
                        wp_posts
                        wp_terms
                        wp_term_relationships
                        wp_term_taxonomy

                        Selecione as tabelas (mas quaisquer tabelas de wp_XX_ criadas por plugins), Selecione: menu suspenso, selecione o Drop e Sim.

                        O exemplo a seguir inclui uma tabela extra foi criado por um plugin:
                        database tables selected ready to be dropped

                        Importante: Se seu site antigo tinha tabelas de banco de dados que foram criadas por plug-ins, você deve instalar os mesmos plugins na rede antes de importar o novo banco de dados. A importação irá incluir estes tabelas, que não funcionará a menos que o plugin tenha sido instalado.
                        Subindo as Tabelas de Banco de Dados

                        Em seguida suba o banco de dados que você já editou:

                        Clique na guia de Importação.
                        Clique no botão Escolher arquivo.
                        Selecione o arquivo sql que editou e clique em Escolher ou OK.
                        Clique no botão Executar.
                        Depois de um tempo (dependendo do tamanho do seu banco de dados), você verá uma mensagem informando o upload foi concluído com êxito.
                    </li>
                    <li>Passos Finais<br>

                        Limpe o cache do seu navegador. Isso evita qualquer problema que possa ter caso seu navegador tenha cache de conteúdo do seu site antigo.

                        Agora acesse o admin do WordPress do site remoto. Se você moveu as tabelas de usuário do outro lado, seus detalhes de login será o mesmo para seu site antigo, mas se não, será o que você especificou quando você instalou o WordPress no novo local.

                        Visite a tela Links Permanentes para seu novo site e ative os links amigáveis.

                        De uma olhada em Posts na tela principal e verifique quais autores têm sido atribuídos a eles — há uma boa chance de que isso esteja errado. Você pode mudar isso em massa:

                        Selecione todos os posts que devem ser atribuídos a um determinado autor.
                        Clique em Ações de Massa e Editar.
                        Clique em Aplicar.
                        No painel que aparecer, selecione o autor correto da caixa suspensa.
                        Clique em Atualizar.

                        No painel de edição é mostrado a captura de tela:
                        Posts screen showing bulk editing actions

                        Se seu site tiver páginas e tipos de post pesonalizados, repita o processo acima para eles.

                        Verifique se todos os links estão funcionando e se os widgets e plugins estão se comportando como deveriam. Se não, você pode voltar no passo anterior do processo, usando seus backups, ou simplesmente configurando os plugins e widgets de dentro de seu novo site.
                        Configurando o Mapeamento de Domínio

                        Se você quiser manter o mesmo nome de domínio que você estava usando para o site quando estava em uma instalação de site unica, você pode usar o plugin de mapeamento de domínio para fazer isso. Instale o plugin, ative na sua rede e em seguida, siga as instruções dadas pelo plugin para configurá-lo. Isto envolve fazer alterações nas configurações de DNS do seu domínio.
                    </li>
                    os arquivos do theme e plugin — você pode copiar estes arquivos ou instalá-los na sua rede de sites, se eles já não estiverem instalados
                    uploads— você encontrará estes em wp-content/uploads em seu site antigo, enquanto na instalação em vários locais precisarão ir para wp-content/uploads/sites/XX, onde XX é o ID do seu novo site na rede ( em breve)
                    tabelas de banco de dados





                </ol>
                <br>

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


                </p>


            </div>



        </div>
    </body>
</html>
