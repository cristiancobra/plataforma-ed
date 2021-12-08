<aside class="sidebar" style="
       background-color: {{$complementaryColor}};
       ">

    <div class="row pt-3">
        <div class='col sidebar-item text-center position-relative' style="color: {{$principalColor}}">
            <a class='stretched-link' href='/'>
            </a>
            <i class="fas fa-rocket"></i>
            <p class="mb-0"style='font-size:10px'>
                PAINEL
            </p>
        </div>
    </div>

    @if (auth()->user()->perfil == "super administrador" OR auth()->user()->perfil == "administrador" OR auth()->user()->perfil == "dono")

    <!--    {{createSidebarItem('ADMINISTRATIVO', 'fa fa-user-tie', 'dropdownMenuAdministrativo', $complementaryColor, $oppositeColor, $principalColor, [
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
                                                                                                                                                            'link' => route('journey.reportUsers')
                                                                                                                                                            ],
                                                                                                                                                            [
                                                                                                                                                            'name' => 'RELATÓRIOS FINANCEIROS',
                                                                                                                                                            'faIcon' => 'fas fa-chart-pie ',
                                                                                                                                                            'link' => route('invoice.report')
                                                                                                                                                            ],
                                                                                                                                                            [
                                                                                                                                                            'name' => 'METAS',
                                                                                                                                                            'faIcon' => 'fa fa-calendar-check',
                                                                                                                                                            'link' => route('goal.index')
                                                                                                                                                            ],
                                                                                                                                                            [
                                                                                                                                                            'name' => 'PLANEJAMENTO FINANCEIRO',
                                                                                                                                                            'faIcon' => 'fa fa-calendar-check',
                                                                                                                                                            'link' => route('planning.index')
                                                                                                                                                            ],
                                                                                                                                                        ])}}-->

    <div class="row pt-2">
        <div class='col sidebar-item text-center position-relative' style="color: {{$principalColor}}">
            <a class='stretched-link' href='{{route('dashboard.administrative')}}' style="color: {{$principalColor}}">
            </a>
            <i class="fas fa-user-tie"></i>
            <p class="mb-0"style='font-size:10px'>
                ADMINISTRATIVO
            </p>
        </div>
    </div>

    <div class="row pt-2">                                                                                                              
        <div class='col sidebar-item text-center position-relative' style="color: {{$principalColor}}">
            <a class='stretched-link' href='{{route('dashboard.financial')}}' style="color: {{$principalColor}}">
            </a>
            <i class="fas fa-money-bill"></i>
            <p class="mb-0"style='font-size:10px'>
                FINANCEIRO
            </p>
        </div>
    </div>

    @endif


    <div class="row pt-2">
        <div class='col sidebar-item text-center position-relative' style="color: {{$principalColor}}">
            <a class='stretched-link' href='{{route('dashboard.marketing')}}' style="color: {{$principalColor}}">
            </a>
            <i class="fas fa-bullhorn"></i>
            <p class="mb-0"style='font-size:10px'>
                MARKETING
            </p>
        </div>
    </div>

    <div class="row pt-2">
        <div class='col sidebar-item text-center position-relative' style="color: {{$principalColor}}">
            <a class='stretched-link' href='{{route('dashboard.sales')}}' style="color: {{$principalColor}}">
            </a>
            <i class="fas fa-funnel-dollar"></i>
            <p class="mb-0"style='font-size:10px'>
                VENDAS
            </p>
            </a>
        </div>
    </div>

    <div class="row pt-2">
        <div class='col sidebar-item text-center position-relative' style="color: {{$principalColor}}">
            <a class='stretched-link' href='{{route('dashboard.support')}}' style="color: {{$principalColor}}">
            </a>
            <i class="fas fa-question-circle"></i>
            <p class="mb-0"style='font-size:10px'>
                SUPORTE
            </p>
            </a>
        </div>
    </div>

    @if (auth()->user()->perfil == "super administrador")
    <div class="row pt-2">
        <div class='col sidebar-item text-center position-relative' style="color: {{$principalColor}}">
            <a class='stretched-link' href='{{route('dashboard.plataforma')}}' style="color: {{$principalColor}}">
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
                                                                                                                                                        ])}}-->

    <!--    {{createSidebarItem('PRODUÇÃO', 'fa fa-check-circle', 'dropdownMenuProducao', $complementaryColor, $oppositeColor, $principalColor, [
                                                                                                                                                            [
                                                                                                                                                            'name' => 'PROJETOS',
                                                                                                                                                            'faIcon' => 'fas fa-calendar-check',
                                                                                                                                                            'link' => route('project.index')
                                                                                                                                                            ],
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
                                                                                                                                                        ])}}-->

    <!--    @if (auth()->user()->perfil == "super administrador")
    
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
                                                                                                                                                            [
                                                                                                                                                            'name' => 'TEXTOS DO SISTEMA',
                                                                                                                                                            'faIcon' => 'fa fa-file-text-o',
                                                                                                                                                            'link' => route('systemText.index'),
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
                                                                                                                                                            [
                                                                                                                                                            'name' => 'SITES antigo',
                                                                                                                                                            'faIcon' => 'fas fa-window-maximize',
                                                                                                                                                            'link' => '/sites'
                                                                                                                                                            ],
                                                                                                                                                            [
                                                                                                                                                            'name' => 'DOMÍNIOS antigo',
                                                                                                                                                            'faIcon' => 'fas fa-window-maximize',
                                                                                                                                                            'link' => '/domains'
                                                                                                                                                            ],
                                                                                                                                                            [
                                                                                                                                                           'name' => 'EMAILS antigo',
                                                                                                                                                            'faIcon' => 'fas fa-envelope',
                                                                                                                                                            'link' => route('email.index')
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
    
        @endif-->

    <!--    {{createSidebarItem('SUPORTE', 'fas fa-question-circle', 'dropdownMenuButtonSuporte', $complementaryColor, $oppositeColor, $principalColor, [
                                                                                                                                                            [
                                                                                                                                                                'name' => 'TUTORIAIS',
                                                                                                                                                                'faIcon' => 'fas fa-question-circle',
                                                                                                                                                                'link' => route('systemText.indexTutorials')
                                                                                                                                                            ],
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
                                                                                                                                                        ])}}-->

</aside>

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