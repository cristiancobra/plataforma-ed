<nav class="col-md-2 d-md-block bg-secondary sidebar">
    <div class="sidebar-sticky">
        <div class="dropdown">
            <a class="dropdown-btn nav-link link-light" href='/'>
                <i class="fas fa-rocket"></i>
                <span class="d-none d-xl-inline">INÍCIO</span>
            </a>
        </div>

        {{createSidebarItem('COMUNICAÇÃO', 'fa fa-comments', 'dropdownMenuComunicacao', [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'EMAILS',
                                                                                                                                                        'faIcon' => 'fas fa-envelope',
                                                                                                                                                        'link' => '/emails'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'MENSAGENS',
                                                                                                                                                        'faIcon' => 'fas fa-comments',
                                                                                                                                                        'link' => 'https://nuvem.empresadigital.net.br/index.php/apps/spreed/'
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        @if (Auth::user()->perfil == "super administrador" OR Auth::user()->perfil == "administrador")

        {{createSidebarItem('ADMINISTRATIVO', 'fa fa-user-tie', 'dropdownMenuAdministrativo', [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CONTAS',
                                                                                                                                                        'faIcon' => 'fas fa-store',
                                                                                                                                                        'link' => route('account.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'FUNCIONÁRIOS',
                                                                                                                                                        'faIcon' => 'fa fa-id-card-alt',
                                                                                                                                                        'link' => route('user.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'RELATÓRIO DE PRODUTIVIDADE',
                                                                                                                                                        'faIcon' => 'fas fa-chart-pie ',
                                                                                                                                                        'link' => route('journey.reports')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'PLANEJAMENTO',
                                                                                                                                                        'faIcon' => 'fa fa-calendar-check',
                                                                                                                                                        'link' => route('planning.index')
                                                                                                                                                        ],
                                                                                                                                                    ])}}


        {{createSidebarItem('FINANCEIRO', 'fas fa-money-bill', 'dropdownMenuButtonFinanceiro', [
                                                                                                                                                        [
                                                                                                                                                            'name' => 'FATURAS',
                                                                                                                                                            'faIcon' => 'fas fa-receipt',
                                                                                                                                                            'link' => route('invoice.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                            'name' => 'FLUXO DE CAIXA',
                                                                                                                                                            'faIcon' => 'fas fa-sync-alt',
                                                                                                                                                            'link' => route('transaction.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                            'name' => 'FORNECEDORES',
                                                                                                                                                            'faIcon' => 'fas fa-boxes',
                                                                                                                                                            'link' => route('company.index', ['typeCompanies' => 'fornecedor']),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                            'name' => 'ITENS DE DESPESA',
                                                                                                                                                            'faIcon' => 'fas fa-boxes',
                                                                                                                                                            'link' => route('product.index', ['variation' => 'despesa']),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                            'name' => 'CONTAS BANCÁRIAS',
                                                                                                                                                            'faIcon' => 'fas fa-piggy-bank',
                                                                                                                                                            'link' => '/contas-bancarias'
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        @endif

        {{createSidebarItem('MARKETING', 'fa fa-bullhorn', 'dropdownMenuFinanceiro', [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'REDES SOCIAIS',
                                                                                                                                                        'faIcon' => 'fas fa-bullhorn',
                                                                                                                                                        'link' => '/redes-sociais'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'SITES',
                                                                                                                                                        'faIcon' => 'fas fa-window-maximize',
                                                                                                                                                        'link' => '/sites'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'DOMÍNIOS',
                                                                                                                                                        'faIcon' => 'fas fa-window-maximize',
                                                                                                                                                        'link' => '/domains'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'RELATÓRIOS',
                                                                                                                                                        'faIcon' => 'fas fa-chart-pie',
                                                                                                                                                        'link' => route('report.index'),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CONCORRENTES',
                                                                                                                                                        'faIcon' => 'fas fa-trophy',
                                                                                                                                                        'link' => '/competitors'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'ARQUIVOS',
                                                                                                                                                        'faIcon' => 'fas fa-cloud-upload-alt',
                                                                                                                                                        'link' => 'https://nuvem.empresadigital.net.br/index.php/apps/spreed/'
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        {{createSidebarItem('VENDAS', 'fa fa-funnel-dollar', 'dropdownMenuVendas', [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CONTATOS',
                                                                                                                                                        'faIcon' => 'fas fa-user-plus',
                                                                                                                                                        'link' => route('contact.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'EMPRESAS',
                                                                                                                                                        'faIcon' => 'fas fa-store',
                                                                                                                                                        'link' => route('company.index', ['typeCompanies' => 'cliente']),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'PRODUTOS',
                                                                                                                                                        'faIcon' => 'fas fa-shopping-basket',
                                                                                                                                                        'link' => route('product.index', ['variation' => 'receita']),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'OPORTUNIDADES',
                                                                                                                                                        'faIcon' => 'fas fa-donate',
                                                                                                                                                        'link' => '/oportunidades'
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        {{createSidebarItem('JURÍDICO', 'fa fa-shield-alt', 'dropdownMenuJuridico', [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CONTRATOS',
                                                                                                                                                        'faIcon' => 'fas fa-handshake',
                                                                                                                                                        'link' => route('contract.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'MODELOS DE CONTRATO',
                                                                                                                                                        'faIcon' => 'fas fa-file-signature',
                                                                                                                                                        'link' => route('contractTemplate.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'AUTENTICAÇÃO DIGITAL',
                                                                                                                                                        'faIcon' => 'fas fa-certificate',
                                                                                                                                                        'link' => 'https://painel.autentique.com.br/',
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        {{createSidebarItem('PRODUÇÃO', 'fa fa-check-circle', 'dropdownMenuProducao', [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'TAREFAS',
                                                                                                                                                        'faIcon' => 'fas fa-calendar-check',
                                                                                                                                                        'link' => route('task.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'JORNADAS',
                                                                                                                                                        'faIcon' => 'fas fa-mug-hot',
                                                                                                                                                        'link' => route('journey.index')
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        @if (Auth::user()->perfil == "super administrador")

        {{createSidebarItem('EMPRESA DIGITAL', 'fa fa-rocket', 'dropdownMenuEmpresaDigital', [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CRIAR EMAIL <br> login: solucoes',
                                                                                                                                                        'faIcon' => 'fas fa-envelope',
                                                                                                                                                        'link' => 'https://acadia.mxroute.com:2083/'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'SERVIDOR APLICAÇÕES <br> login: admin',
                                                                                                                                                        'faIcon' => 'fas fa-bullhorn',
                                                                                                                                                        'link' => 'https://62.171.185.126:8090/'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'SERVIDOR NUVEM <br> login: admin',
                                                                                                                                                        'faIcon' => 'fas fa-bullhorn',
                                                                                                                                                        'link' => 'https://167.86.97.159:2087/'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'PAGAR SERVIDOR <br> login: admin',
                                                                                                                                                        'faIcon' => 'fas fa-bullhorn',
                                                                                                                                                        'link' => 'https://my.contabo.com/account/login'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'NOTA FISCAL<br> lnsc. Municipal : 58029',
                                                                                                                                                        'faIcon' => 'fas fa-bullhorn',
                                                                                                                                                        'link' => 'http://saocarlos.ginfes.com.br/'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'PALETAS DE CORES',
                                                                                                                                                        'faIcon' => 'fas fa-palette',
                                                                                                                                                        'link' => route('configurations'),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'ADICIONAR BANCO',
                                                                                                                                                        'faIcon' => 'fas fa-university',
                                                                                                                                                        'link' => route('bank.index'),
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        @endif

        <div class="dropdown">
            <a class="dropdown-btn nav-link link-light" href='https://empresadigital.net.br/empreender/'>
                <i class="fas fa-question-circle"></i>
                <span class="d-none d-xl-inline">SUPORTE</span>
            </a>
        </div>

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