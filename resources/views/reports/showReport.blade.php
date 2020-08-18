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
<div style="background-color: #874983;padding-bottom: 1%;padding-top: 1.5%;border-radius: 40px">
	<h1 class="name" style="color: white;text-align: center"> {{ $report->name }}  </h1>
	<p class="fields" style="color: white;text-align: center">  {{ $report->date}} </span></p>
</div>
<br>
<p>
	O objetivo deste relatório é oferecer a você ferramentas e estratégias para aumentar e melhorar sua MATURIDADE DIGITAL.
	Para alcançar a verdadeira TRANFORMAÇAO DIGITAL é necessário tomar colocar seu cliente no centro dos seus processos e tomar decisões sempre baseadas em dados.
</p>
<br>
<div>
	<p class="title-reports"><i class="fas fa-palette fa-fw"></i>PERFIL DO PÚBLICO-ALVO</p>
	<br>
	<p>
		Conhecer o perfil das pessoas que devem ser alcançadas é essencial para direcionar as estratégias de marketing. Assim poderemos direcionar o marketing baseado em números, e não apenas em intuição.
	</p>
	<br>
	<table class="table-list">
		<td   class="table-list-header"><b>Análise da página</b></td>
		<td   class="table-list-header"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui logomarca:</b></td>
			@if ($report->logo === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui paleta de cores:</b></td>
			@if ($report->palette === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
	</table>
</div>
<br>
<div>
	<p class="title-reports"><i class="fas fa-palette fa-fw"></i>IDENTIDADE VISUAL</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Análise da página</b></td>
			<td   class="table-list-header"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left">
					POSSUI  LOGOMARCA:
			</td>
			@if ($report->logo === "good")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td>
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert, é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características á respeito da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
				</p>
			</td>
		</tr>
		@else
		<td  class="btn btn-danger"><b>NÃO</b></td>
		@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui paleta de cores:</b></td>
			@if ($report->palette === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
	</table>
</div>
<br>
<div>
	<p class="title-reports"><i class="fab fa-facebook-square fa-fw"></i>FACEBOOK</p>
	<p class="labels">Nome:<span class="fields">{{ $report->FB_page_name }}</span></p>
	<p class="labels">Endereço:<span class="fields">{{ $report->FB_URL_name }}</span></p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Análise da página</b></td>
			<td   class="table-list-header"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta Business vinculada com Instagram:</b></td>
			@if ($report->FB_linked_instagram === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($report->FB_same_site_name === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Apresentação da página:</b></td>
			@if ($report->FB_about === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($report->FB_feed_content === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Feed organizado:</b></td>
			@if ($report->FB_harmonic_feed === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($report->FB_SEO_descriptions === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($report->FB_feed_images === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publica Stories:</b></td>
			@if ($report->FB_stories === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações com interação:</b></td>
			@if ($report->FB_interaction === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Paga ADs:</b></td>
			@if ($report->FB_pay_ads === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($report->FB_value_ads,2,",",".") }}</b></td>
		</tr>
	</table>
	<br>
</div>
<br>
<div>
	<p class="title-reports"><i class="fab fa-instagram-square fa-fw"></i>INSTAGRAM</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Análise da página</b></td>
			<td   class="table-list-header"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui conta Business:</b></td>
			@if ($report->IG_business === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta vinculada com Facebook:</b></td>
			@if ($report->IG_linked_facebook === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($report->IG_same_site_name === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Descrição da bio:</b></td>
			@if ($report->IG_about === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Linktree na bio:</b></td>
			@if ($report->IG_linktree === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($report->IG_feed_content === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Feed organizado:</b></td>
			@if ($report->IG_harmonic_feed === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($report->IG_SEO_descriptions === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($report->IG_feed_images === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publica Stories:</b></td>
			@if ($report->IG_stories === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações com interação:</b></td>
			@if ($report->IG_interaction === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Paga ADs:</b></td>
			@if ($report->IG_pay_ads === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($report->IG_value_ads,2,",",".") }}</b></td>
		</tr>
	</table>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;color: black;display: inline-block" action="{{ route('report.destroy', ['report' => $report->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('report.edit', ['report' => $report->id]) }} "  style="text-decoration: none;color: black;display: inline-block">
			<i class='fa fa-edit'></i>Editar informações</a>
		<a class="btn btn-primary" href=" {{!! url('/relatorios', $report->id) !!}}">PDF</a>
		<a class="btn btn-primary" href="{{route('report.index')}}">VOLTAR</a>
	</div>
	@endsection