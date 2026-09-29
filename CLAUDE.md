# CLAUDE.md

Este arquivo fornece orientações ao Claude Code (claude.ai/code) para trabalhar com o código deste repositório.

## Visão geral do projeto

"Plataforma ED" é um SaaS de gestão empresarial multi-tenant construído em Laravel 8 (PHP ^8.0|^8.1),
cobrindo CRM/vendas, financeiro, marketing, redes sociais e gestão operacional de tarefas. As views e
comentários estão em português (pt_BR); os identificadores de código (classes, variáveis) estão em inglês.

## Ambiente de desenvolvimento

O projeto roda via Docker Compose (`docker-compose.yml`):
- `app` — container PHP-FPM (build a partir de `docker/php/Dockerfile`), working dir `/var/www`
- `web` — nginx, exposto na porta `8080` do host
- `mysql` — MariaDB 10.6, banco `plataforma`, exposto na porta `3306` do host
- `node` — container Node 20 para build dos assets (não tem comando próprio e fica reiniciando; use
  `docker-compose run --rm node <cmd>` em vez de `exec`)
- `phpmyadmin` — exposto na porta `8081` do host

Comandos comuns (executar dentro do container `app`, ex.: `docker-compose exec app <cmd>`, a menos que esteja
trabalhando fora do Docker):

```bash
# Dependências PHP
composer install

# Rodar toda a suíte de testes (PHPUnit, Laravel 8)
php artisan test
# ou
vendor/bin/phpunit

# Rodar um único arquivo de teste / método
vendor/bin/phpunit tests/Feature/ExampleTest.php
vendor/bin/phpunit --filter test_method_name

# Limpar todos os caches (também exposto como rota: GET /clear)
php artisan config:cache && php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:clear && php artisan clear-compiled

# Banco de dados
php artisan migrate
```

Os assets de frontend são compilados com Laravel Mix (webpack) + Vue 3, via container `node`:

```bash
docker-compose run --rm node npm install
docker-compose run --rm node npm run development   # ou: npm run dev
docker-compose run --rm node npm run watch
docker-compose run --rm node npm run production    # ou: npm run prod
```

Os arquivos compilados (`public/js`, `public/css`, `public/mix-manifest.json`) são versionados — após alterar
`resources/js` ou `resources/css`, recompile e inclua os arquivos gerados no commit. O build pode alterar
`public/js/app.js` mesmo sem mudança nos fontes dele; nesse caso restaure o arquivo e o respectivo hash no
`mix-manifest.json` para não poluir o diff.

O `webpack.mix.js` compila `resources/js/app.js` (com suporte a Vue SFC), `resources/sass/app.scss`,
empacota `resources/js/general.js` em `public/js/scripts.js`, e concatena várias folhas de estilo específicas
de página (`report.css`, `dashboard.css`, `edit.css`, `index.css`, `show.css`, `style.css`) em
`public/css/style.css`.

## Arquitetura

### Multi-tenancy via `Account`

Quase todos os models de domínio (Task, Contact, Company, Invoice, Transaction, Product, Socialmedia, Page,
etc.) pertencem a uma `Account` através de uma coluna `account_id`. Um `User` pertence a exatamente uma
`Account` (`App\Models\User::account_id`). O isolamento entre tenants é aplicado no nível de
controller/query (não há global scope) — controllers e traits filtram cada query por
`auth()->user()->account_id`, e rotas que recebem um model vinculado (ex.: `task.show`, `invoice.edit`,
`company.show`) são checadas contra o `account_id` do usuário atual dentro do middleware `roles`. Ao
adicionar um novo controller/rota de recurso, siga o mesmo padrão: filtre queries de index/filtro por
`account_id`, e adicione um case em `App\Http\Middleware\Roles::handle()` para qualquer novo nome de rota
`*.show`/`*.edit` que receba um model vinculado à rota — caso contrário ele cai silenciosamente em
`$permission = true`.

### Roles / controle de acesso

`App\Http\Middleware\Roles` (registrado como middleware `roles`) é aplicado em quase todas as rotas
autenticadas. Ele faz duas coisas em cada requisição: (1) mapeia o campo `perfil` do usuário autenticado
(nome do papel em português: `super administrador`, `dono`, `administrador`, `funcionário`, `equipe`,
`cliente`) para uma chave `role` em inglês (`superadmin`, `dono`, `administrator`, `employee`, `staff`,
`customer`) mesclada na request, e (2) aplica a verificação de posse (tenant ownership) por model de rota
via um `switch` em `$request->route()->getName()`. Também existe o middleware `IsAdmin` para rotas
restritas a administradores, e `RedirectDomain`, que fora do ambiente `local` resolve domínios customizados
para uma `Page` com slug `home` (feature de landing pages de marketing multi-domínio).

### Controllers organizados por domínio de negócio

`app/Http/Controllers` está agrupado em subdiretórios por área de negócio, não apenas por recurso REST:
`Administrative/` (metas, planejamentos), `Financial/` (bancos, contas bancárias, faturas, transações),
`Sales/` (empresas, contatos, contratos, modelos de contrato, oportunidades, produtos, propostas, lojas),
`Marketing/` (domínios, páginas, sites, relatórios de redes sociais), `Socialmedia/` (controllers por rede:
Facebook, Instagram, LinkedIn, Pinterest, Spotify, Twitter, YouTube — cada um com seu próprio dashboard),
`Operational/` (jornadas, estágios, tarefas — o motor de workflow/kanban de tarefas), `Market/`
(concorrentes), `Emails/`, `Libraries/` (imagens/textos compartilhados), `Contact/`, e `System/` (textos de
sistema/i18n editáveis via admin). As rotas em `routes/web.php` são definidas diretamente (não via
`Route::resource` na maioria dos casos) e referenciam controllers por string
(`'DashboardController@operational'`), seguindo o estilo clássico do Laravel 8 — o namespace padrão de
controller é `App\Http\Controllers` (ver `RouteServiceProvider`), então controllers em subdiretórios são
referenciados pelo nome de classe qualificado pelo subdiretório.

Os módulos mais recentes não seguem esse agrupamento e ficam na raiz de `app/Http/Controllers`:
`ProjectController` (projetos), `CollectionController`, `CollectionsGroupController` e
`CollectionTypeController` (módulo ACERVO: itens, grupos e tipos de acervo), `LoanController` (empréstimos
de itens do acervo) e `AttachmentController` (anexos reutilizáveis, ver `components/attachments-section`).
Antes de criar um controller novo, verifique onde ficam os controllers relacionados.

### Dashboards por departamento

`DashboardController` expõe uma ação por departamento (`administrative`, `development`, `financial`,
`marketing`, `operational` — a raiz do app `/` — `sales`, `plataforma`, `support`), cada uma atrás do
middleware `roles`, refletindo a estrutura por departamento de todo o app (controllers, views e
sidebar/menu são organizados da mesma forma — ver `resources/views/dashboards`,
`app/View/Components/Sidebar`, `app/View/Components/Navmenu`).

### Views, componentes e edição de texto rico

As views Blade ficam em parte em `resources/views/<domínio>/...` (`financial/`, `sales/`, `marketing/`,
`administrative/`...) e em parte na raiz de `resources/views` (`tasks/`, `proposals/`, `opportunities/`,
`projects/`, `goals/`, `collections/`, `loans/`...) — procure a view pelo nome passado a `view()` no
controller em vez de supor o caminho. A UI compartilhada é dividida entre componentes Blade
(`app/View/Components`, além de partials reutilizáveis em
`resources/views/components/{buttons,filter,form,table,...}`) e alguns SFCs Vue 3 em
`resources/js/components` (`create/AddProductsInProposal.vue`, `show/DivStatus.vue`, `show/DivPriority.vue`)
compilados pelo Mix e montados em páginas Blade específicas. Campos de texto rico (propostas, contratos,
modelos de contrato, descrições de produto/oportunidade) usam o editor Jodit (migrado do CKEditor 4 — ver
histórico recente de commits); ao mexer nessas views, mantenha o editor consistente entre os pares
create/edit.

### Layouts e componentes padrão

As páginas estendem um dos layouts em `resources/views/layouts`: `master` (telas de criação e formulários
avulsos), `index` (listagens), `show` (detalhes), `edit` (edição — o `<form>` é aberto pela seção
`form_start` da view) e `master_blank`. Todos incluem `layouts/header`, que imprime as seções `title`,
`image-top` e `buttons`.

Use os componentes existentes em vez de escrever o HTML à mão:

- Botões: `<x-buttons.create model="product" parameter="variation" :value="$variation" />` (monta a rota
  `<model>.create`), `<x-buttons.list>`, `<x-buttons.save>`, `<x-buttons.cancel>`, `<x-buttons.edit>`,
  `<x-buttons.filter>`, `<x-buttons.trash>`, `<x-buttons.trash-index>` etc. — ver
  `resources/views/components/buttons`. Passe `:principalColor="$principalColor"` (compartilhado com todas
  as views pelo `AppServiceProvider`) para usar a cor da conta.
- Mensagens: `<x-alerts />` já está incluído em todos os layouts e exibe erros de validação e as mensagens de
  sessão `failed`, `error`, `success`, `attachment_success` e `message`. Não repita blocos
  `$errors->any()` / `Session::has(...)` nas views — basta o controller usar `->with('success', ...)` ou
  `->with('failed', ...)`. `failed` é renderizado como HTML (alguns controllers enviam links nela).
- Sidebar: os menus ficam em `resources/views/components/sidebar/sidebar.blade.php`, cada um um
  `<x-sidebar.item icon="..." title="..." :submenu="[['icon' => ..., 'label' => ..., 'route' => ...], ...]">`.
  Os submenus trazem apenas atalhos para listagens (sem links "Novo/Nova") para não ficarem longos.

### Helpers

`app/Helpers/Functions.php` é carregado globalmente via autoload `files` do Composer (não é uma classe
namespaced) e define helpers procedurais globais usados nas views Blade para fragmentos de UI comuns, ex.:
`createButtonAdd()`, `createButtonPlus()`, `createButtonBack()`, `buttonTaskSales()` — essas funções fazem
`echo` do HTML diretamente em vez de retornar strings, então são chamadas como statements
(`<?php createButtonPlus(...) ?>`) ou via `{!! !!}` no Blade. Siga o estilo de assinatura existente
(`$route`, par opcional `$parameter`/`$value` para route-model binding) ao adicionar novas funções, em vez
de introduzir um padrão diferente.

## Convenções e armadilhas

- **`image-top`**: o header imprime a seção como HTML dentro de um `<span>`, então ela deve conter um ícone
  Font Awesome 5 (`<i class="fas fa-box-open"></i>`), nunca uma URL de imagem (`{{ asset('images/...') }}`
  aparece como texto na tela).
- **Moeda**: campos de valor usam a máscara JS `formatCurrencyReal('<id>')` (em `resources/js/general.js`,
  formato `1.234,56`) e o backend converte com o helper `removeCurrency()`. Na validação não use `numeric`
  para esses campos — ele rejeita o formato brasileiro; use uma regra `regex` (ver `StoreProductRequest`).
  Para exibir, use `formatCurrencyReal($valor)` / `formatCurrency($valor)` do `Functions.php`.
- **Uploads de imagem**: salve com `->store('public/customers_images')` e grave o path sem o prefixo
  `public/` (como em `ImageController::store`), para que `asset($image->path)` funcione pelo symlink
  `public/customers_images`. Formulários com upload precisam de `enctype='multipart/form-data'`.
- **Validação de imagem**: a regra `image` do Laravel detecta o tipo pelo conteúdo do arquivo; arquivos com
  extensão `.png` mas conteúdo em outro formato fora da lista aceita (ex.: AVIF) são rejeitados com "O arquivo
  selecionado não é uma imagem".

## Observações

- `phpunit.xml` roda os testes contra um banco SQLite em memória (`DB_CONNECTION=sqlite`,
  `DB_DATABASE=:memory:`), independente do serviço MySQL/MariaDB usado no desenvolvimento local.
- `backups/` contém dumps reais do banco de dados — nunca leia, modifique ou faça commit desses arquivos
  como parte de uma tarefa.
- `.styleci.yml` usa o preset `laravel` (com `unused_use` desabilitado) para o estilo do PHP — siga as
  convenções de formatação existentes em vez de introduzir uma ferramenta de estilo diferente.
