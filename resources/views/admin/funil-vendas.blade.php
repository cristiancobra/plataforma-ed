
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
				
				         3.1. Cadastrar como potencial
         3.2. Criar conta
         3.3. Gerar oportunidade
         3.4. nome da oportunidade: Número de usuários + tipo de usuário + produto 
           ex: 5 usuários empresa + Gestão de rede social 
         3.5. Fazer primeiro contato (apresentação)
         3.6. Reunião (análise das necessidades) 
         3.7. nome da reunião: apresentação da plataforma e briefing 
           referente á: oportunidade
         3.8. Clonar pasta de cliente modelo na nuvem: clientes > 1-modelo
         3.9. salvar no financeiro interno e enviar da proposta (orçamento)
         3.10. Concluir a fase da venda da oportunidade no CRM com PERDEMOS (fim do procedimento) ou GANHAMOS (adicione os dados da venda: valor, data de pagamento e produtos vendidos) e seguir para o próximo passo. 
         3.11. Criar tarefa de contrato no CRM.  
           nome da tarefa: Contrato
           referente á: oportunidade
				
                <ol style="line-height: 2">
                    <h2 class="subtitulo-roxo" style="text-align: left">CRM</h2>
                    <li><a href="/novopotencial" TARGET="_blank">Cadastrar como potencial</a> </li>

                    <li>Criar conta</li>
                    <li>Gerar oportunidade</li>
                    <li>Fazer primeiro contato (apresentação)</li>
                    <li>Reunião (análise das necessidades)</li>
                    <li>Clonar pasta de cliente modelo na nuvem: clientes > 1-modelo</li>
                    <li>salvar no financeiro interno e enviar da proposta (orçamento)</li>
                    <li>Concluir a fase da venda da oportunidade no CRM com PERDEMOS (fim do procedimento) ou GANHAMOS (adicione os dados da venda: valor, data de pagamento e produtos vendidos) e seguir para o próximo passo. </li>
                    <li>Criar tarefa de contrato no CRM.</li>

                    <h2 class="subtitulo-roxo" style="text-align: left">COBRANÇA</h2>
                    <li>Criar contrato a partir do CONTRATO MODELO dentro da pasta EMPRESA DIGITAL do CLIENTE e renomear CONTRATO EMPRESA SERVIÇOS ANO.</li>
                    <li>Alterar dados do contrato:</li>
                    a) serviços contratados (item 1 do contrato. Usar serviços base de contrato;
                    b) dados do cliente, nome empresa, CNPJ, responsavel e CPF (item 2);
                    c) alterar valor (item 5 do contrato).
                    <li>Logar no gerenciador financeiro</li>
                    <li>na coluna esquerda clique VENDAS/ FATURAS </li>
                    <li>Clique no botão adicionar novo</li>
                    <li>no campo cliente clique na flecha á esquerda e role até o fim e clique em adicionar novo: Adicione as informações: Nome completo, Email pessoal, Moeda real e número de identificação do cliente (colocar CPF e/ CNPJ) e salve. </li>
                    <li>Adicionar a data de emissão (dia em que a fatura está sendo criada) e data de vencimento. </li>
                    <li>Escolher os produtos e serviços fechados e quantidades. (verificar se o preço do produto fechado é   mesmo da tabela)</li>
                    <li>Escolher a categoria dos serviços contratados e salvar. </li>
                    <li>Marcar fatura como enviada</li>
                    <li>Duplicar o total de faturas a serem cobradas (no caso de compras parceladas) e alterar as datas de pagamento.</li>
                    <li>Enviar fatura para cliente e confirmar o pagamento</li>
                    <li>Criar tarefa CRM – Instalação da plataforma. </li>

                    <h2 class="subtitulo-roxo" style="text-align: left">INSTALAÇÂO DA PLATAFORMA </h2>

                    <h2 class="subtitulo-roxo" style="text-align: left">APRESENTAÇÃO DA PLATAFORMA E BRIEFING</h2>
                    <li>Agendar para até 2 dias após a instalação da plataforma</li>
                    <li>Preencher acima o nome do contato - (MESMO NOME DA PASTA CLIENTES)</li>
                    <li>Encaminhar menssagem por whats app de apresentação da plataforma </li>
                    <li>Senha e login </li>
                    <li>Explicação para subir os arquivos na nuvem </li>

                    <h2 class="subtitulo-roxo" style="text-align: left">7. SITE</h2>
                    <li>verificar o recebimento dos conteúdos solicitados ao cliente.</li>
                    <li>Caso não tenha sido enviado, fazer contato com o cliente salientando que o prazo de 30 dias começa a contar a partir do envio dos materiais.</li>
                    <li>Caso o cliente não tenha contratado DIAGNÒSTICO DE MKT DIGITAL deve-se tentar fazer a venda novamente explicando que isso impacta no funil de vendas do site e registrar a venda como OPORTUNIDADE. </li>

                    <h2 class="subtitulo-roxo" style="text-align: left">Pré-site – DIAGNÓSTICO</h2>
                    Identificar a presença atual do empreendimento.
                    Perfil do público-alvo
                    Canais de marketing
                    Ferramentas e funil de marketing
                    Analisar a concorrência/mercado.
                    Concorrentes e similares
                    Definir objetivos e metas para conquistá-los.
                    Metas estatísticas
                    Plano de ação para redes sociais
                    Plano de ação para site

                </ol>


                Subir modelo de site .json e personalisar 
                1- versão – 30 dias
                2 – versao – 15 dias 
                Concluido. 







            </div>



        </div>
    </body>
</html>
