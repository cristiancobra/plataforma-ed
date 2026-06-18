<div id="background-sidebar" class="background-sidebar">
    <aside class="sidebar" style="
       background-color: {{ $complementaryColor }};
       ">

        <div class="row pt-3">
            <div class='col sidebar-item text-center position-relative' style="color: {{ $principalColor }}">
                <a class='stretched-link' href='/'>
                </a>
                <i class="fas fa-rocket"></i>
                <p class="mb-0"style='font-size:10px'>
                    PAINEL
                </p>
            </div>
        </div>

        <x-sidebar.item icon="fas fa-cog" title="OPERACIONAL" :principal-color="$principalColor" :submenu="[
            ['icon' => 'fas fa-tasks', 'label' => 'TAREFAS', 'route' => route('task.index')],
            ['icon' => 'fas fa-clock', 'label' => 'JORNADAS', 'route' => route('journey.index')],
            ['icon' => 'fas fa-bullseye', 'label' => 'METAS', 'route' => route('goal.index')],
            ['icon' => 'fas fa-folder', 'label' => 'PROJETOS', 'route' => route('project.index')],
        ]" />

        @if (auth()->user()->perfil == 'super administrador' or
                auth()->user()->perfil == 'administrador' or
                auth()->user()->perfil == 'dono')
            <!--    {{ createSidebarItem(
                'ADMINISTRATIVO',
                'fa fa-user-tie',
                'dropdownMenuAdministrativo',
                $complementaryColor,
                $oppositeColor,
                $principalColor,
                [
                    [
                        'name' => 'MINHA ORGANIZAÇÃO',
                        'faIcon' => 'fas fa-store',
                        'link' => route('account.show', ['account' => auth()->user()->account_id]),
                    ],
                    [
                        'name' => 'MODELO DE NEGÓCIO',
                        'faIcon' => 'fas fa-store',
                        'link' => route('account.dashboard', ['account' => auth()->user()->account_id]),
                    ],
                    [
                        'name' => 'EQUIPE',
                        'faIcon' => 'fa fa-id-card-alt',
                        'link' => route('user.index'),
                    ],
                    [
                        'name' => 'CONCORRENTES',
                        'faIcon' => 'fas fa-trophy',
                        'link' => route('company.index', ['typeCompanies' => 'concorrente']),
                    ],
                    [
                        'name' => 'RELATÓRIO DE PRODUTIVIDADE',
                        'faIcon' => 'fas fa-chart-pie ',
                        'link' => route('journey.reportUsers'),
                    ],
                    [
                        'name' => 'RELATÓRIOS FINANCEIROS',
                        'faIcon' => 'fas fa-chart-pie ',
                        'link' => route('invoice.report'),
                    ],
                    [
                        'name' => 'METAS',
                        'faIcon' => 'fa fa-calendar-check',
                        'link' => route('goal.index'),
                    ],
                    [
                        'name' => 'PLANEJAMENTO FINANCEIRO',
                        'faIcon' => 'fa fa-calendar-check',
                        'link' => route('planning.index'),
                    ],
                ],
            ) }}-->


            <x-sidebar.item icon="fas fa-money-bill" title="ADMINISTRATIVO" :principal-color="$principalColor" :submenu="[
                ['icon' => 'fas fa-building', 'label' => 'PAINEL', 'route' => route('dashboard.administrative')],
                [
                    'icon' => 'fas fa-store',
                    'label' => 'MINHA ORGANIZACAO',
                    'route' => route('account.show', ['account' => auth()->user()->account_id]),
                ],
                [
                    'icon' => 'fas fa-store',
                    'label' => 'MODELO DE NEGOCIO',
                    'route' => route('account.dashboard', ['account' => auth()->user()->account_id]),
                ],
                ['icon' => 'fas fa-id-card-alt', 'label' => 'EQUIPE', 'route' => route('user.index')],
                [
                    'icon' => 'fas fa-trophy',
                    'label' => 'CONCORRENTES',
                    'route' => route('company.index', ['typeCompanies' => 'concorrente']),
                ],
                [
                    'icon' => 'fas fa-chart-pie',
                    'label' => 'RELATORIO DE PRODUTIVIDADE',
                    'route' => route('journey.reportUsers'),
                ],
                [
                    'icon' => 'fas fa-chart-pie',
                    'label' => 'RELATORIOS FINANCEIROS',
                    'route' => route('invoice.report'),
                ],
                ['icon' => 'fas fa-calendar-check', 'label' => 'METAS', 'route' => route('goal.index')],
                [
                    'icon' => 'fas fa-calendar-check',
                    'label' => 'PLANEJAMENTO FINANCEIRO',
                    'route' => route('planning.index'),
                ],
            ]" />

            <x-sidebar.item icon="fas fa-money-bill" title="FINANCEIRO" :principal-color="$principalColor" :submenu="[
                ['icon' => 'fas fa-money-bill', 'label' => 'PAINEL', 'route' => route('dashboard.financial')],
                [
                    'icon' => 'fas fa-boxes',
                    'label' => 'DESPESAS',
                    'route' => route('proposal.index', ['type' => 'despesa']),
                ],
            ]" />
        @endif


        <x-sidebar.item icon="fas fa-bullhorn" title="COMUNICAÇÃO" :principal-color="$principalColor" :submenu="[
            ['icon' => 'fas fa-bullhorn', 'label' => 'PAINEL', 'route' => route('dashboard.marketing')],
            ['icon' => 'fas fa-file', 'label' => 'NOVO DOCUMENTO', 'route' => route('text.create')],
            ['icon' => 'fas fa-list-alt', 'label' => 'DOCUMENTOS', 'route' => route('text.index')],
            [
                'icon' => 'fas fa-paperclip',
                'label' => 'MEUS DOCUMENTOS',
                'route' => route('text.index', ['user_id' => auth()->user()->id]),
            ],
            ['icon' => 'fas fa-image', 'label' => 'NOVA IMAGEM', 'route' => route('image.create')],
            ['icon' => 'fas fa-images', 'label' => 'IMAGENS', 'route' => route('image.index')],
            [
                'icon' => 'fas fa-paperclip',
                'label' => 'MINHAS IMAGENS',
                'route' => route('image.index', ['user_id' => auth()->user()->id]),
            ],
            ['icon' => 'fas fa-hashtag', 'label' => 'NOVA REDE SOCIAL', 'route' => route('socialmedia.create')],
            ['icon' => 'fas fa-share-alt', 'label' => 'REDES SOCIAIS', 'route' => route('socialmedia.index')],
            ['icon' => 'fas fa-plus-circle', 'label' => 'NOVA PAGINA', 'route' => route('page.create')],
            ['icon' => 'fas fa-window-maximize', 'label' => 'PAGINAS', 'route' => route('page.index')],
            ['icon' => 'fas fa-store', 'label' => 'CRIAR LOJA', 'route' => route('shop.create')],
            [
                'icon' => 'fas fa-box-open',
                'label' => 'PRODUTOS',
                'route' => route('product.index', ['variation' => 'receita']),
            ],
            ['icon' => 'fas fa-chart-line', 'label' => 'NOVO RELATORIO', 'route' => route('report.create')],
            ['icon' => 'fas fa-chart-bar', 'label' => 'RELATORIOS', 'route' => route('report.index')],
            ['icon' => 'fas fa-users', 'label' => 'PUBLICO-ALVO', 'route' => route('contact.target')],
        ]" />

        <x-sidebar.item icon="fas fa-funnel-dollar" title="CAPTAÇÃO" :principal-color="$principalColor" :submenu="[
            ['icon' => 'fas fa-file-alt', 'label' => 'PAINEL', 'route' => route('dashboard.sales')],
            ['icon' => 'fas fa-bullseye', 'label' => 'OPORTUNIDADES', 'route' => route('opportunity.index')],
        ]" />

        <x-sidebar.item icon="fas fa-archive" title="ACERVO" :principal-color="$principalColor" :submenu="[
            ['icon' => 'fas fa-exchange-alt', 'label' => 'EMPRÉSTIMOS', 'route' => route('loan.index')],
            ['icon' => 'fas fa-archive', 'label' => 'ITENS DE ACERVOS', 'route' => route('collection.index')],
            [
                'icon' => 'fas fa-layer-group',
                'label' => 'GRUPOS DE ACERVOS',
                'route' => route('collections-group.index'),
            ],
            [
                'icon' => 'fas fa-tags',
                'label' => 'TIPOS DE ACERVO',
                'route' => route('collection-types.index'),
            ],
            ['icon' => 'fas fa-file-alt', 'label' => 'DOCUMENTOS', 'route' => route('text.index')],
        ]" />

        <div class="row pt-2">
            <div class='col sidebar-item text-center position-relative' style="color: {{ $principalColor }}">
                <a class='stretched-link' href='{{ route('dashboard.support') }}' style="color: {{ $principalColor }}">
                </a>
                <i class="fas fa-question-circle"></i>
                <p class="mb-0"style='font-size:10px'>
                    SUPORTE
                </p>
                </a>
            </div>
        </div>

        @if (auth()->user()->perfil == 'super administrador')
            <div class="row pt-2">
                <div class='col sidebar-item text-center position-relative' style="color: {{ $principalColor }}">
                    <a class='stretched-link' href='{{ route('dashboard.plataforma') }}'
                        style="color: {{ $principalColor }}">
                    </a>
                    <i class="fas fa-rocket"></i>
                    <p class="mb-0"style='font-size:10px'>
                        PLATAFORMA
                    </p>
                    </a>
                </div>
            </div>
        @endif

        <!--
        {{ createSidebarItem(
            'JURÍDICO',
            'fa fa-shield-alt',
            'dropdownMenuJuridico',
            $complementaryColor,
            $oppositeColor,
            $principalColor,
            [
                [
                    'name' => 'CONTRATOS',
                    'faIcon' => 'fas fa-handshake',
                    'link' => route('contract.index'),
                ],
                [
                    'name' => 'MODELOS DE CONTRATO',
                    'faIcon' => 'fas fa-file-signature',
                    'link' => route('contractTemplate.index'),
                ],
                [
                    'name' => 'AUTENTICAÇÃO DIGITAL',
                    'faIcon' => 'fas fa-certificate',
                    'link' => 'https://painel.autentique.com.br/',
                ],
            ],
        ) }}-->

        <!--    {{ createSidebarItem(
            'PRODUÇÃO',
            'fa fa-check-circle',
            'dropdownMenuProducao',
            $complementaryColor,
            $oppositeColor,
            $principalColor,
            [
                [
                    'name' => 'PROJETOS',
                    'faIcon' => 'fas fa-calendar-check',
                    'link' => route('project.index'),
                ],
                [
                    'name' => 'TAREFAS',
                    'faIcon' => 'fas fa-calendar-check',
                    'link' => route('task.index'),
                ],
                [
                    'name' => 'JORNADAS',
                    'faIcon' => 'fas fa-mug-hot',
                    'link' => route('journey.index'),
                ],
            ],
        ) }}-->

        <!--    @if (auth()->user()->perfil == 'super administrador')
{{ createSidebarItem(
    'PLATAFORMA',
    'fa fa-rocket',
    'dropdownMenuEmpresaDigital',
    $complementaryColor,
    $oppositeColor,
    $principalColor,
    [
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
        [
            'name' => 'TEXTOS DO SISTEMA',
            'faIcon' => 'fa fa-file-text-o',
            'link' => route('systemText.index'),
        ],
    ],
) }}
        {{ createSidebarItem(
            'ATALHOS ED',
            'fa fa-rocket',
            'dropdownMenuEmpresaDigital',
            $complementaryColor,
            $oppositeColor,
            $principalColor,
            [
                [
                    'name' => 'SERVIDOR APLICAÇÕES <br> login: admin',
                    'faIcon' => 'fas fa-bullhorn',
                    'link' => 'https://62.171.185.126:8090/',
                ],
                [
                    'name' => 'SERVIDOR NUVEM <br> login: admin',
                    'faIcon' => 'fas fa-bullhorn',
                    'link' => 'https://167.86.97.159:2087/',
                ],
                [
                    'name' => 'PAGAR SERVIDOR <br> login: admin',
                    'faIcon' => 'fas fa-bullhorn',
                    'link' => 'https://my.contabo.com/account/login',
                ],
                [
                    'name' => 'NOTA FISCAL<br> lnsc. Municipal : 58029',
                    'faIcon' => 'fas fa-bullhorn',
                    'link' => 'http://saocarlos.ginfes.com.br/',
                ],
                [
                    'name' => 'SITES antigo',
                    'faIcon' => 'fas fa-window-maximize',
                    'link' => '/sites',
                ],
                [
                    'name' => 'DOMÍNIOS antigo',
                    'faIcon' => 'fas fa-window-maximize',
                    'link' => '/domains',
                ],
                [
                    'name' => 'EMAILS antigo',
                    'faIcon' => 'fas fa-envelope',
                    'link' => route('email.index'),
                ],
            ],
        ) }}
    
        {{ createSidebarItem(
            'EMAIL ED',
            'fa fa-envelope',
            'dropdownMenuEmpresaDigital',
            $complementaryColor,
            $oppositeColor,
            $principalColor,
            [
                [
                    'name' => 'EMAIL DO USUÁRIO<br>',
                    'faIcon' => 'fas fa-envelope',
                    'link' => 'https://acadia.mxroute.com:2083/',
                ],
                [
                    'name' => 'GERENCIAR EMAILS<br> login: solucoes',
                    'faIcon' => 'fas fa-envelope',
                    'link' => 'https://acadia.mxroute.com:2096/',
                ],
                [
                    'name' => 'GERENCIAR CONTA<br> login: solucoes',
                    'faIcon' => 'fas fa-envelope',
                    'link' => 'https://portal.mxroute.com/index.php',
                ],
                [
                    'name' => 'SUPORTE<br> login: contato@empresadigital.net.br',
                    'faIcon' => 'fas fa-envelope',
                    'link' => 'https://chat.mxroute.com/channel/support',
                ],
            ],
        ) }}
@endif-->

        <!--    {{ createSidebarItem(
            'SUPORTE',
            'fas fa-question-circle',
            'dropdownMenuButtonSuporte',
            $complementaryColor,
            $oppositeColor,
            $principalColor,
            [
                [
                    'name' => 'TUTORIAIS',
                    'faIcon' => 'fas fa-question-circle',
                    'link' => route('systemText.indexTutorials'),
                ],
                [
                    'name' => 'AJUDA',
                    'faIcon' => 'fas fa-question-circle',
                    'link' => 'https://empresadigital.net.br/empreender/',
                ],
                [
                    'name' => 'REPORTAR BUG',
                    'faIcon' => 'fas fa-bug',
                    'link' => route('task.bug'),
                ],
            ],
        ) }}-->

    </aside>
</div>

<style>
    .background-sidebar {
        background-color: rgba(221, 221, 221);
    }

    .sidebar {
        grid-area: sidebar;
        width: var(--sidebar-width);
        height: calc(99vh - var(--nav-height));
        position: fixed;
        top: var(--nav-height);
        right: 0;
        left: 0;
        z-index: 1029;
        margin: 4px;
        padding: 4px;
        overflow: visible;
        border-right: 1px solid rgba(255, 255, 255, 0.35);
        box-shadow: 10px 0 30px rgba(27, 32, 50, 0.12);
        backdrop-filter: blur(10px);
        border-radius: 6px;
    }
</style>
