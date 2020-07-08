
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

            <div class="" style="padding: 20px">
                <ol>
                    <h2 class="subtitulo-roxo" style="text-align: left">CRIAR EMAIL PRINCIPAL</h2>
					<br>
                    <li><a href="https://acadia.mxroute.com:2083/cpsess2189633698/frontend/manager/email_accounts/index.html#/create" TARGET="_blank">Criar novo email (usar o login solucoes)</a> seguindo o modelo:
                        <br><br>
                        <b> nome.sobrenome@empresadigital.net.br</b>
                        <br>
                        Colocar <b> 1GB</B>em <b> STORAGE SPACE</b> 
                        <br>
                        Clicar em <b> SENHA > GERAR</B>. <a href="https://vendas.empresadigital.net.br/index.php?action=index&module=Contacts&searchFormTab=basic_search&query=true&clear_query=true" TARGET="_blank">Salve esta senha no CRM</a> na DESCRIÇÃO do cliente.


						<br>

						<h2 class="subtitulo-roxo" style="text-align: left">CRIAR CONTA PLATAFORMA EMPRESA DIGITAL</h2><br><br>


                    <li><a href="{{ route('user.create') }}" target="_blank">Criar nova conta de usuário</a> seguindo o modelo:</li>
					<br>
					<br><b>Name:</b> Nome completo (Nome e Sobrenome Maíusculas com espaço)
					<br><b>Email adrress:</b> email criado da @empresadigital.net.br
					<br><b>Password:</b> senha do email
					<br><b>Confirm Password:</b>senha do email
					<br><b>Seu dominio:</b> nomesobrenome.empresadigital.net.br (nome e sobrenome junto, sem ponto e sem maiúsculas)
					<br><b>Nível de acesso:</b> Cliente
					<br><br>
					Enviar clicando com o botão <b>REGISTER</b>.
                    <br>

                    <h2 class="subtitulo-roxo" style="text-align: left">CRIAR CONTA CRM</h2><br><br>

                    <li><a href="https://vendas.empresadigital.net.br/index.php?module=Users&action=EditView&return_module=Users&return_action=DetailView" TARGET="_blank">Criar novo usuário no SuiteCRM</a>
                        <br>Preencher apenas os campos abaixo:
                        <br>Em <b>nome de usuário </b> usar o modelo: <b> nome.sobrenome </b> (tudo minúsculo e junto. Usar dados do próprio CRM)
                        <br>Em <b>EMAIL </b> usar o modelo: <b> nome.sobrenome@empresadigital.net.br</b>
						<br>Na aba <b>SENHA </b> adicione a mesma senha do email <br>
						Clicar no botão SALVAR.</li>
					<br><br>
					<li>Deslogar do CRM e logar como cliente</li>
					<br><br>
					<li>Nas próximas telas clicar no botão PRÓXIMO até CONCLUIR (sem alterar nada)</li>
					<br><br>
					<li>Remover as dashlets (clicar no X) da página inicial do CRM do cliente:<br>
						- MEU FLUXO DE ATIVIDADES <br>
						- MINHAS CONTAS<br>
					</li>
					<br><br>
					<li>Na aba AÇÕES clique em ADICIONAR DASHLETS e adicione:<br>
						- AS MINHAS TAREFAS EM ABERTO<br>
						- MINHA AGENDA<br>
						<br><br>
					</li>
					<li>Organize as dashlets (agenda do lado esquerdo) e mova as outras do lado direito, na ordem:<br>
						- AS MINHAS TAREFAS EM ABERTO<br>
						- MINHAS REUNIOES<br>
						- MINHAS MELHORES OPORTUNIDADES<br>
						- MEUS POTENCIAIS
					</li>
					<br><br>

					<li>Clicar no nome do cliente no canto superior direito. Selecionar  <b>PERFIL </b> e no final da página clique em <b>CONFIGURAÇÕES </b>. Na aba CONTAS DE EMAIL clique no botão ADICIONAR. Preencha seguindo o modelo:
                        <br>
                        <br><B>EMAIL DE ENTRADA</b>
                        <br><b>Nome da Conta de Email:</b> Nome do Cliente (maiúsculas e espaço)
                        <br><b>Usuário para Login:</b> colocar email @empresadigital.net.br
                        <br><b>Senha:</b> senha do email
                        <br><b>Endereço do Mail Server:</b> acadia.mxroute.com  	
                        <br><b>Protocolo de Servidor de Correio:</b> IMAP
                        <br><b>Utilize SSL:</b>  SIM (marcar)
                        <br>	
                        <br>Porta do Servidor de Correio: 993
                        <br>Pasta Monitorada: manter o padrao
                        <br>Pasta do Lixo: clicar e selecionar   INBOX/Trash
                        <br>Pasta Enviada:   	INBOX/Sent
                        <br>
                        <br>Assinaturas: padrão
                        <br>
                        <br><b>EMAIL DE SAÍDA</b>
                        <br><b>Responder para: </b>repetir email do cliente
                        <br><b>Servidor de correio SMTP de saída</b>:  system (acadia.mxroute.com)
                        <br><b>Usuário SMTP:</b> crm@empresadigital.net.br
                        <br><b>Senha SMTP</b>: senha da empresa digital
                        <br><br>
						Clicar em CONCLUIDO.
                    </li>
                    <br>
                    
                    <li>Deslogue do CRM  e crie o<a href="https://vendas.empresadigital.net.br/index.php?module=SecurityGroups&action=EditView&return_module=SecurityGroups&return_action=DetailView" TARGET="_blank"> <b>GRUPO DE SEGURANÇA </a></b> com o <b>Nome da Empresa</b> e atribuido ao cliente. SALVAR
                    </li>
                    <br><br>
                    <li>Na tela seguinte clicar em USUÁRIOS e selecionar o cliente. Em PERFIS clique em selecionar <b>adicionar o PERFIL "Administrador da Empresa"</b>
                    </li>
                    <br><br>
                    <h2 class="subtitulo-roxo" style="text-align: left">CRIAR CONTA NUVEM</h2><br><br>

                    <li><a href="https://nuvem.empresadigital.net.br/index.php/settings/users" TARGET="_blank">Criar nova conta na nuvem</a> seguindo o modelo:
                        <br><br>

                        <b> Nome de Usuário:</b> nome.sobrenome
                        <br>
                        <b> Exibir nome:</b> Nome Sobrenome (maiúsculas e espaço)
                        <br>
                        <b> Senha:</b> mesma do email
                        <br>
                        <b> Email:</b> email do cliente
                        <br>
                        <b> Grupos:</b> Nome Sobrenome (maiúsculas e espaço) e <b>apertar o ENTER</b> para criar o grupo.
                        <br>
                        <b>  Grupo administrativo para:</b> não alterar
                        <br>
                        <b> Cota:</b> 5GB
                        <br>
						Clicar no botão roxo de confimarção.
                    </li>
					<br>
                    <li>Na lista de usuário, na linha do usuário COBRA na coluna GRUPOS, adicione o grupo do cliente que acabou de ser feito. Faça o mesmo com os usuários Evelyn e Nathalia.</li>
					<br><br>


					<h2 class="subtitulo-roxo" style="text-align: left">CRIAR CONTA FINANCEIRA</h2><br><br>


					<li><a href="https://financeiro.empresadigital.net.br/sales/customers/create" TARGET="_blank">Criar conta do cliente</a> seguindo o modelo:
                        <br><br>

                        <b> Nome:</b> Nome Sobrenome (maisculas iniciais)
                        <br>
                        <b> Email:</b> Email do cliente
                        <br>
                        <b> Número de identificação fiscal:</b> em branco por enquanto
                        <br>
						<b> Moeda:</b> real
                        <br>
						<b> Telefone:</b>  em branco por enquanto
                        <br>
						<b> Site:</b>  em branco se não souber
                        <br>
						<b> Endereço:</b>  em branco se não souber
						<br>

						<b> Referencia:</b>  manter como está
						<br>
						<b> Ativado:</b> SIM
						<br>
						<b> Pode logaro:</b> Marcar
						<br>						

                        <br>
           

					<li>Marcar tarefa como concluida no CRM </li>
					<br><br>
					<li><a href="https://empresadigital.net.br/wp-admin/network/site-new.php" target="_blank">Criar NOVA TAREFA</a> para Nathalia de acordo com o modelo:</li><br>
					<b> ASSUNTO</b>: Apresentar plataforma<br>
					<b> DATA DE INÍCIO</b>:colocar o dia de hoje<br>
					<b> DATA DE LIMITE</b>:colocar 2 dias depois da data de hoje <br>
					<b> PRIORIDADE</b>: Alta<br>
					<b> STATUS</b>: Não iniciada<br>
					<b> REFERENTE À</b>: Oportunidade (no campo de baixo clicar ne SETA e fazer uma busca por NOME DA CONTA e selecionar (clicar no nome da conta).<br>
					<b> NOME DO CONTATO</b>:  clicar ne SETA e fazer uma busca por NOME DA CONTA e selecionar (clicar no nome da conta).<br>
					<b> DESCRIÇÃO</b>:  anotar qualquer informação adicional.<br>

					<b> ATRIBUÍDO À</b>: Nathalia Locks<br>

					</li>
					<br><br>



					<h2 class="subtitulo-roxo" style="text-align: left">CONFIGURAR WORDPRESS </h2>
					<h3>Site novo</h3>
                    <li><a href="https://empresadigital.net.br/wp-admin/network/site-new.php" target="_blank">Criar novo site na Rede de Sites.</a></li>
                    <li><a href="https://62.171.185.126:8090/websites/empresadigital.net.br" target="_blank">Criar um child domain em ADD DOMAINS (dentro do site Empresa Digital).</a>
                    <li>Entrar no child domain WEBSITE > LISTAR CHILD DOMAINS, e clicar em VHOSTS:
                        Na primeira linha apagar o nome do domínio:
                        docRoot                   /home/empresadigital.net.br/public_html/
                        GUARDAR
                        Configurar dominio no DOMAIN MAPPING
                    </li>

                    <br>

                    <h3>Migração de site</h3>

                    <li>Fazer backups do site a ser migrado</li>
                    <br>
                    <li><a href="https://empresadigital.net.br/wp-admin/network/site-new.php" target="_blank">Criar novo site na Rede de Sites.</a></li>
                    <br>
                    <li><a href="https://62.171.185.126:8090/websites/empresadigital.net.br" target="_blank">Criar um child domain em ADD DOMAINS (dentro do site Empresa Digital).</a>
                        <br>
                        <br>
                        <b>Nome de Domínio:</b> empresa_do_cliente.empresadigital.net.br<br>
                        <b>Caminho:</b> deixar em branco<br>
                        <b>Selecionar PHP:</b> 7.4<br>
                        <b>Funcionalidades Adicionais:</b>Marcar apenas SSL</b><br>
                        <br>
                        <br>
                    <li>Vá em <a href="https://62.171.185.126:8090/websites/listChildDomains"> LISTAR CHILD DOMAINS</a>. Seleciona o domínio criado acima e clique em MANAGE > VHOSTS:<br>
                        Na primeira linha apagar o nome do domínio, como no modelo abaixo:<br>
                        <b>docRoot </b>                  /home/empresadigital.net.br/public_html/sintufscar.empresadigital.net.br<br>
                        GUARDAR</li>
                    <br>
                    <br>


                    <li><b>Copiando os arquivos do site antigo <br></b>
                        Acessar o site via FTP (Filezilla) ou SSH. Fazer cópia de segurança da pasta do wordpress<br><br>

                    <li><b>Copiando os arquivos do site NOVO <br></b>

                        Entre na pasta de sites em wp-content/uploads.
                        Encontre a subpasta com ID do seu site e envie o conteúdo da pasta wp-content/uploads do seu site antigo para: <br>
                        wp-content/id_do_site
                        <br>
                        <br>
                    <li>Verificar necessidade de migrar plugins e temas.</li>
                    <br>
                    <br>
                    <li>  Acessar banco de dados do<b> site antigo</b> pelo PhpMyAdmin. Clique na tab Estrutura. Selecione todas as tabelas exceto:
                        <br>
                        wp_users<br>
                        wp_usermeta
                        <br>
                        <br>
                    </li>
                    <br>
                    <li>Clique sobre a seleção:na caixa de lista suspensa, selecione Exportar e depois clique em Executar. Isto irá baixar o arquivo sql para sua máquina com o conteúdo dessas tabelas.
                    </li>
                    <br>
                    <br>
                    <li>Configure os mesmos usuários em seu novo site como você tinha no antigo.</li>
                    <br>
                    <br>
                    <li>Fazer backups da Rede de Sites</li>
                    <br>
                    <br>
                    <li>Subir o banco de dados exportado num banco de dados teste no phpmyadmin. </li>
                    <li>Exportar com o prefixo <b>wp_id_</b> substituindo pelo ID do site na rede de sites. </li>
                    <li>Excluir no banco da rede de sites as tabelas criada automaticamente com<b>wp_id_</b> do site na rede de sites. </li>
                    <li>Importar as tabelas dentro do banco da rede de sites. </li>
                    <li>Visite a tela Links Permanentes para seu novo site e ative os links amigáveis.</li>
                    <br>
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

                </ol>
                <br>

                <h2 class="subtitulo-roxo" style="text-align: left">Pré-configurações do site</h2>

                <li> Logar no site e configurar a página Home como estática (Configurações de Leitura)</li><br>
                <li> <a href="https://vendas.empresadigital.net.br/index.php?module=Tasks&action=EditView&return_module=Tasks&return_action=DetailView" target="_blank">Criar nova tarefa</a> no modelo:<br>
                    <br> <b>Nome: </b>criar site
                    <br> <b>Data de início: </b>data de hoje
                    <br> <b>Data limite: </b>data de hoje + 7 dias
                    <br> <b>Nome da conta: </b>conta (empresa) do cliente
                    <br> <b>Nome do contato: </b>nome do contato
                    <br> <b>Atribuido a: </b>Evelyn Postigo
                    <br>
                    <br>

                    <h4>Usuário Empresa (domínio próprio)</h4>

                <li>Pegar ID do domínio criado na <a href=https://empresadigital.net.br/wp-admin/network/sites.php">Rede de Sites</a>. Ver o ID no final do link/dominio (passe o mouse em cima, sem clicar).<br></li>
                <li>Configurar dominio em <a href="https://empresadigital.net.br/wp-admin/network/settings.php?page=dm_domains_admin">DOMAIN MAPPING</a> com ID e nome do domínio</li>
                <br>


                <br>
                <br>







                </ol>
                <br>

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
