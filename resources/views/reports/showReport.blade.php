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
    <h1 class="name" style="color: white;text-align: center"> {{ $report->name }}  </h1>
    <p class="fields" style="color: white;text-align: center">  {{ $report->date}} </span></p>
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
        Conhecer o perfil das pessoas que devem ser alcançadas é essencial para direcionar as estratégias de marketing. Assim poderemos direcionar o marketing baseado em números, e não apenas em intuição.
    </p>
</div>
<br>
<!--   =========================================================  IDENTIDADE VISUAL  ===================================================-->
<div>
    <p class="title-reports">
        <i class="fas fa-palette fa-fw"></i>IDENTIDADE VISUAL
    </p>
    <br>
    <table class="table-hover">
        <tr>
            <td   class="table-list-header" style="width: 90%">
                Análise da página
            </td>
            <td   class="table-list-header" style="width: 10%">
                situação
            </td>
        </tr>
        <!--   ----------------------------------------------------------------------------------  LOGOMARCA  -----------------------------------------------------------------------------------  -->
        <tr>
            <td   class="table-list-left">
                POSSUI  LOGOMARCA:
            </td>
            @if ($report->accountReport->logo === 1)
            <td   class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
                SIM
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="font-style:italic;text-align: justify">
                    <br>
                    Ótimo. Você entende a necessidade de ter uma marca com identidade visual forte. Agora você precisa investir para fazer essa marca chegar ao seu público-alvo. Evoluir sua marca, criar mascote e desenvolver uma identidade visual cada vez mais coesa é uma necessidade constante.
                    <br>
                    <br>
                    <span style="font-weight: 800">Dica:</span>
                    Agende uma consultoria de marca gratuita para saber como melhorar sua identidade visual:
                    <br>
                    <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5516981076049">
                        AVANÇAR
                    </a>
                    <br>
                    <br>
                </p>
            </td>
        </tr>
		@else
        <td   class="btn btn-danger">
            NÃO
        </td>
        <tr>
            <td colspan="2">
                <p style="font-style:italic;text-align: justify">
                    Se você não possui uma logomarca, entenda que ela é o começo de tudo. Nessa fase indicamos a contratação de um especialista em palavras chaves, para encontrar as melhores palavras para criar uma marca com um bom volume de busca. Depois, indicamos a contratação de um designer para elaboração de logomarca responsiva e um kit de UI Design. 
                    <br>
                    Contrate o serviço de criação de marca 
                    <br>
                    Contrate a criação de identidade visual 
                    <br>
                    <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5516981076049">
                        AVANÇAR
                    </a>
                    <br>
                    <br>
                </p>
            </td>
        </tr>
        @endif
        <!--   ----------------------------------------------------------------------------------  PALETA  -----------------------------------------------------------------------------------  -->
        <tr>
            <td   class="table-list-left">
                POSSUI  PALETA DE CORES:
            </td>
            @if ($report->accountReport->pallet  === 1)
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
                SIM
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="font-style:italic;text-align: justify">
                    <br>
                    Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert: é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
                    <br>
                    Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital 
                    <br>
                    <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5516981076049">
                        AVANÇAR
                    </a>
                    <br>
                    <br>
                </p>
            </td>
        </tr>
		@else
        <td class="btn btn-danger" style="padding: 0.5rem 2rem;text-align: center">
            NÃO
        </td>
        <tr>
            <td colspan="2">
                <p style="font-style:italic;text-align: justify">
                    Quando você não possui um kit de UI, a identidade visual fica bagunçada. O objetivo em se ter um kit de UI é criar um estilo que vai além da logomarca. Para criar uma identidade visual homogênea você deve: criar uma paleta de cores, estilos de fontes, estilos de ícones, estilos de fotos, estilos de ilustração, estilos de botões entre outros itens que identificarão a sua marca.
                    <br>
                    Contrate a criação de identidade visual 
                    <br>
                    <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5516981076049">
                        AVANÇAR
                    </a>
                    <br>
                    <br>
                </p>
            </td>
        </tr>
        @endif
    </table>
</div>
<br>

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
@foreach($report->competitorReports as $competitorReport )
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
		VOLTAR
	</a>
</div>
@endsection