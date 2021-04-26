<nav class="col-md-2 d-md-block bg-secondary sidebar">
    <div class="sidebar-sticky">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item bg-secondary">
                <a class="nav-link link-light" href='/'>
                    <i class="fas fa-rocket me-auto"></i>
                    <span class="d-none d-lg-inline">INÍCIO</span>

                </a>
            </li>

            <button class="dropdown-btn">
                <i class='fa fa-comments'></i>
                <span class="d-none d-xl-inline">COMUNICAÇÃO</span>
                <i class="fa fa-caret-down d-none d-xl-inline"></i>
            </button>
            <div class="dropdown-container">
                <li class="nav-item bg-primary">
                    <a class="nav-link link-light" href='/emails'>
                        <i class="fas fa-envelope  ms-0 me-0"></i>
                        <span class="d-none d-xl-inline">EMAILS</span>
                    </a>
                </li>
                <li class="nav-item bg-primary">
                    <a class="nav-link link-light" href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank">
                        <i class="fa fa-comments ms-0"></i>
                        <span class="d-none d-xl-inline">MENSAGENS</span>
                    </a>
                </li>
            </div>


            @if (Auth::user()->perfil == "super administrador" OR Auth::user()->perfil == "administrador")
            <button class="dropdown-btn">
                <i class='fas fa-user-tie'></i>
                <span class="d-none d-xl-inline">ADMINISTRATIVO </span>
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <li class="nav-item bg-primary">
                    <a class="sidebar-subitem" href="{{route('account.index')}}">
                        <i class="fas fa-store  ms-0 me-0"></i>
                        <span class="d-none d-xl-inline">CONTAS</span>
                    </a>
                </li>
                <li class="nav-item bg-primary">
                    <a class="sidebar-subitem" href="{{route('user.index')}}">
                        <i class="fa fa-id-card-alt  ms-0 me-0"></i>
                        <span class="d-none d-xl-inline">FUNCIONÁRIOS</span>
                    </a>
                </li>
                <li class="nav-item bg-primary">
                    <a class="sidebar-subitem" href="{{route('journey.reports', ['accountId' => 1])}}">
                        <i class="fas fa-chart-pie  ms-0 me-0"></i>
                        <span class="d-none d-xl-inline">RELATÓRIO DE PRODUTIVIDADE</span>
                    </a>
                </li>
                <li class="nav-item bg-primary">
                    <a class="sidebar-subitem" href="{{route('planning.index')}}">
                                                <i class="fa fa-calendar-check ms-0 me-0"></i>
                        <span class="d-none d-xl-inline">PLANEJAMENTO</span>
                    </a>
                </li>
            </div>

            <button class="dropdown-btn">
                <i class='fas fa-money-bill'></i>
                FINANCEIRO 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="sidebar-subitem" href="{{route('invoice.index')}}">
                    <i class="fas fa-receipt" style="margin-right: 8px"></i>FATURAS
                </a>
                <a class="sidebar-subitem" href="{{route('bankAccount.index')}}">
                    <i class="fas fa-piggy-bank" style="margin-right: 8px"></i>CONTAS BANCÁRIAS
                </a>
                <a class="sidebar-subitem" href="{{route('transaction.index')}}">
                    <i class="fas fa-sync-alt" style="margin-right: 8px"></i>FLUXO DE CAIXA
                </a>
                <a class="sidebar-subitem" href="{{route('company.index', ['typeCompanies' => 'fornecedor'])}}">
                    <i class="fas fa-truck" style="margin-right: 8px"></i>FORNECEDORES
                </a>
                <a class="sidebar-subitem" href="{{route('product.index', ['variation' => 'despesa'])}}">
                    <i class="fas fa-boxes" style="margin-right: 8px"></i>ITENS DE DESPESA
                </a>
            </div>
            @endif

            <button class="dropdown-btn">
                <i class='fas fa-bullhorn'></i>
                MARKETING
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="sidebar-subitem" href="/redes-sociais">
                    <i class="fas fa-bullhorn" style="margin-right: 8px"></i>REDES SOCIAIS
                </a>
                <a class="sidebar-subitem" href="{{route('site.index')}}">
                    <i class="fas fa-window-maximize" style="margin-right: 8px"></i>SITES
                </a>
                <a class="sidebar-subitem" href="{{route('domain.index')}}">
                    <i class="fas fa-window-maximize" style="margin-right: 8px"></i>DOMÍNIOS
                </a>
                <a class="sidebar-subitem" href="{{route('report.index')}}">
                    <i class="fas fa-chart-pie" style="margin-right: 8px"></i>RELATÓRIOS
                </a>
                <a class="sidebar-subitem" href="{{route('competitor.index')}}">
                    <i class="fas fa-trophy" style="margin-right: 8px"></i>CONCORRENTES
                </a>
                <a class="sidebar-subitem" href="https://stories.freepik.com" target="_blank">
                    <i class="fas fa-paint-brush" style="margin-right: 8px"></i>CRIAR ARTES
                </a>
                <a class="sidebar-subitem" href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Marketing" target="_blank">
                    <i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS
                </a>
            </div>

            <button class="dropdown-btn">
                <i class='fas fa-funnel-dollar'></i>
                VENDAS 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="sidebar-subitem" href="{{route('contact.index')}}">
                    <i class="fas fa-user-plus" style="margin-right: 8px"></i>CONTATOS
                </a>
                <a class="sidebar-subitem" href="{{route('company.index', ['typeCompanies' => 'cliente'])}}">
                    <i class="fas fa-store" style="margin-right: 8px"></i>EMPRESAS
                </a>
                <a class="sidebar-subitem" href="{{route('product.index', ['variation' => 'receita'])}}">
                    <i class="fas fa-shopping-basket" style="margin-right: 8px"></i>PRODUTOS
                </a>
                <a class="sidebar-subitem" href="{{route('opportunity.index')}}">
                    <i class="fas fa-donate" style="margin-right: 8px"></i>OPORTUNIDADES
                </a>
            </div>

            <button class="dropdown-btn">
                <i class='fas fa-shield-alt'></i>
                JURÍDICO 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="sidebar-subitem" href="{{route('contract.index')}}">
                    <i class="fas fa-handshake" style="margin-right: 8px"></i>CONTRATOS
                </a>
                <a class="sidebar-subitem" href="{{route('contractTemplate.index')}}">
                    <i class="fas fa-file-signature" style="margin-right: 8px"></i>MODELOS DE CONTRATO
                </a>
                <a class="sidebar-subitem" href="https://painel.autentique.com.br/" target="_blank">
                    <i class="fas fa-certificate" style="margin-right: 8px"></i>AUTENTICAÇÃO DIGITAL
                </a>
            </div>

            <button class="dropdown-btn">
                <i class='fas fa-check-circle'></i>
                PRODUÇÃO 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="sidebar-subitem" href="{{route('task.index')}}">
                    <i class="fa fa-calendar-check" style="margin-right: 8px"></i>
                    TAREFAS
                </a>
                <a class="sidebar-subitem" href="{{route('journey.index')}}">
                    <i class="fas fa-mug-hot" style="margin-right: 8px"></i>
                    JORNADAS
                </a>
            </div>

            @if (Auth::user()->perfil == "super administrador")
            <button class="dropdown-btn">
                <i class='fas fa-rocket'></i>
                EMPRESA DIGITAL 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="sidebar-subitem" href="/transactions"  target="_blank"><i class="fa fa-bullhorn" style="margin-right: 8px">

                    </i>ENTRADAS
                </a>
                <a class="sidebar-subitem" href="https://acadia.mxroute.com:2083/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px">

                    </i>CRIAR EMAIL
                    <br>
                    login: solucoes
                </a>
                <a class="sidebar-subitem" href="https://62.171.185.126:8090/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px">
                    </i>SERVIDOR APLICAÇÕES
                    <br>
                    login: admin
                </a>
                <a class="sidebar-subitem" href="https://167.86.97.159:2087" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px">

                    </i>SERVIDOR NUVEM</a>
                <a class="sidebar-subitem" href="https://my.contabo.com/account/login" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px">

                    </i>PAGAR SERVIDOR
                    <br>
                    login: admin
                </a>
                <a class="sidebar-subitem" href="http://saocarlos.ginfes.com.br/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px">

                    </i>NOTA FISCAL
                    <br>
                    lnsc. Municipal : 58029
                </a>
                <a class="sidebar-subitem" href="https://financeiro.empresadigital.net.br/sales/invoices/create" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>NOVA VENDA</a>
                <a class="sidebar-subitem" href="https://financeiro.empresadigital.net.br/purchases/bills/create" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>NOVA DESPESA</a>
                <a class="sidebar-subitem" href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Empresa%20Digital/administrativo/financeiro" target="_blank"><i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS FINANCEIROS</a>
                <a class="sidebar-subitem" href="/funil-vendas" target="blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>TUTO VENDAS ANTIGO</a>
                <a class="sidebar-subitem" href="/emails-pendentes"  target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>EMAILS PENDENTES</a>
                <a class="sidebar-subitem" href="/transactions">
                    <i class="fas fa-bullhorn" style="margin-right: 8px"></i>
                    ENTRADAS
                </a>
                <a class="sidebar-subitem" href="/financeiro">
                    <i class="fas fa-user-plus" style="margin-right: 8px"></i>
                    PAINEL
                </a>
            </div>

            @endif

            <a href="https://empresadigital.net.br/empreender/" target="_blank">
                <button class="sidebar-item">
                    <i class="fas fa-question-circle"></i> SUPORTE
                </button></a>
        </ul>
    </div>
</nav>

<script>

    /* -----------------  Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>