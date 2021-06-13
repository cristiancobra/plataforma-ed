@extends('layouts/master')

@section('title','RELATÓRIO')

@section('image-top')
{{ asset('imagens/report.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('report.index')}}">RELATÓRIOS</a>
<a class="btn btn-primary" href=" {{!! url('/relatorios', $report->id) !!}}">PDF</a>
@endsection

@section('main')
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
        {{createReportCompetitor('Homens entre 13 e 17 anos', $socialmediaReport->male_13_17)}}
        {{createReportCompetitor('Homens entre 18 e 24 anos', $socialmediaReport->male_18_24)}}
        {{createReportCompetitor('Homens entre 25 e 34 anos', $socialmediaReport->male_25_34)}}
        {{createReportCompetitor('Homens entre 35 e 44 anos', $socialmediaReport->male_35_44)}}
        {{createReportCompetitor('Homens entre 45 e 54 anos', $socialmediaReport->male_45_54)}}
        {{createReportCompetitor('Homens entre 55 e 65 anos', $socialmediaReport->male_55_65)}}
        {{createReportCompetitor('Homens +65 anos', $socialmediaReport->male_65)}}
    </div>
    <div class="col-6">
        {{createReportCompetitor('Mulheres entre 13 e 17 anos', $socialmediaReport->female_13_17)}}
        {{createReportCompetitor('Mulheres entre 18 e 24 anos', $socialmediaReport->female_18_24)}}
        {{createReportCompetitor('Mulheres entre 25 e 34 anos', $socialmediaReport->female_25_34)}}
        {{createReportCompetitor('Mulheres entre 35 e 44 anos', $socialmediaReport->female_35_44)}}
        {{createReportCompetitor('Mulheres entre 45 e 54 anos', $socialmediaReport->female_45_54)}}
        {{createReportCompetitor('Mulheres entre 55 e 65 anos', $socialmediaReport->female_55_65)}}
        {{createReportCompetitor('Mulheres +65 anos', $socialmediaReport->female_65)}}
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
        <label class="labels"  for="" >{{$socialmediaReport->city_followers_1}} </label>
    </div>
    <div class="col-6">
        {{$socialmediaReport->number_city_followers_1}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >{{$socialmediaReport->city_followers_2}} </label>
    </div>
    <div class="col-6">
        {{$socialmediaReport->number_city_followers_2}}
    </div>
    <div class="col-6">
        <label class="labels"  for="" >{{$socialmediaReport->city_followers_3}} </label>
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
{{createReportCompetitor('Proposta de valor', $competitorReport->company->description)}}
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
<!--===================================     FOOTER     ===================================--> 

<div style="text-align:right;padding: 2%">
    <form   style="text-decoration: none;color: black;display: inline-block" action="{{ route('report.destroy', ['report' => $report->id]) }}" method="post">
        @csrf
        @method('delete')
        <input class="btn btn-danger" type="submit" value="APAGAR">
    </form>
    <a class="btn btn-secondary" href=" {{ route('report.edit', ['report' => $report->id]) }}">
        <i class='fa fa-edit'>
        </i>
        EDITAR
    </a>
    <a class="btn btn-secondary" href=" {{!! url('/relatorios', $report->id) !!}}">
        PDF
    </a>
    <a class="btn btn-secondary" href="{{route('report.index')}}">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection