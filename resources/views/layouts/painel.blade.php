<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <script src="{{ asset('js/menu.js') }}" async defer></script>

    </head>
    <body>

		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

			<a href='/'><i class="fas fa-rocket"></i><span>  INÍCIO</span></a>

			<button class="dropdown-btn">
				<i class='fas fa-user-circle'></i>
				MINHA CONTA
				<i class="fa fa-caret-down"></i>
			</button>

			<div class="dropdown-container">
				<a href="{{ route('user.show', $user->id) }} "><i class="fas fa-user-astronaut" style="margin-right: 8px"></i>PERFIL</a>
				<a href="/financeiro"><i class="fas fa-piggy-bank" style="margin-right: 8px"></i>DÉBITOS E SERVIÇOS</a>
			</div>


			<button class="dropdown-btn">
				<i class='fab fa-telegram-plane'></i>
				COMUNICAÇÃO
				<i class="fa fa-caret-down"></i>
			</button>

			<div class="dropdown-container">
				<a href="/falar" target="blank"><i class="fas fa-comment-dots" style="margin-right: 8px"></i>EQUIPE</a>
				<a href="/email"><i class="fas fa-envelope" style="margin-right: 8px"></i>EMAIL</a>
				<a href="https://acadia.mxroute.com:2096/" target="blank"><i class="fas fa-cogs" style="margin-right: 8px"></i>CONFIGURAR EMAIL</a>
			</div>



			<button class="dropdown-btn">
				<i class='fas fa-angle-double-right'></i>
				ORGANIZAÇÃO
				<i class="fa fa-caret-down"></i>
			</button>

			<div class="dropdown-container">
				<a href="/crm"><i class="fas fa-calendar-alt" style="margin-right: 8px"></i>AGENDA</a>
				<a href="/novoprojeto"><i class="fas fa-project-diagram" style="margin-right: 8px"></i>PROJETOS</a>
				<a href="/novatarefa" ><i class="fas fa-calendar-check" style="margin-right: 8px"></i>NOVA TAREFA</a>
				<a href="/novareuniao"><i class="fas fa-calendar-plus" style="margin-right: 8px"></i>NOVA REUNIÃO</a>
				<a href="/nuvem"  target="blank"><i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS ONLINE</a>
				<a href="/favoritos"  target="blank"><i class="fas fa-heart" style="margin-right: 8px"></i>FAVORITOS</a>
			</div>


			<button class="dropdown-btn">
				<i class='fas fa-funnel-dollar'></i>
				VENDAS 
				<i class="fa fa-caret-down"></i>
			</button>
			<div class="dropdown-container">
				<a href="/novopotencial"><i class="fas fa-user-plus" style="margin-right: 8px"></i>CADASTRAR CLIENTE</a>
				<a href="/oportunidades"><i class="fas fa-coins" style="margin-right: 8px"></i>OPORTUNIDADES</a>
				<a href="/novaoportunidade" ><i class="fas fa-handshake" style="margin-right: 8px"></i>NOVA VENDA</a>
				<a href="/orcamento" target="blank"><i class="fas fa-receipt" style="margin-right: 8px"></i>ORÇAMENTO</a>
			</div>


			<button class="dropdown-btn">
				<i class='fas fa-bullhorn'></i>
				MARKETING
				<i class="fa fa-caret-down"></i>
			</button>

			<div class="dropdown-container">
				<a href="/marketing"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>FLUXO DE TRABALHO</a>
				<a href="/editarsite" target="blank"><i class="fas fa-window-maximize" style="margin-right: 8px"></i>EDITAR SITE</a>
				<a href="/postarsite" target="blank"><i class="fas fa-file-alt" style="margin-right: 8px"></i>POSTAR NO BLOG</a>
				<a href="/novacampanha"><i class="fas fa-thumbs-up" style="margin-right: 8px"></i>CAMPANHAS</a>
				<a href="/novalista"><i class="fas fa-crosshairs" style="margin-right: 8px"></i>CRIAR LISTAS</a>
			</div>


			<li><a href="/suporte" target="blank"><i class="fas fa-question-circle"></i><span>  SUPORTE</span></a></li>

			<li><a href="/logout" class="logout_btn">   SAIR   </a></li>
		</div>

		<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
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

		<div id="main">     <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->

            <div class="grid" > 

                <div class="header">

                    <div class="botao-ativar">
                        <!-- Use any element to open the sidenav -->
                        <span onclick="openNav()"><i class="fas fa-rocket"></i></span>
                    </div>

                    <p class="titulo-branco" style="padding-top: 7%"> Olá {{ $user->name }} </p>

                </div>

                <div class="imagem">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="250px" height="250px">
                </div>


                <div class="tarefas">
                    <p class="numeros_painel">  {{ $totalTasks }}</p>                        <p class="subtitulo-branco"> tarefas pendentes </p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/crm" style="color: yellow">fazer</a></p>
                </div>

                <div class="potenciais">
                    <p class="numeros_painel">  {{  $totalLeads }} </p>                        <p class="subtitulo-branco"> potenciais aguardando </p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/crm" style="color: yellow">contatar</a></p>
                </div>

                <div class="oportunidades">
                    <p class="numeros_painel"  style="font-size: 40px">  R$ {{  $totalOpportunities }} </p>                        <p class="subtitulo-branco"> em<br>oportunidades</p>
                    <p style="text-align: center; margin: 0px; padding: 0px"><a href="/oportunidades" style="color: yellow">vender</a></p>
                </div>

                <div class="imagem-destaque">
                    <img src=" {{ asset('imagens/plataforma.png') }} " width="100px" height="100px">
				</div>

				<div class="destaque">

					<p style="color:purple; font-weight: 400;line-height: 2;padding-top: 4%"> Clique no ícone do <b>FOGUETE </b>no <b>canto superior esquerdo </b> para acessar seus fluxos e ferramentas a qualquer momento.</p>
                </div>

            </div>
			
			<div>
				@yield('admin') 
			</div>
        </div>
    </body>
</html>
