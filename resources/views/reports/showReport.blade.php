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
		<td   class="table-list-header" style="width: 90%">
			<b>Análise da página</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>situação</b>
		</td>
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
	<p class="title-reports">
		<i class="fas fa-palette fa-fw"></i>IDENTIDADE VISUAL
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
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
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert,
					é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras
					características á respeito da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital e levar a sua marca para
					outro patamar. 
					<br>
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
				</p>
			</td>
		</tr>
		@elseif ($report->logo === "bad")
		<td   class="button-warning">
			MELHORAR
		</td>
		<tr>
			<td>
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! As empresas mais valiosas do mundo
					alteram constantemente sua logo para se adaptarem as novas tecnologias, portanto não tenha medo de alterar sua identidade visual. 
					Sua logo do jeito que está não proporciona um bom visual nos dispositivos móveis e necessita modernização 
					<br>
					<br>
					Criação de identidade visual - R$ 350, 00 
				</p>
			</td>
		</tr>
		@else
		<td   class="button-delete">
			NÃO
		</td>
		<tr>
			<td>
				<p style="font-style:italic;text-align: justify">
					Se você não possui uma logomarca entenda que ela é o começo de tudo.
					Nessa fase indicamos a contratação de um especialista em palavras chaves, para encontrar as melhores palavras para criar uma marca
					com um volume de busca de peso. Depois indicamos a contratação de um designer para elaboração de logomarca responsiva e um kit de Ui. 
					<br>
					<br>
					serviço de criação de marca R$ 350, 00 
					<br>
					Criação de identidade visual - R$ 350, 00 
				</p>
			</td>
		</tr>
		@endif
		<tr>
			<td   class="table-list-left">
				POSSUI  PALETA DE CORES:
			</td>
			@if ($report->palette === "good")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente!
					Talvez você ainda não seja um expert, é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz,
					o gênero, entre uma infinidade de outras características á respeito da sua marca. Com técnicas de SEO e UXdesign é possível realizar
					uma transformação digital e levar a sua marca para outro patamar.  
					<br>
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
				</p>
			</td>
		</tr>
		@elseif ($report->palette === "bad")
		<td   class="button-warning">
			MELHORAR
		</td>
		<tr>
			<td>
				<p style="font-style:italic;text-align: justify">
					nÃO TEM TEXTO
					<br>
					<br>
					XXXX
				</p>
			</td>
		</tr>
		@else
		<td   class="button-delete">
			NÃO
		</td>
		<tr>
			<td>
				<p style="font-style:italic;text-align: justify">
					Quando você não possui um kit de UI a identidade visual fica bagunçada. O objetivo em se ter um kit de UI é criar um estillo que vai além da
					logomarca. Para criar uma identidade visual homogênia você deve: criar uma palleta de cores, estilos de fontes,  estilos de ícones,  estilos de
					fotos, estilos de ilustração, estilos de botões 
					<br>
					<br>
					Criação de identidade visual - R$ 350, 00 
				</p>
			</td>
		</tr>
		@endif
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
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left">
				Conta Business vinculada com Instagram:
			</td>
			@if ($report->FB_linked_instagram === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um
					expert, é sempre possível colher mais dados para melhorar  sua performance e tráfego.
					<br>
					<br>
					Leve seu FACEBOOKpara outro nível! Contrate uma consultoria especializada R$ 200,00  
				</p>
			</td>
		</tr>
		@else
		<td   class="button-delete">
			NÃO
		</td>
		<tr>
			<td>
				<p style="font-style:italic;text-align: justify">
					O Facebook se tornou parte essencial da estratégia de marketing digital de muitas empresas. Isso porque ele é a maior rede social da atualidade,
					com mais de 2 bilhões de usuários ativos.
					Tanto é que, segundo a pesquisa do site HootSuite, o Facebook já conta com cerca de 50 milhões de empresas promovendo seus produtos ou
					serviços com anúncios.
					Afinal, expor a sua marca em uma vitrine dessas e sem pagar uma fortuna por isso é o sonho de todo empreendedor.
					O gerenciador de anúncios Facebook Business é uma potente ferramenta para criar, gerenciar e verificar o desempenho de anúncios publicados
					na plataforma.
					Com ele também é possível direcionar seus anúncios a públicos específicos, definir o orçamento a ser destinados a eles, verificar seu desempenho
					e ter um relatório sobre o retorno desse investimento.
					Além disso, nas últimas atualizações do Facebook, a rede social disponibilizou o Power Editor, ferramenta que te permite gerenciar múltiplos 
					anúncios simultaneamente, tornando a tarefa mais prática e eficaz.
					Vale lembrar ainda que como o Facebook integra outras redes sociais, o gerenciador também te ajuda a administrar anúncios do Instagram Ads
					e do Audience Network, uma rede de aplicativos para exibição de propagandas.
					E isso é importante, afinal, com ela é possível fazer a mensagem ter um alcance maior, já que porque 72% das pessoas dizem que os posts nas
					redes sociais são o principal formato de conteúdo consumido.
				</p>
			</td>
		</tr>
		@endif
		<tr>
			<td   class="table-list-left">
				<b>Conta possui mesmo nome do site:</b>
			</td>
			@if ($report->FB_same_site_name === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
			@else
			<td   class="button-delete">
				<b>NÃO</b>
			</td>
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
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
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