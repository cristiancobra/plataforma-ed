
<!--sidebar start-->
<div class="sidenav">
    <div class="foto">
        <img class="center" src="/imagens/icone-empresa-digital.png" class="profile_image" alt="" style="width: 130px;height:130px">
    </div>
    <div>
    <a href= {{ route('list') }} ><i class='fas fa-user-clock'></i><span> INÍCIO</span></a>
    <a href='/crm'><i class='fas fa-arrow-alt-circle-right'></i><span> CRM</span></a>
    <a href='/falar'  target="blank"><i class='fas fa-comment-dots'></i><span> FALAR</span></a>
    <a href="/nuvem" target="blank"><i class="fas fa-cloud-upload-alt"></i><span> MEUS ARQUIVOS</span></a>
    <a href="/email"<i class="fas fa-th"></i><span> EMAIL</span></a>
    <a href="/financeiro"><i class="fas fa-credit-card"></i><span> FINANCEIRO</span></a>
    <a href="/suporte" target="blank"><i class="fas fa-question-circle"></i><span> SUPORTE</span></a>

    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="sidebar_btn"></i>
    </label>
    <a href="/logout" class="logout_btn">   SAIR   </a>
    </div>
</div>

<!--sidebar end-->

