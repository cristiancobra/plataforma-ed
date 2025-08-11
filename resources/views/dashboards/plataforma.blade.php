@extends('layouts/master')

@section('title','PLATAFORMA')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
@endsection

@section('main')

<!--linha 1-->
<div class='row mt-2 mb-3 ms-1 me-1'>
    <div class='col'>
        <p class="labels">
            INFORMAÇÕES DA PLATAFORMA
        </p>
    </div>
</div>

<div class='row mt-2 mb-3 ms-1 me-1'>

    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('account.report')}}'>
            <p class='panel-text'>
                <i class="fas fa-store" style="font-size:36px; ; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                CONTAS
            </p>
        </a>
    </div>

    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('user.report')}}'>
            <p class='panel-text'>
                <i class="fas fa-id-card-alt" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                USUÁRIOS
            </p>
        </a>
    </div>

    <div class='col  sales-display'>
        <a style='text-decoration:none' href='{{route('task.index', ['type' => 'bug'])}}'>
            <p class='panel-text'>
                <i class="fas fa-bug" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                BUGS
            </p>
        </a>
    </div>

    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('contact.config')}}'>
            <p class='panel-text'>
                <i class="fas fa-id-card-alt" style="font-size:36px; color:white; margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                IMPORTAR CONTATOS
            </p>
        </a>
    </div>

    <div class='col sales-display'>
        <a style='text-decoration:none' href='{{route('configurations')}}'>
            <p class='panel-text'>
                <i class="fas fa-palette" style="font-size:36px; color:white; margin-top: -15px;padding-bottom: 10px "></i>
                <br>
                PALETAS DE CORES
            </p>
        </a>
    </div>
</div>

<!--linha 2-->

<div class='row mt-5 mb-3 ms-1 me-1'>
    <div class='col'>
        <p class="labels">
            INFORMAÇÕES DA PLATAFORMA
        </p>
    </div>
</div>

<div class='row mt-2 mb-3 ms-1 me-1'>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='{{route('bank.index')}}'>
            <p class='panel-text'>
                <i class='fas fa-university' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                ADICIONAR BANCO
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='{{route('question.index')}}'>
            <p class='panel-text'>
                <i class='fas fa-question' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                QUESTÕES DO RELATÓRIO
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='{{route('systemText.index')}}'>
            <p class='panel-text'>
                <i class='fa fa-file-text-o' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                TEXTOS DO SISTEMA
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://62.171.185.126:8090/'>
            <p class='panel-text'>
                <i class='fa fa-file-text-o' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                SERVIDOR SITES E PLATAFORMA
                <br>
                login: admin
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://167.86.97.159:2087/'>
            <p class='panel-text'>
                <i class='fa fa-file-text-o' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                SERVIDOR NUVEM
                <br>
                login: admin
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://my.contabo.com/account/login/'>
            <p class='panel-text'>
                <i class='fa fa-file-text-o' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                PAGAR SERVIDOR
                <br>
                login: admin
            </p>
        </a>
    </div>

</div>

<!--linha 3-->

<div class='row mt-5 mb-3 ms-1 me-1'>
    <div class='col'>
        <p class="labels">
            LINKS EXTERNOS
        </p>
    </div>
</div>

<div class='row mt-2 mb-3 ms-1 me-1'>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://saocarlos.ginfes.com.br/'>
            <p class='panel-text'>
                <i class='fa fa-file-text-o' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                EMITIR NOTA FISCAL
                <br>
                lnsc. Municipal : 58029
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='/sites'>
            <p class='panel-text'>
                <i class='fas fa-window-maximize' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                SITES antigo
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='/domains'>
            <p class='panel-text'>
                <i class='fas fa-window-maximize' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                DOMÍNIOS antigo
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='{{route('email.index')}}'>
            <p class='panel-text'>
                <i class='fas fa-envelope' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                EMAILS antigo
            </p>
        </a>
    </div>

</div>

<!--linha 4-->
<div class='row mt-5 mb-3 ms-1 me-1'>
    <div class='col'>
        <p class="labels">
            EMAIL (MX Route)
        </p>
    </div>
</div>

<div class='row mt-2 mb-3 ms-1 me-1'>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://acadia.mxroute.com:2083/'>
            <p class='panel-text'>
                <i class='fas fa-envelope' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                ACESSAR EMAIL DO USUÁRIO
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://acadia.mxroute.com:2096/'>
            <p class='panel-text'>
                <i class='fas fa-envelope' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                GERENCIAR EMAILS
                <br>
                login: solucoes
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://portal.mxroute.com/index.php'>
            <p class='panel-text'>
                <i class='fas fa-envelope' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                GERENCIAR CONTA
                <br>
                login: solucoes
            </p>
        </a>
    </div>

    <div class='col-2 sales-display'>
        <a style='text-decoration:none' href='https://chat.mxroute.com/channel/support'>
            <p class='panel-text'>
                <i class='fas fa-envelope' style='font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px'></i>
                <br>
                SUPORTE DO EMAIL
                <br>
                login: contato@empresadigital.net.br
            </p>
        </a>
    </div>

</div>

@endsection