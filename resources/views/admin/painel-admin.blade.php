<?php

use App\User;
use App\LoginTesteController;
?>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Empresa Digital</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

    </head>
    <body>


        @include ('menu-plataforma')

        <div class="content">
            <div class="secao">
                <div class="coluna-esquerda">

                    <p class="titulo_branco"> Olá {{ $user->name }} </p>
                    <p class="destaque_amarelo">Painel Administrativo </p>



                </div>
                <div class="coluna-direita">
                    <img src="imagens/astronauta-com-cafe-empresa-digital.png" width="300px" height="300px"></a>
                </div>
            </div>
            <div class="secao">
                <div class="coluna-esquerda">
                    <p style="font-size:20px">GERENCIAR EMAILS</p>
                    <a href="https://acadia.mxroute.com:2083/">
                        <button style="background: #874983; border-radius: 9px; padding: 12px; cursor: pointer; color: #fff; border-width: 2px; border-color: #c28dbf font-size: 14px;">CRIAR CONTAS</button></a><br>
                    login: solucoes
                </div>
                <div class="coluna-direita">
                    2- PROJETOS:  Verifique as Tarefas de projetos em aberto e suas data limites. Tarefas de projeto são PRIORIDADE pois existem pessoas que dependem do fechamento da sua tarefapara dar proseguimento. Distribua suas tarefas de projeto que serão possíveis trabalhar ao longo do dia e marque em sua agenda.
                </div>
                <div class="coluna-esquerda">
                    3- TAREFAS: Verifique quais tarefas devem ser executadas por prioridade; Primeiro as que estão em atraso e depois as emergenciais. Distribua ao longo do dua e marque em sua agenda. 
                </div>
                <div class="coluna-direita">
                    4- NOVA TAREFA: Antes de acrescentar novas tarefas comunique-se com toda a equipe e veja se existe alguma emergencia que necessita da sua expertisse para ser resolvida. E registre a tarefa a ser executada.
                </div>
                <div class="coluna-esquerda">
                    5- FAÇA CONTATO: Responda emails e ligações pendentes e registre.
                    </p>
                </div>
            </div>
    </body>
</html>
