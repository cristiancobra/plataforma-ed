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
<div>
    <p class="title-reports">
        <i class="fas fa-palette fa-fw"></i> MODELO DE NEGÓCIOS
    </p>
    <br>
</div>
<br>
<p class="title-reports"><i class="fas fa-spinner fa-pulse fa-fw"></i>
    RECOMENDAÇÕES GERAIS
</p>
<br>
<div>
    {!!html_entity_decode($report->general)!!}
</div>
<br>
<br>
<div>
    <p class="title-reports"><i class="fa fa-users fa-fw"></i>PERFIL DO PÚBLICO-ALVO</p>
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
    <p class="title-reports">
        <i class="fas fa-palette fa-fw"></i>IDENTIDADE VISUAL
    </p>
</div>
{{createReportAccountQuestions($report->accountReport)}}
  

<!--   =========================================================  SOCIAL MEDIA - REPORTS ===================================================-->
<div>
    <p class="title-reports">
        <i class="fas fa-palette fa-fw"></i> REDES SOCIAIS
    </p>
    <br>
</div>
@foreach($socialmediaReports as $socialmediaReport )
{{createSocialmediaHeader($socialmediaReport)}}
{{createSocialmediaQuestions($socialmediaReport)}}
@endforeach
<!--===================================     COMPETITOR    ===================================--> 
<div>
    <p class="title-reports">
        <i class="fas fa-palette fa-fw"></i> CONCORRENTES
    </p>
    <br>
</div>
@if(!$report->competitorReports)
Não existem concorrentes configurados.
@else
@foreach($report->competitorReports as $competitorReport)
{{createReportCompetitor('Concorrente', $competitorReport->company->name)}}
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
{{createSocialmediaQuestions($socialmediasCompetitorReport)}}
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