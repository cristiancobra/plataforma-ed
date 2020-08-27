<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

		<!-- Styles -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<script src="{{ asset('js/menu.js') }}" async defer></script>
    </head>
    <body>

		<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
			<div class="container">

				<a class="navbar-brand" href="{{ url('/') }}">
					<img src="/imagens/logo-transparente2.png" width="150px" height="50px">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav mr-auto">

					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Authentication Links -->
						@guest
						<li class="nav-item">
							<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
						</li>
						@if (Route::has('register'))
						<li class="nav-item">
							<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
						</li>
						@endif
						@else
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>

							<!--Menu do usuário logado--> 
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('user.show', $userAuth->id) }} ">
									<i class="fas fa-user-astronaut" style="margin-right: 4px"></i>Perfil</a>
								<a class="dropdown-item" href="https://financeiro.empresadigital.net.br" target="_blank">
									<i class="fas fa-piggy-bank" style="margin-right: 4px"></i>Débitos e serviços</a>
								<a class="dropdown-item" href="{{ route('logout') }}"
								   onclick="event.preventDefault();
	document.getElementById('logout-form').submit();">
									<i class="fas fa-sign-out-alt" style="margin-right: 4px"></i>
									{{ __('Logout') }}
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</div>
						</li>
						@endguest
					</ul>
				</div>
			</div>
		</nav>

		<div class="grid-container">
			<div class="sidebar">

				<a href='/'>
					<button class="sidebar-item">
						<i class="fas fa-rocket"></i>
						INÍCIO
					</button>
				</a>

				<button class="dropdown-btn">
					<i class='fa fa-comments'></i>
					COMUNICAÇÃO
					<i class="fa fa-caret-down"></i>
				</button>

				<div class="dropdown-container">
					<a class="sidebar-subitem" href="/emails"><i class="fas fa-envelope" style="margin-right: 8px"></i>EMAILS</a>
					<a class="sidebar-subitem" href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank"><i class="fa fa-comments" style="margin-right: 8px"></i>MENSAGENS</a>
					<a class="sidebar-subitem" href="https://nuvem.empresadigital.net.br/" target="_blank"><i class="fas cloud" style="margin-right: 8px"></i>NUVEM (ARQUIVOS)</a>
				</div>

				<a href="{{ route('user.index') }}">
					<button class="sidebar-item">
						<i class="fa fa-users"></i> 
						EQUIPE
					</button></a>

				<button class="dropdown-btn">
					<i class='fas fa-angle-double-right'></i>
					ORGANIZAÇÃO
					<i class="fa fa-caret-down"></i>
				</button>

				<div class="dropdown-container">
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?module=Home&action=index" target="_blank"><i class="fas fa-calendar-alt" style="margin-right: 8px"></i>AGENDA</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?module=Project&action=EditView&return_module=Project&return_action=DetailView" target="_blank"><i class="fas fa-project-diagram" style="margin-right: 8px"></i>PROJETOS</a>
					<a class="sidebar-subitem"href="{{route('task.index')}}"><i class="fas fa-calendar-check" style="margin-right: 8px"></i>TAREFAS</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DMeetings%26action%3DEditView%26return_module%3DMeetings%26return_action%3DDetailView" target="_blank"><i class="fas fa-calendar-plus" style="margin-right: 8px"></i>NOVA REUNIÃO</a>
				</div>


				<button class="dropdown-btn">
					<i class='fas fa-bullhorn'></i>
					MARKETING
					<i class="fa fa-caret-down"></i>
				</button>

				<div class="dropdown-container">
					<a class="sidebar-subitem" href="/redes-sociais"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>FLUXO DE TRABALHO</a>
					<a class="sidebar-subitem"href="/editarsite" target="_blank"><i class="fas fa-window-maximize" style="margin-right: 8px"></i>EDITAR SITE</a>
					<a class="sidebar-subitem"href="/postarsite" target="_blank"><i class="fas fa-file-alt" style="margin-right: 8px"></i>POSTAR NO BLOG</a>
					<a class="sidebar-subitem" href="{{ route('facebook.index') }}"><i class="fas fa-user-plus" style="margin-right: 8px"></i>FACEBOOK</a>
					<a class="sidebar-subitem" href="{{ route('instagram.index') }}"><i class="fas fa-user-plus" style="margin-right: 8px"></i>INSTAGRAM</a>
					<a class="sidebar-subitem" href="{{ route('linkedin.index') }}"><i class="fas fa-user-plus" style="margin-right: 8px"></i>LINKEDIN</a>
					<a class="sidebar-subitem" href="{{ route('twitter.index') }}"><i class="fas fa-user-plus" style="margin-right: 8px"></i>TWITTER</a>
					<a class="sidebar-subitem" href="{{ route('report.index') }}"><i class="fas fa-user-plus" style="margin-right: 8px"></i>RELATÓRIOS</a>
					<a class="sidebar-subitem"href="https://business.facebook.com/creatorstudio" target="_blank"><i class="fas fa-file-alt" style="margin-right: 8px"></i>PUBLICAR NO FACEBOOK</a>
					<a class="sidebar-subitem"href="https://stories.freepik.com" target="_blank"><i class="fas fa-file-alt" style="margin-right: 8px"></i>DESENHAR STORIE</a>
					<a class="sidebar-subitem"href="https://studio.youtube.com" target="_blank"><i class="fas fa-file-alt" style="margin-right: 8px"></i>ENVIAR VÍDEO YOUTUBE</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?module=Campaigns&action=index&parentTab=Marketing" target="_blank"><i class="fas fa-thumbs-up" style="margin-right: 8px"></i>CAMPANHAS</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DProspectLists%26action%3DEditView%26return_module%3DProspectLists%26return_action%3DDetailView" target="_blank"><i class="fas fa-crosshairs" style="margin-right: 8px"></i>CRIAR LISTAS</a>
					<a class="sidebar-subitem"href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Marketing" target="_blank"><i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS</a>
				</div>

				<button class="dropdown-btn">
					<i class='fas fa-funnel-dollar'></i>
					VENDAS 
					<i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-container">
					<a class="sidebar-subitem" href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DContacts%26action%3Dindex%26parentTab%3DMarketing" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>CONTATOS</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DLeads%26action%3DEditView%26return_module%3DLeads%26return_action%3DDetailView" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>CADASTRAR CLIENTE</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3Dindex%26return_module%3DOpportunities%26return_action%3DDetailView" target="_blank"><i class="fas fa-coins" style="margin-right: 8px"></i>OPORTUNIDADES</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3DEditView%26return_module%3DOpportunities%26return_action%3DDetailView" target="_blank"><i class="fas fa-handshake" style="margin-right: 8px"></i>NOVA VENDA</a>
					<a class="sidebar-subitem"href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DCalls%26action%3DEditView%26return_module%3DCalls%26return_action%3DDetailView" target="_blank"><i class="fas fa-comment-dots" style="margin-right: 8px"></i>REGISTRAR LIGAÇÃO</a>
					<a class="sidebar-subitem"href="https://financeiro.empresadigital.net.br/sales/invoices/create" target="blank"><i class="fas fa-receipt" style="margin-right: 8px"></i>ORÇAMENTO</a>
					<a class="sidebar-subitem"href="https://painel.autentique.com.br/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>CONTRATOS DIGITAIS</a>
					<a class="sidebar-subitem"href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Vendas" target="_blank"><i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS</a>
				</div>

				@if ($userAuth->perfil == "administrador")
				<button class="dropdown-btn">
					<i class='fas fa-funnel-dollar'></i>
					FINANCEIRO 
					<i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-container">
					<a class="sidebar-subitem" href="/financeiro"><i class="fas fa-user-plus" style="margin-right: 8px"></i>PAINEL</a>
					<a class="sidebar-subitem" href="/transactions"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>ENTRADAS</a>
					<a class="sidebar-subitem" href="https://financeiro.empresadigital.net.br/sales/invoices/create" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>NOVA VENDA</a>
					<a class="sidebar-subitem" href="https://financeiro.empresadigital.net.br/purchases/bills/create" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>NOVA DESPESA</a>
					<a class="sidebar-subitem" href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Empresa%20Digital/administrativo/financeiro" target="_blank"><i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS</a>
				</div>

				<button class="dropdown-btn">
					<i class='fas fa-funnel-dollar'></i>
					TESTES 
					<i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-container">
										<a class="sidebar-subitem"href="{{route('task.index')}}"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>TAREFAS</a>
					<a class="sidebar-subitem"href="https://empresadigital.net.br/comunicacao/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>FLUXO DE TRABALHO</a>
					<a class="sidebar-subitem" href="/relatorios"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>NOVO BRIFIENG</a>
					<a class="sidebar-subitem" href="/transactions"  target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>ENTRADAS</a>
					<a class="sidebar-subitem" href="http://127.0.0.1:8000/usuarios/novo" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>CRIAR USUÁRIO</a>
					<a class="sidebar-subitem" href="/usuarios"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>USUÁRIOS</a>
					<a class="sidebar-subitem" href="/accounts"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>EMPRESAS</a>
					<a class="sidebar-subitem" href="https://acadia.mxroute.com:2083/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>CRIAR EMAIL</a>			
					login: solucoes
					<a class="sidebar-subitem" href="https://62.171.185.126:8090/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>SERVIDOR APLICAÇÕES</a>
					login: admin
					<a class="sidebar-subitem" href="https://167.86.97.159:2087" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>SERVIDOR NUVEM</a>
					<a class="sidebar-subitem" href="/funil-vendas" target="blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>FUNIL DE VENDAS</a>
					<a class="sidebar-subitem" href="/emails-pendentes"  target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>ENTRADAS</a>
				</div>

				@endif

				<a href="https://empresadigital.net.br/suporte/" target="_blank">
					<button class="sidebar-item">
						<i class="fas fa-question-circle"></i> SUPORTE
					</button></a>

			</div>
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


			<div class="header">
				<h1 style="padding: 0px;margin-bottom: -4px">
					@yield('title')
				</h1>
				<p>
					@yield('description')
				</p>
			</div>

			<div class="image-header">
				<img src= @yield('image-top') width="70px" height="70px">
			</div>

			<div class="main">
				@yield('main')
			</div>
		</div>
	</body>
</html>
