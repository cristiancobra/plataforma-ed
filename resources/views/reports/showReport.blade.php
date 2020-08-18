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
	Para alcançar a verdadeira TRANFORMAÇÃO DIGITAL é necessário colocar seu cliente no centro dos seus processos e tomar decisões sempre baseadas em dados.
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
<!--   =========================================================  IDENTIDADE VISUAL  ===================================================-->
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
		<!--   ----------------------------------------------------------------------------------  LOGOMARCA  -----------------------------------------------------------------------------------  -->
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
		<td   class="btn btn-warning">
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
		<!--   ----------------------------------------------------------------------------------  PALETA  -----------------------------------------------------------------------------------  -->
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
<!--   =========================================================  FACEBOOK ===================================================-->
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
		<!--   ----------------------------------------------------------------------------------  CONTA VINCULADA  -----------------------------------------------------------------------------------  -->
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
		<!--   ----------------------------------------------------------------------------------  MESMO NOME DO SITE  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left">
				<b>Conta possui mesmo nome do site:</b>
			</td>
			@if ($report->FB_same_site_name === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Talvez você ainda não seja um expert, é sempre possível colher mais dados para melhorar  o estilo, a personalidade, o tom de voz, o gênero, 
					entre uma infinidade de outras características á respeito do mome da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma 
					transformação digital e levar a sua marca para outro patamar.  
					<br>
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
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
					Para que sua empresa seja encontrada de maneira fácil e rápida use o mesmo nome em todos os seus canais de comunicacão evitando ao
					máximo alterar o nome usado. Esse processo facilita a indexação no google, expondo de maneira agrupada os resultados da busca. 
					Ex: facebook/empresadigital
					instagram @empresadigital.net.br (se não conseguir usar o nome curto uso o domínio do seu site)
					Pinterest @empresadigital 
					Twiter @empresadigitalsc ( evite usar siglas locais) 
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  APRESENTAÇÃO DA PÁGINA  -----------------------------------------------------------------------------------  -->
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Apresentação da página:</b></td>
			@if ($report->FB_about === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Talvez você ainda não seja um expert, é sempre possível colher mais dados para melhorar  o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características á respeito da sua biografia. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
					<br>
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
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
					sua biografia deve descrever claramente o que a sua empresa faz e quais são seus intereces.   Ela deve resumir todas informações da conta,
					trazendo ao visitante tudo que ele precisa saber sobre a pessoa ou empresa dona daquele perfil do Instagram.
					<br>
					Padronização de redesocial - R$ 200,00
				</p>
			</td>
		</tr>
		@endif
<!--   ----------------------------------------------------------------------------------  PUBLICA NO FEED  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($report->FB_feed_content === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert,
					é sempre possível colher mais dados para melhorar os números, a qualidade do conteúdo com técnicas de SEO e a harmonização do design
					através da experiencia do usuário. 
					<br>
					Leve seu feed pra outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
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
					A produção de conteúdo é necessária e de total relevância para se obter um retorno de investimento por meio das redes sociais. Pelas nossas análises o ideal é que você faça postagens diárias.
					Para iniciar trabalho de tráfego orgânico: Ao menos 2 vezes por semana podendo intercalar com 1 produto e 1 conteúdo de qualidade. 
					<br>
					Tipos de postagens:  Biográfica, Produto, frases e citações, tutorial, dicas, conteúdo longo 
				</p>
			</td>
		</tr>
		@endif
<!--   ----------------------------------------------------------------------------------  FEED ORGANIZADO  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Feed organizado:</b></td>
			@if ($report->FB_harmonic_feed === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
<!--   ----------------------------------------------------------------------------------  PUBLICAÇÕES COM SEO  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($report->FB_SEO_descriptions === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um 
					expert, é sempre possível colher mais dados para melhorar  o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma 
					infinidade de outras características á respeito do seu feed. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma 
					transformação digital e levar a sua marca para outro patamar.  
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
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
				Hashtag é um termo associado a tópicos que podem ser pesquisados em redes sociais, inserindo o símbolo do “jogo da velha” (#) antes da palavra,
				frase ou expressão. A hashtag permite que todas as publicações em redes sociais que usem uma mesma hashtag possam ser mais facilmente 
				encontradas. Ao clicar em uma hashtag, você verá todo o conteúdo publicado com a mesma palavra-chave. Elas são excelentes para ficar por dentro dos temas que estão bombando no momento.
				O sistema de hashtag é uma forma de organizar conteúdo sobre o mesmo assunto na internet. Quando uma pessoa publica algo e adiciona hashtags,
				ela está contextualizando a sua publicação. Ao fazer isso, as pessoas podem clicar nessas categorias de assunto e ver o que outras pessoas estão
				falando a respeito. Dessa forma, as hashtags são utilizadas para agrupar e identificar conteúdos, através de determinados temas. É uma ótima maneira
				para fazer pesquisas e medir os resultados do seu site – e até mesmo dos concorrentes.
				A palavra certa pode ser a diferença entre uma hashtag que passa totalmente despercebida e uma que viraliza.O ideal é que seja uma palavra fácil de 
				ler e memorizar. Dê preferência às palavras-chave curtas para não gerar poluição visual – embora isso não seja uma regra.Não é porque uma hashtag
				está bombando no Twitter que fará sucesso no Facebook. Entenda que o público de cada rede social é diferente. Tenha certeza de que a hashtag
				escolhida está sendo utilizada nessa rede.
				<br>
				Faça uma chamada para ação (CTA) e confira se a sua estratégia de SEO está dando certo atravesdo analytics da sua pagina 
				</p>
			</td>
		</tr>
		@endif
<!--   ----------------------------------------------------------------------------------  IMAGENS DO FEED  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($report->FB_feed_images === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert,
					é sempre possível colher mais dados para melhorar  o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras
					características á respeito do seu feed. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a
					sua marca para outro patamar.  
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00  
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
				Para se ganhar autoridade, é preciso ter qualidade portanto manter a proporção e a definição das suas postagem é primordial. 
				Os tamanhos de imagens para Facebook são: 
					• Tamanho de imagem para capa: 820×312 pixels 
					• Tamanho de imagem para avatar: recomendado upload com 960×960 pixels 
					• Tamanho de imagem para links compartilhados: 1200×627 pixels 
					• Tamanho de imagem para post mobile: 800×800 pixels 
				Para a capa da sua página no Facebook, você deve enviar um arquivo com dimensões de 820 x 315 pixels. Aqui vale o alerta. Quando você colocar uma imagem de capa na sua página, essa mesma imagem carrega tanto na versão desktop (aquela acessada diretamente pelo seu computador) quanto na versão mobile.
				A divergência acontece na versão mobile. O Facebook faz um corte automático nesse arquivo de imagem e do tamanho oficial de 820 x 315 pixels para a capa, na versão mobile, essa imagem fica com de 640 x 360 pixels (sim, altura maior).
				Como resolver: no momento da criação da arte para a sua imagem de capa no Facebook, você pode fazer um arquivo com 820 x 315 pixels, mas precisa ficar atento para que o conteúdo essencial da capa fique dentro das proporções de 640 x 315 pixels, ok? Para ter uma capa personalizada no mobile, você pode fazer uma imagem com 820 x 475 pixels. Mas fique atento para que todo o conteúdo que deve aparecer somente no desktop fique dentro dos 315 de altura, ok? Abaixo disso, só fica visível no mobile. 
					• capa de grupo 1920 x 1080 pixels 
					• capa de evento  1920 x 1080 pixels 
					• avatar com 960 x 960 pixels
					• vídeos com 800 x 800 pixels ou 1080 x 1080 pixels.
				ANÚNCIOS NO FACEBOOK: De um lado, temos o objetivo do anúncio no Facebook. Do outro, o tamanho das imagens recomendadas:
					• Banner no Facebook 850 x 350 pixels; 
					• Cliques no site 1200 x 628 pixels; 
					• Conversões no site 1200 x 628 pixels; 
					• Envolvimento com a publicação na página 1200 x 900 pixels; 
					• Curtidas na página 1200 x 444 pixels; 
					• Instalação de aplicativos 1200 x 628 pixels; 
					• Envolvimento com o aplicativo 1200 x 628 pixels; 
					• Divulgação nas imediações 1200 x 628 pixels; 
					• Participação no evento 1200 x 444 pixels; 
					• Obtenção de oferta 1200 x 628 pixels; 
					• Geração de clientes em potencial 1200 x 628 pixels. 
				Reconhecimento da marca / alcance
					• Carrossel 1080 x 1080 pixels; 
					• Imagem única 868 x 361 pixels; 
					• Apresentação multimídia Alta resolução. Taxa proporção 16:9. Tempo: 50 segundos; 
					• Vídeo Formato MOV, MP4 ou GIF. Resolução 720p. Tamanho máximo de 2,3 GB. Taxa de proporção 16:9. Tempo no Facebook: 60 minutos. Tempo no Instagram: 60 segundos. 
				</p>
			</td>
		</tr>
		@endif
<!--   ----------------------------------------------------------------------------------  PUBLICA STORIES  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publica Stories:</b></td>
			@if ($report->FB_stories === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
<!--   ----------------------------------------------------------------------------------  PUBLICAÇÕES COM INTERAÇÃO  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left">
				<b>Publicações com interação:</b>
			</td>
			@if ($report->FB_interaction === "yes")
			<td   class="button-active">
				<b>SIM</b>
			</td>
			@else
			<td   class="button-delete">
				<b>NÃO</b>
			</td>
			@endif
		</tr>
<!--   ----------------------------------------------------------------------------------  INVESTIMENTO EM ADS -----------------------------------------------------------------------------------  -->		
		<tr>
			<td   class="table-list-left">
				<b>Investimento em ADs:</b>
			</td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($report->FB_value_ads,2,",",".") }}</b></td>
		</tr>
		@if ($report->FB_value_ads != "0")
			<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert,
					é sempre possível colher mais dados para melhorar  sua performance e tráfego.
					<br>
					Leve seu Facebook para outro nível! Contrate uma consultoria especializada R$ 200,00  
				</p>
			</td>
		</tr>
		@else
		<tr>
			<td>
				<p style="font-style:italic;text-align: justify">
				falta texto				
				</p>
			</td>
		</tr>
		@endif
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
		<a class="btn btn-secondary" href=" {{ route('report.edit', ['report' => $report->id]) }}">
			<i class='fa fa-edit'>
			</i>
			Editar informações
		</a>
		<a class="btn btn-secondary" href=" {{!! url('/relatorios', $report->id) !!}}">
			PDF
		</a>
		<a class="btn btn-secondary" href="{{route('report.index')}}">
			VOLTAR
		</a>
	</div>
	@endsection