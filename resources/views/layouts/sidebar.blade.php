@php
        $empresaDigital = \App\Models\Account::find(1);
        
         if(auth()->user() == true AND auth()->user()->account->principal_color) {
             $principalColor = auth()->user()->account->principal_color;
         }else{
             $principalColor = $empresaDigital->principal_color;
         }

         if(auth()->user() == true AND auth()->user()->account->complementary_color) {
             $complementaryColor = auth()->user()->account->complementary_color;
         }else{
             $complementaryColor = $empresaDigital->complementary_color;
         }
         
         if(auth()->user() == true AND auth()->user()->account->opposite_color) {
             $oppositeColor = auth()->user()->account->opposite_color;
         }else{
             $oppositeColor = $empresaDigital->opposite_color;
         }
@endphp

<nav class="col-md-2 d-md-block sidebar" style="background-color: {{$complementaryColor}}">
    <div class="sidebar-sticky">
        <div class="dropdown">
            <a class="dropdown-btn nav-link" href='/' style="color: {{$principalColor}}">
                <i class="fas fa-rocket"></i>
                <span class="d-none d-xl-inline">MEU PAINEL</span>
            </a>
        </div>

        @if (auth()->user()->perfil == "super administrador" OR auth()->user()->perfil == "administrador" OR auth()->user()->perfil == "dono")

        {{createSidebarItem('ADMINISTRATIVO', 'fa fa-user-tie', 'dropdownMenuAdministrativo', $complementaryColor, $oppositeColor, $principalColor, [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'MINHA EMPRESA',
                                                                                                                                                        'faIcon' => 'fas fa-store',
                                                                                                                                                        'link' => route('account.show', ['account' => auth()->user()->account_id])
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'MODELO DE NEGÓCIO',
                                                                                                                                                        'faIcon' => 'fas fa-store',
                                                                                                                                                        'link' => route('account.dashboard', ['account' => auth()->user()->account_id])
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'FUNCIONÁRIOS',
                                                                                                                                                        'faIcon' => 'fa fa-id-card-alt',
                                                                                                                                                        'link' => route('user.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CONCORRENTES',
                                                                                                                                                        'faIcon' => 'fas fa-trophy',
                                                                                                                                                        'link' => route('company.index', ['typeCompanies' => 'concorrente']),
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


        {{createSidebarItem('FINANCEIRO', 'fas fa-money-bill', 'dropdownMenuButtonFinanceiro', $complementaryColor, $oppositeColor, $principalColor, [
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

        {{createSidebarItem('MARKETING', 'fa fa-bullhorn', 'dropdownMenuFinanceiro', $complementaryColor, $oppositeColor, $principalColor, [
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
                                                                                                                                                        'name' => 'PÁGINAS',
                                                                                                                                                        'faIcon' => 'fas fa-window-maximize',
                                                                                                                                                        'link' => route('page.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'DOMÍNIOS',
                                                                                                                                                        'faIcon' => 'fas fa-window-maximize',
                                                                                                                                                        'link' => '/domains'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                       'name' => 'EMAILS',
                                                                                                                                                        'faIcon' => 'fas fa-envelope',
                                                                                                                                                        'link' => route('email.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'RELATÓRIOS',
                                                                                                                                                        'faIcon' => 'fas fa-chart-pie',
                                                                                                                                                        'link' => route('report.index'),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'IMAGENS',
                                                                                                                                                        'faIcon' => 'fas fa-cloud-upload-alt',
                                                                                                                                                        'link' => route('image.index')
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        {{createSidebarItem('VENDAS', 'fa fa-funnel-dollar', 'dropdownMenuVendas', $complementaryColor, $oppositeColor, $principalColor, [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CONTATOS',
                                                                                                                                                        'faIcon' => 'fas fa-user-plus',
                                                                                                                                                        'link' => route('contact.index')
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'PÚBLICO-ALVO',
                                                                                                                                                        'faIcon' => 'fas fa-user-plus',
                                                                                                                                                        'link' => route('contact.target')
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
                                                                                                                                                        [
                                                                                                                                                        'name' => 'PROPOSTAS',
                                                                                                                                                        'faIcon' => 'fas fa-donate',
                                                                                                                                                        'link' => route('proposal.index', ['typeProposal' => 'receita']),
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        {{createSidebarItem('JURÍDICO', 'fa fa-shield-alt', 'dropdownMenuJuridico', $complementaryColor, $oppositeColor, $principalColor, [
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

        {{createSidebarItem('PRODUÇÃO', 'fa fa-check-circle', 'dropdownMenuProducao', $complementaryColor, $oppositeColor, $principalColor, [
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

        @if (auth()->user()->perfil == "super administrador")

        {{createSidebarItem('PLATAFORMA', 'fa fa-rocket', 'dropdownMenuEmpresaDigital', $complementaryColor, $oppositeColor, $principalColor, [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'CONTAS',
                                                                                                                                                        'faIcon' => 'fa fa-store',
                                                                                                                                                        'link' => route('account.report'),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'USUÁRIOS',
                                                                                                                                                        'faIcon' => 'fa fa-id-card-alt',
                                                                                                                                                        'link' => route('user.report'),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'BUGS',
                                                                                                                                                        'faIcon' => 'fa fa-bug',
                                                                                                                                                        'link' => route('task.index', ['type' => 'bug']),
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'IMPORTAR CONTATOS',
                                                                                                                                                        'faIcon' => 'fa fa-id-card-alt',
                                                                                                                                                        'link' => route('contact.config'),
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
                                                                                                                                                        [
                                                                                                                                                        'name' => 'QUESTÕES DO RELATÓRIO',
                                                                                                                                                        'faIcon' => 'fas fa-question',
                                                                                                                                                        'link' => route('question.index'),
                                                                                                                                                        ],
                                                                                                                                                    ])}}
        {{createSidebarItem('ATALHOS ED', 'fa fa-rocket', 'dropdownMenuEmpresaDigital', $complementaryColor, $oppositeColor, $principalColor, [
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
                                                                                                                                                    ])}}

        {{createSidebarItem('EMAIL ED', 'fa fa-envelope', 'dropdownMenuEmpresaDigital', $complementaryColor, $oppositeColor, $principalColor, [
                                                                                                                                                        [
                                                                                                                                                        'name' => 'EMAIL DO USUÁRIO<br>',
                                                                                                                                                        'faIcon' => 'fas fa-envelope',
                                                                                                                                                        'link' => 'https://acadia.mxroute.com:2083/'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'GERENCIAR EMAILS<br> login: solucoes',
                                                                                                                                                        'faIcon' => 'fas fa-envelope',
                                                                                                                                                        'link' => 'https://acadia.mxroute.com:2096/'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'GERENCIAR CONTA<br> login: solucoes',
                                                                                                                                                        'faIcon' => 'fas fa-envelope',
                                                                                                                                                        'link' => 'https://portal.mxroute.com/index.php'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                        'name' => 'SUPORTE<br> login: contato@empresadigital.net.br',
                                                                                                                                                        'faIcon' => 'fas fa-envelope',
                                                                                                                                                        'link' => 'https://chat.mxroute.com/channel/support'
                                                                                                                                                        ],
                                                                                                                                                    ])}}

        @endif
        
                {{createSidebarItem('SUPORTE', 'fas fa-question-circle', 'dropdownMenuButtonSuporte', $complementaryColor, $oppositeColor, $principalColor, [
                                                                                                                                                        [
                                                                                                                                                            'name' => 'AJUDA',
                                                                                                                                                            'faIcon' => 'fas fa-question-circle',
                                                                                                                                                            'link' => 'https://empresadigital.net.br/empreender/'
                                                                                                                                                        ],
                                                                                                                                                        [
                                                                                                                                                            'name' => 'REPORTAR BUG',
                                                                                                                                                            'faIcon' => 'fas fa-bug',
                                                                                                                                                            'link' => route('task.bug')
                                                                                                                                                        ],
                                                                                                                                                    ])}}

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