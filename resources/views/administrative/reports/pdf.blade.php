<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
        <!-- Styles -->
        <style>
            * {
                font-family: Nunito, helvetica, sans-serif;
            }
            .break{
                page-break-after: always;
            }
            .p {
                
            }
            .header2 {
                color:white;
                text-align: left;
                font-size: 25px;
                padding-top:0px;
                padding-left:25px;
                border-radius:20px;
                background-color: grey;
                height: 80px;
            }
            .table-list-header {
                color:white;
                font-size: 14px;
                padding:8px;
                border-radius:10px;
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .table-list {
                color:black;
                font-size: 14px;
                font-weight: 600;
                padding-top:20px;
                padding-bottom: 10px;
                margin-top: 10px;
                margin-bottom: 5px;
                margin-left: 10px;
                margin-right: 10px;
                border-style: solid;
                border-bottom-width: 1px;
            }
            .toDo{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #F2E28C;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }
            .done{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #A5D9CC;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }

            .doing{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #92C4D4;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }
            .description {
                color:black;
                font-size: 12px;
                padding:8px;
                padding-left:30px;
                margin-top: 0px;
                margin-bottom: 5px;
                margin-left: 40px;
                margin-right: 10px;
                border-radius:20px;
                border-style: solid;
                border-color: black;
                border-bottom: 1px;
                font-style: italic;
            }
            .right {
                text-align: right;
            }
            .left {
                text-align: left;
            }
            .center {
                text-align: center;
            }
        </style>
    </head>
    <body>
     <br>
<div style="background-color: #874983;padding-bottom: 1%;padding-top: 1.5%;border-radius: 25px">
    <h1 class="name" style="color: white;text-align: center">
        {{$report->name}}
    </h1>
    <p class="fields" style="color: white;text-align: center">
        {{dateBr($report->date)}}       
    </p>
</div>
<br>
<div>
    <p>
        PARABENS! Você está há alguns passos de começar a entender melhor sobre o seu público alvo e avançar mais uma etapa rumo à  transformação digital.  
        <br>Com esse relatório você vai começar a entender o poder de conhecer melhor os seus dados. 
    </p>
    <br>
    OBJETIVO:               
    <br>
    <br>
    <ul>
        <li>   Medir sua autoridade através da análise da presença digital;  </li>
        <li>   Apresentar números indicadores  sobre o seu mercado e comparar com a sua concorrência; </li>
        <li>   Identificar público-alvo e personas; </li>
        <li>   Criar um planejamento para melhorar a sua maturidade digital .   </li>
    </ul>
</p>
</div>
<br>
<div>
    <p class="title-reports" style="text-align: center">
        <i class="fas fa-palette fa-fw"></i> MODELO DE NEGÓCIOS
    </p>
    <br>
</div>
<div>
    Você também vai precisar desenvolver um modelo de negócios sustentável para isso você precisa:

    <ul>
        <li>
            Desenvolver uma proposta de valor
        </li>
        <li>
            Definir o segmento de mercado
        </li>    
        <li>
            Definir o público alvo
        </li>
        <li>
            Definir onde acontecerá o relacionamento com o cliente
        </li>
        <li>
            Definir quais serão seus canais de comunicação e distribuição
        </li>
        <li>
            Definir quais são suas atividade chaves
        </li>
        <li>
            Definir quais são seus recursos chaves
        </li>
        <li>
            Definir quem são seus parceiros chaves
        </li>
        <li>
            Definir sua estrutura de custos
        </li>
        <li>
            Definir suas fontes de renda
        </li>
    </ul>
</div>
<br>
<p class="title-reports" style="text-align: center">
    <i class="fas fa-spinner fa-pulse fa-fw"></i>
    RECOMENDAÇÕES GERAIS
</p>
<br>
<div>
    {!!html_entity_decode($report->general)!!}
</div>
<br>
<br>
<div>
    <p class="title-reports" style="text-align: center">
        <i class="fa fa-users fa-fw"></i>PERFIL DO PÚBLICO-ALVO</p>
    <br>
    <p>
        Conhecer o perfil das pessoas que devem ser alcançadas é essencial para direcionar as estratégias de marketing. 
        Assim poderemos direcionar o marketing baseado em números, e não apenas em intuição.
    </p>
</div>
<div>
    {!!html_entity_decode($report->target)!!}
</div>
<br>
<!--   =========================================================  IDENTIDADE VISUAL  ===================================================-->
<div>
    <p class="title-reports" style="text-align: center">
        <i class="fas fa-palette fa-fw"></i>IDENTIDADE VISUAL
    </p>
</div>
<br>
{{createReportAccountQuestions($report->accountReport)}}


<!--   =========================================================  SOCIAL MEDIA - REPORTS ===================================================-->
<div>
    <p class="title-reports" style="text-align: center;padding:20px;font-size:40px">
        <i class="fas fa-palette fa-fw"></i> REDES SOCIAIS
    </p>
    <br>
</div>
@foreach($socialmediaReports as $socialmediaReport )
{{createSocialmediaHeader($socialmediaReport)}}
<br>
<br>
<br>
<div class="row">
    <div class="co-12">
        <p class="title-reports" style="font-size: 16px;margin-top: 40px">
            FAIXA ETÁRIA
        </p>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <p class="labels" style="text-align: center">
            HOMENS
        </p>
        {{createReportCompetitor('13 e 17 anos', $socialmediaReport->male_13_17)}}
        {{createReportCompetitor('18 e 24 anos', $socialmediaReport->male_18_24)}}
        {{createReportCompetitor('25 e 34 anos', $socialmediaReport->male_25_34)}}
        {{createReportCompetitor('35 e 44 anos', $socialmediaReport->male_35_44)}}
        {{createReportCompetitor('45 e 54 anos', $socialmediaReport->male_45_54)}}
        {{createReportCompetitor('55 e 65 anos', $socialmediaReport->male_55_65)}}
        {{createReportCompetitor('+65 anos', $socialmediaReport->male_65)}}
    </div>
    <div class="col-6">
        <p class="labels" style="text-align: center">
            MULHERES
        </p>
        {{createReportCompetitor('13 e 17 anos', $socialmediaReport->female_13_17)}}
        {{createReportCompetitor('18 e 24 anos', $socialmediaReport->female_18_24)}}
        {{createReportCompetitor('25 e 34 anos', $socialmediaReport->female_25_34)}}
        {{createReportCompetitor('35 e 44 anos', $socialmediaReport->female_35_44)}}
        {{createReportCompetitor('45 e 54 anos', $socialmediaReport->female_45_54)}}
        {{createReportCompetitor('55 e 65 anos', $socialmediaReport->female_55_65)}}
        {{createReportCompetitor('+65 anos', $socialmediaReport->female_65)}}
    </div>
</div>
<div class="row">
    <div class="co-12">
        <p class="title-reports" style="font-size: 16px;margin-top: 40px">
            LOCALIZAÇÃO
        </p>
        <br>
    </div>
</div>
@if(!$socialmediaReport->city_followers_1)
<div class="row">
    <div class="co-12">
        <p>
            Não possui dados.
        </p>
        <br>
    </div>
</div>
@else
<div class="row">
    <div class="col-6">
        <label class="labels"  for="" >{{$socialmediaReport->city_followers_1}}</label>
    </div>
    <div class="col-6">
        {{$socialmediaReport->number_city_followers_1}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >{{$socialmediaReport->city_followers_2}}</label>
    </div>
    <div class="col-6">
        {{$socialmediaReport->number_city_followers_2}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >{{$socialmediaReport->city_followers_3}}</label>
    </div>
    <div class="col-6">
        {{$socialmediaReport->number_city_followers_3}}
    </div>
</div>
<div class="row">
    <div class="co-12">
        <p class="title-reports" style="font-size: 16px;margin-top: 40px">
            PALAVRAS-CHAVES
        </p>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <label class="labels"  for="" >Palava-chave 1: </label>
    </div>
    <div class='col-6'>
        {{$socialmediaReport->keyword_1}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >Palava-chave 2: </label>
    </div>
    <div class='col-6'>
        {{$socialmediaReport->keyword_2}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >Palava-chave 3: </label>
    </div>
    <div class='col-6'>
        {{$socialmediaReport->keyword_3}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >Palava-chave 4: </label>
    </div>
    <div class='col-6'>
        {{$socialmediaReport->keyword_4}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >Palava-chave 5: </label>
    </div>
    <div class='col-6'>
        {{$socialmediaReport->keyword_5}}
    </div>
</div>
@endif
<br>
<div class="row">
    <div class="co-12">
        <p class="title-reports" style="font-size: 16px">
            ANÁLISE DA PÁGINA
        </p>
        <br>
    </div>
</div>
<br>
{{createSocialmediaQuestions($socialmediaReport)}}
<br>
@endforeach
<!--===================================     COMPETITOR    ===================================--> 
<div>
    <p class="title-reports" style="text-align: center">
        <i class="fas fa-palette fa-fw"></i> CONCORRENTES
    </p>
    <br>
</div>
@if(!$report->competitorReports)
Não existem concorrentes configurados.
@else
@foreach($report->competitorReports as $competitorReport)
{{createCompetitorHeader($competitorReport)}}
{{createReportCompetitor('País', $competitorReport->company->country)}}
{{createReportCompetitor('Setor', $competitorReport->company->sector)}}
{{createReportCompetitor('Proposta de valor', $competitorReport->company->value_offer)}}
{{createReportCompetitor('Diferencial Competitivo', $competitorReport->company->competitive_advantage)}}
{{createReportCompetitor('Modelo de negócios', $competitorReport->company->business_model)}}
{{createReportCompetitor('Funcionários', $competitorReport->employees)}}
{{createReportCompetitor('Clientes', $competitorReport->client_number)}}
{{createReportCompetitor('Faturamento', $competitorReport->revenues)}}
<br>
@foreach($socialmediasCompetitorsReports as $socialmediasCompetitorReport)
@if($socialmediasCompetitorReport->socialmedia->company_id == $competitorReport->company_id)
{{createSocialmediaHeader($socialmediasCompetitorReport)}}
{{createSocialmediaCompetitorQuestions($socialmediasCompetitorReport)}}
@endif
@endforeach
<br>
@endforeach
@endif
    </body>
</html>