<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href='/'><i class="fas fa-rocket"></i><span>  INÍCIO</span></a>
    <li><a href='/senhas'><i class="fas fa-user-astronaut"></i><span>  PERFIL E SENHAS</span></a></li>
    <li><a href='/falar'  ><i class='fas fa-comment-dots'></i><span>  FALAR</span></a></li>
    <li><a href="/email"><i class="fas fa-envelope"></i><span>  EMAIL</span></a></li>   

    <button class="dropdown-btn">
        <i class='fas fa-funnel-dollar'></i>
        VENDAS 
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="/novopotencial" target="blank"><i class="fas fa-user-plus" style="margin-right: 8px"></i>NOVO PONTENCIAL</a>
        <a href="/novaoportunidade" target="blank"><i class="fas fa-handshake" style="margin-right: 8px"></i>NOVA OPORTUNIDADE</a>
        <a href="/orcamento" target="blank"><i class="fas fa-receipt" style="margin-right: 8px"></i>ORÇAMENTO</a>
    </div>


    <li><a href="/novatarefa" target="blank"><i class="fas fa-calendar-check"></i><span>  NOVA TAREFA</span></a></li> 
</ul>
<ul>      
    <li><a href="/novareuniao" target="blank"><i class="fas fa-calendar-plus"></i><span>  NOVA REUNIÃO</span></a></li> 
</ul>

<li><a href="/nuvem" target="blank"><i class="fas fa-cloud-upload-alt"></i><span>  MEUS ARQUIVOS</span></a>
    <ul>
        <li><a href="/favoritos" target="blank"><i class="fas fa-heart"></i><span>  FAVORITOS</span></a></li>
    </ul>
</li>
<li><a href="" target="blank"><i class="fas fa-bullhorn"></i></i><span>  MARKETING</span></a>
    <ul>      
        <li><a href="/editarsite" target="blank"><i class="fas fa-window-maximize"></i><span>  EDITAR SITE</span></a></li>
    </ul>
    <ul>      
        <li><a href="/postarnoblog" target="blank"><i class="fas fa-file-alt"></i><span>  POSTAR NO BLOG</span></a></li> 
    </ul>
    <ul>      
        <li><a href="/arquivosdemkt" target="blank"><i class="fas fa-photo-video"></i><span>  ARQUIVOS DE MKT</span></a></li> 
    </ul>



<li><a href="/financeiro"><i class="fas fa-piggy-bank"></i></i><span>  FINANCEIRO</span></a></li> 
<ul>      
    <li><a href="/novafatura" target="blank"><i class="fas fa-cash-register"></i><span>  NOVA FATURA</span></a></li> 
</ul>
<ul>
    <li><a href="/nuvem" target="blank"><i class="fas fa-credit-card"></i><span>  REGISTRAR PAGAMENTO</span></a></li>
</ul>
<ul>
    <li><a href="/registardespesas" target="blank"><i class="fas fa-coins"></i><span>  REGISTRAR DESPESAS</span></a></li>
</ul>
<li><a href="/banco" target="blank"><i class="fas fa-university"></i><span>  BANCO</span></a></li>
<li><a href="" target="blank"><i class="fas fa-industry"></i></<span>  PRODUÇÃO</span></a>
    <ul>  
    </ul>    
<li><a href="/novoprojeto" target="blank"><i class="fas fa-project-diagram"></i></i><span>  NOVO PROJETO</span></a></li> 
<li><a href="/tarefadeprojeto" target="blank"><i class="fas fa-clipboard-list"></i><span>  TAREFA DE PROJETO</span></a></li> 
<li><a href="/juridico" target="blank"><i class="fas fa-gavel"></i><span>  JURÍDICO</span></a></li> 
<li><a href="/contratos" target="blank"><i class="fas fa-gavel"></i><span>  CONTRATOS</span></a></li> 
<li><a href="/suporte" target="blank"><i class="fas fa-gift"></i><span>  SUPORTE</span></a></li>
<li><a href="/recompensas" target="blank"><i class="fas fa-question-circle"></i><span>  RECOMPENSAS</span></a></li>
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