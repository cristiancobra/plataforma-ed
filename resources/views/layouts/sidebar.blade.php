@section('sidebar')
<div class="sidebar">
			<a href='/'><i class="fas fa-rocket"></i><span>  INÍCIO</span></a>

			<button class="dropdown-btn">
				<i class='fas fa-user-circle'></i>
				MINHA CONTA
				<i class="fa fa-caret-down"></i>
			</button>

			<div class="dropdown-container">
				<a href="{{ route('user.show', $user->id) }} "><i class="fas fa-user-astronaut" style="margin-right: 8px"></i>PERFIL</a>
				<a href="/emails"><i class="fas fa-envelope" style="margin-right: 8px"></i>EMAILS EXTRAS</a>
				<a href="https://financeiro.empresadigital.net.br"><i class="fas fa-piggy-bank" style="margin-right: 8px"></i>DÉBITOS E SERVIÇOS</a>
			</div>

<li><a href="{{ route('user.index') }} " ><i class="fa fa-users"></i><span>  EQUIPE</span></a></li>

			<button class="dropdown-btn">
				<i class='fas fa-angle-double-right'></i>
				ORGANIZAÇÃO
				<i class="fa fa-caret-down"></i>
			</button>

			<div class="dropdown-container">
				<a href="https://vendas.empresadigital.net.br/index.php?module=Home&action=index" target="_blank"><i class="fas fa-calendar-alt" style="margin-right: 8px"></i>AGENDA</a>
				<a href="https://vendas.empresadigital.net.br/index.php?module=Project&action=EditView&return_module=Project&return_action=DetailView" target="_blank"><i class="fas fa-project-diagram" style="margin-right: 8px"></i>PROJETOS</a>
				<a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DTasks%26action%3DEditView%26return_module%3DTasks%26return_action%3DDetailView" target="_blank"><i class="fas fa-calendar-check" style="margin-right: 8px"></i>NOVA TAREFA</a>
				<a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DMeetings%26action%3DEditView%26return_module%3DMeetings%26return_action%3DDetailView" target="_blank"><i class="fas fa-calendar-plus" style="margin-right: 8px"></i>NOVA REUNIÃO</a>
				<a href="https://nuvem.empresadigital.net.br"  target="_blank"><i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS</a>
			</div>


			<button class="dropdown-btn">
				<i class='fas fa-funnel-dollar'></i>
				VENDAS 
				<i class="fa fa-caret-down"></i>
			</button>
			<div class="dropdown-container">
				<a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DContacts%26action%3Dindex%26parentTab%3DMarketing" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>CONTATOS</a>
				<a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DLeads%26action%3DEditView%26return_module%3DLeads%26return_action%3DDetailView" target="_blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>CADASTRAR CLIENTE</a>
				<a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3Dindex%26return_module%3DOpportunities%26return_action%3DDetailView" target="_blank"><i class="fas fa-coins" style="margin-right: 8px"></i>OPORTUNIDADES</a>
				<a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3DEditView%26return_module%3DOpportunities%26return_action%3DDetailView" target="_blank"><i class="fas fa-handshake" style="margin-right: 8px"></i>NOVA VENDA</a>
				<a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DCalls%26action%3DEditView%26return_module%3DCalls%26return_action%3DDetailView" target="_blank"><i class="fas fa-comment-dots" style="margin-right: 8px"></i>REGISTRAR LIGAÇÃO</a>
				<a href="" target="blank"><i class="fas fa-receipt" style="margin-right: 8px"></i>ORÇAMENTO</a>
			</div>


			<button class="dropdown-btn">
				<i class='fas fa-bullhorn'></i>
				MARKETING
				<i class="fa fa-caret-down"></i>
			</button>

			<div class="dropdown-container">
				<a href="https://empresadigital.net.br/comunicacao/" target="_blank"><i class="fas fa-bullhorn" style="margin-right: 8px"></i>FLUXO DE TRABALHO</a>
				<a href="/editarsite" target="blank"><i class="fas fa-window-maximize" style="margin-right: 8px"></i>EDITAR SITE</a>
				<a href="/postarsite" target="blank"><i class="fas fa-file-alt" style="margin-right: 8px"></i>POSTAR NO BLOG</a>
				<a href="https://vendas.empresadigital.net.br/index.php?module=Campaigns&action=index&parentTab=Marketing" target="_blank"><i class="fas fa-thumbs-up" style="margin-right: 8px"></i>CAMPANHAS</a>
				<a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DProspectLists%26action%3DEditView%26return_module%3DProspectLists%26return_action%3DDetailView" target="_blank"><i class="fas fa-crosshairs" style="margin-right: 8px"></i>CRIAR LISTAS</a>
				<a href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Marketing" target="_blank"><i class="fas fa-cloud-upload-alt" style="margin-right: 8px"></i>ARQUIVOS</a>
			</div>
			<li><a href="https://empresadigital.net.br/suporte/" target="_blank"><i class="fas fa-question-circle"></i><span>  SUPORTE</span></a></li>
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
@section('