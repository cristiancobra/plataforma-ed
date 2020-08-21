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
<p>
	O objetivo deste relatório é oferecer a você ferramentas e estratégias para aumentar e melhorar sua MATURIDADE DIGITAL.
	Para alcançar a verdadeira TRANSFORMAÇÃO DIGITAL é necessário colocar seu cliente no centro dos seus processos e tomar decisões sempre baseadas em dados.
</p>
<br>
<div>
	<p class="title-reports"><i class="fas fa-palette fa-fw"></i>PERFIL DO PÚBLICO-ALVO</p>
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
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<!--   ----------------------------------------------------------------------------------  LOGOMARCA  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left">
				POSSUI  LOGOMARCA:
			</td>
			@if ($report->logo === "good")
			<td   class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
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
		@elseif ($report->logo === "bad")
		<td   class="btn btn-warning">
			MELHORAR
		</td>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! As empresas mais valiosas do mundo alteram constantemente sua logo para se adaptarem as novas tecnologias, portanto não tenha medo de alterar sua identidade visual. Sua logo do jeito que está não proporciona um bom visual nos dispositivos móveis e necessita modernização 
					<br>
					<br>
					<span style="font-weight: 800">Dica:</span>
					Contrate a criação de identidade visual - R$ 350,00:
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
					Contrate o serviço de criação de marca - R$ 350,00
					<br>
					Contrate a criação de identidade visual - R$ 350,00 
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
			@if ($report->palette === "good")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert: é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
					<br>
					<a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5516981076049">
						AVANÇAR
					</a>
					<br>
					<br>
				</p>
			</td>
		</tr>
		@elseif ($report->palette === "bad")
		<td   class="button-warning">
			MELHORAR
		</td>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					nÃO TEM TEXTO
					<br>
					<br>
					XXXX
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
					Contrate a criação de identidade visual - R$ 350, 00 
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
<!--   =========================================================  FACEBOOK ===================================================-->
<div>
	<p class="title-reports"><i class="fab fa-facebook-square fa-fw"></i>FACEBOOK</p>
	<p class="labels">Nome:<span class="fields">{{ $report->FB_page_name }}</span></p>
	<p class="labels">Endereço:<span class="fields">{{ $report->FB_URL_name }}</span></p>
	<br>
	<table class="table-hover">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<!--   ----------------------------------------------------------------------------------  CONTA BUSINESS  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left">
				Possui conta Business:
			</td>
			@if ($report->FB_business === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar sua performance e tráfego.
					<br>
					Leve seu FACEBOOK para outro nível! Contrate uma consultoria especializada por R$ 200,00  
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
					O Facebook se tornou parte essencial da estratégia de marketing digital de muitas empresas. Isso porque ele é a maior rede social da atualidade, com mais de 2 bilhões de usuários ativos. Tanto é que, segundo a pesquisa do site HootSuite, o Facebook já conta com cerca de 50 milhões de empresas promovendo seus produtos ou serviços com anúncios. Afinal, expor a sua marca em uma vitrine dessas sem pagar uma fortuna por isso, é o sonho de todo empreendedor.
					O gerenciador de anúncios Facebook Business é uma potente ferramenta para criar, gerenciar e verificar o desempenho de anúncios publicados na plataforma. Com ele também é possível direcionar seus anúncios a públicos específicos, definir o orçamento a ser destinado a cada um, verificar seu desempenho e ter um relatório sobre o retorno desse investimento.
					Além disso, nas últimas atualizações do Facebook, a rede social disponibilizou o Power Editor, ferramenta que te permite gerenciar múltiplos anúncios simultaneamente, tornando a tarefa mais prática e eficaz.
					Vale lembrar ainda que como o Facebook integra outras redes sociais, o gerenciador também te ajuda a administrar anúncios do Instagram Ads e do Audience Network - uma rede de aplicativos para exibição de propagandas.
					E isso é importante, afinal, com ela é possível fazer a mensagem ter um alcance maior, já que porque 72% das pessoas dizem que os posts nas redes sociais são o principal formato de conteúdo consumido.
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  CONTA VINCULADA  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left">
				Conta Business vinculada com Instagram:
			</td>
			@if ($report->FB_linked_instagram === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! 
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
					Sua conta business no instagram preferencialmente deve estar vinculada a sua conta no facebook. Isso porque o instagram foi comprado pelo facebook e já existem algumas unificações que otimizam as suas postagens e a análise de dados, como a programação de postagens no facebook estudio tanto para sua conta do facebook como para sua conta no instagram para o dia/horário da sua escolha. Indicamos usar o mesmo número de whatsapp na criação de todas as contas, pelo mesmo motivo: o whatsapp foi comprado pelo facebook e algumas integrações com o instagram/facebook já estão previstas. 
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
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar  o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito do nome da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
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
					Para que sua empresa seja encontrada de maneira fácil e rápida, use o mesmo nome em todos os seus canais de comunicação evitando ao máximo alterar o nome usado. Esse processo facilita a indexação no google, expondo de maneira agrupada os resultados da busca. 
					<br>
					Para que sua empresa seja encontrada de maneira fácil e rápida, use o mesmo nome em todos os seus canais de comunicação evitando ao máximo alterar o nome usado. Esse processo facilita a indexação no google, expondo de maneira agrupada os resultados da busca. 
					Ex: facebook/empresadigital
					instagram @empresadigital.net.br (se não conseguir usar o nome curto uso o domínio do seu site)
					Pinterest @empresadigital 
					Twiter @empresadigitalsc (evite usar siglas locais) 

					Contrate a padronização de rede social - R$ 200,00
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
		<!--   ----------------------------------------------------------------------------------  APRESENTAÇÃO DA PÁGINA  -----------------------------------------------------------------------------------  -->
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Apresentação da página:</b></td>
			@if ($report->FB_about === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar  o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito da sua biografia. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar. 

					Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00  
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
			<td>
				<p style="font-style:italic;text-align: justify">
					Sua biografia deve descrever claramente o que a sua empresa faz e quais são seus interesses.   Ela deve resumir todas informações da conta, trazendo ao visitante tudo que ele precisa saber sobre a pessoa ou empresa dona daquele perfil/página.

					Contrate a padronização de rede social - R$ 200,00
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
		<!--   ----------------------------------------------------------------------------------  PUBLICA NO FEED  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($report->FB_feed_content === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar os números, a qualidade do conteúdo com técnicas de SEO e a harmonização do design através da experiência do usuário. 

					Leve seu feed pra outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00 
					
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
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center"><b>SIM</b></td>
			@else
			<td class="btn btn-danger" style="padding: 0.5rem 2rem;text-align: center"><b>NÃO</b></td>
			@endif
		</tr>
		<!--   ----------------------------------------------------------------------------------  PUBLICAÇÕES COM SEO  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($report->FB_SEO_descriptions === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito do seu feed. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.

					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00
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
					Hashtag é um termo associado a tópicos que podem ser pesquisados em redes sociais, inserindo o símbolo do “jogo da velha” (#) antes da palavra, frase ou expressão. A hashtag permite que todas as publicações em redes sociais que usem uma mesma hashtag possam ser mais facilmente encontradas. Ao clicar em uma hashtag, você verá todo o conteúdo publicado com a mesma palavra-chave. Elas são excelentes para ficar por dentro dos temas que estão bombando no momento.
					O sistema de hashtag é uma forma de organizar conteúdo sobre o mesmo assunto na internet. Quando uma pessoa publica algo e adiciona hashtags, ela está contextualizando a sua publicação. Ao fazer isso, as pessoas podem clicar nessas categorias de assunto e ver o que outras pessoas estão falando a respeito. Dessa forma, as hashtags são utilizadas para agrupar e identificar conteúdos, através de determinados temas. É uma ótima maneira para fazer pesquisas e medir os resultados do seu site/página – e até mesmo dos concorrentes.
					A palavra certa pode ser a diferença entre uma hashtag que passa totalmente despercebida e uma que viraliza. O ideal é que seja uma palavra fácil de ler e memorizar. Dê preferência às palavras-chave curtas para não gerar poluição visual – embora isso não seja uma regra. Não é porque uma hashtag está bombando no Twitter que fará sucesso no Facebook. Entenda que o público de cada rede social é diferente. Tenha certeza de que a hashtag escolhida está sendo utilizada nessa rede.
					Faça uma chamada para ação (CTA) e confira se a sua estratégia de SEO está dando certo através do analytics da sua página 
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  IMAGENS DO FEED  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($report->FB_feed_images === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito do seu feed. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.

					Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
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
					Para ganhar autoridade, é preciso ter qualidade portanto manter a proporção e a definição das suas postagem é essencial. 
					Os tamanhos de imagens para Facebook são: 
					• Tamanho de imagem para capa: 820×312 pixels 
					• Tamanho de imagem para avatar: recomendado upload com 960×960 pixels 
					• Tamanho de imagem para links compartilhados: 1200×627 pixels 
					• Tamanho de imagem para post mobile: 800×800 pixels 
					Para a capa da sua página no Facebook, você deve enviar um arquivo com dimensões de 820 x 315 pixels. Aqui vale o alerta. Quando você colocar uma imagem de capa na sua página, essa mesma imagem carrega tanto na versão desktop (aquela acessada diretamente pelo seu computador) quanto na versão mobile.
					A divergência acontece na versão mobile. O Facebook faz um corte automático nesse arquivo de imagem e do tamanho oficial de 820 x 315 pixels para a capa, na versão mobile essa imagem fica com de 640 x 360 pixels (sim, altura maior).
					Como resolver: no momento da criação da arte para a sua imagem de capa no Facebook, você pode fazer um arquivo com 820 x 315 pixels, mas precisa ficar atento para que o conteúdo essencial da capa fique dentro das proporções de 640 x 315 pixels, ok? Para ter uma capa personalizada no mobile, você pode fazer uma imagem com 820 x 475 pixels. Mas fique atento para que todo o conteúdo que deve aparecer somente no desktop fique dentro dos 315 de altura, certo? Abaixo disso, só fica visível no mobile. 
					• capa de grupo 1920 x 1080 pixels 
					• capa de evento  1920 x 1080 pixels 
					• avatar com 960 x 960 pixels
					• vídeos com 800 x 800 pixels ou 1080 x 1080 pixels.
					• 
					ANÚNCIOS NO FACEBOOK (objetivo e tamanho): 
					• Banner no Facebook: 850 x 350 pixels; 
					• Cliques no site: 1200 x 628 pixels; 
					• Conversões no site: 1200 x 628 pixels; 
					• Envolvimento com a publicação na página: 1200 x 900 pixels; 
					• Curtidas na página: 1200 x 444 pixels; 
					• Instalação de aplicativos: 1200 x 628 pixels; 
					• Envolvimento com o aplicativo: 1200 x 628 pixels; 
					• Divulgação nas imediações: 1200 x 628 pixels; 
					• Participação no evento: 1200 x 444 pixels; 
					• Obtenção de oferta: 1200 x 628 pixels; 
					• Geração de clientes em potencial: 1200 x 628 pixels. 
					Reconhecimento da marca/alcance
					• Carrossel: 1080 x 1080 pixels; 
					• Imagem única: 868 x 361 pixels; 
					• Apresentação multimídia de alta resolução: proporção 16:9; tempo: 50 segundos; 
					• Vídeo Formato MOV, MP4 ou GIF: resolução 720px; tamanho máximo de 2,3 GB; taxa de proporção 16:9; tempo no Facebook: 60 minutos; tempo no Instagram: 60 segundos. 
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  PUBLICA STORIES  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publica Stories:</b></td>
			@if ($report->FB_stories === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center"><b>SIM</b></td>
			@else
			<td class="btn btn-danger" style="padding: 0.5rem 2rem;text-align: center"><b>NÃO</b></td>
			@endif
		</tr>
		<!--   ----------------------------------------------------------------------------------  PUBLICAÇÕES COM INTERAÇÃO  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left">
				<b>Publicações com interação:</b>
			</td>
			@if ($report->FB_interaction === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
			@else
			<td class="btn btn-danger" style="padding: 0.5rem 2rem;text-align: center">
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
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar a sua performance e tráfego.
				</p>
			</td>
		</tr>
		@else
		<tr>
			<td colspan="2">
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
<!--   =========================================================  INSTAGRAM ===================================================-->
<div>
	<p class="title-reports"><i class="fab fa-instagram-square fa-fw"></i>INSTAGRAM</p>
	<br>
	<table class="table-hover">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui conta Business:</b></td>
			@if ($report->IG_business === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center"><b>SIM</b></td>
			@else
			<td class="btn btn-danger" style="padding: 0.5rem 2rem;text-align: center"><b>NÃO</b></td>
			@endif
		</tr>
		<!--   ----------------------------------------------------------------------------------  CONTA VINCULADA  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Conta vinculada com Facebook:</b></td>
			@if ($report->IG_linked_facebook === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um
					expert: é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade
					de outras características a respeito da sua marca no instagram. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital
					e levar a sua marca para outro patamar.
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
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
					Quando você usa um perfil de negócios (conta business – conta empresa) você potencializa o seu negócio, melhora a sua autoridade e se beneficia
					dos recursos adicionais que não são disponibilizados nas contas pessoais, como: botões de ação, análises métricas, anunciar produtos através de ADS, 
					entre outros.
					<br>
					Contrate a criação de rede social - R$ 250,00
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
		<!--   ----------------------------------------------------------------------------------  MESMO NOME DO SITE  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($report->IG_same_site_name === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Ótimo! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar o estilo, a personalidade, o tom de voz,
					o gênero, entre uma infinidade de outras características a respeito do nome da sua marca. Com técnicas de SEO e UXdesign é possível realizar
					uma transformação digital e levar a sua marca para outro patamar.
					<br>  
					Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
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
					Para que sua empresa seja encontrada de maneira fácil e rápida use o mesmo nome em todos os seus canais de comunicação evitando ao máximo alterar o nome usado. Esse processo facilita a indexação no google, expondo de maneira agrupada os resultados da busca. 
					Ex: facebook/empresadigital
					instagram @empresadigital.net.br (se não conseguir usar o nome curto, use o domínio do seu site)
					Pinterest @empresadigital 
					Twiter @empresadigitalsc (evite usar siglas locais) 
					<br>
					Contrate a padronização de rede social - R$ 200,00
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
		<!--   ----------------------------------------------------------------------------------  BIO  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Descrição da bio:</b></td>
			@if ($report->IG_about === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente!
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
					Sua conta business no instagram preferencialmente deve estar vinculada a sua conta no facebook. Isso porque o instagram foi comprado pelo 
					facebook e já existem algumas unificações que otimizam as suas postagens e a análise de dados, como a programação de postagens no facebook 
					estudio tanto para sua conta do facebook como para sua conta no instagram para o dia/horário da sua escolha. Indicamos usar o mesmo número 
					de whatsapp na criação de todas as contas, pelo mesmo motivo: o whatsapp foi comprado pelo facebook e algumas integrações com o
					instagram/facebook já estão previstas. 
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  LINKTREE  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Linktree na bio:</b></td>
			@if ($report->IG_linktree === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente!
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
					Sua biografia deve descrever claramente o que a sua empresa faz e quais são seus interesses.  Ela deve resumir todas informações da conta,
					trazendo ao visitante tudo que ele precisa saber sobre a pessoa ou empresa dona daquele perfil do Instagram.
					<br>
					Contrate a padronização de redesocial - R$ 200,00
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
		<!--   ----------------------------------------------------------------------------------  CONTEUDOS FEED  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($report->IG_feed_content === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Ótimo! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar a experiência do usuário. Com técnicas de
					UXwriter e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em mkt digital – R$ 200,00
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
					O linktree (árvores de links) é uma das formas de criar vários botões de ação que facilitam para o usuário encontrar exatamente a informação que ele
					procura. 
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  FEED HARMONICO  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Feed organizado:</b></td>
			@if ($report->IG_harmonic_feed === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert,
					é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras
					características a respeito do seu feed. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a sua
					marca para outro patamar.
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
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
					Para melhorar a experiência do usuário proporcionando uma aparência harmônica da marca e maior autoridade recomendamos planejar campanhas
					com 21 posts que se utilize do mesmo padrão de cores como no exemplo em que criamos um padrão baseado na artista brasileira Lygia Clark. Tenha
					em mente que a sua página é a sua empresa em outro espaço: o digital. Da mesma forma que uma empresa física desorganizada, desarmônica ou suja
					causa uma má impressão e afasta o cliente, uma rede social assim prejudicará as suas vendas.
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  SEO DESCRIPTIONS  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($report->IG_SEO_descriptions === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<td colspan="2">
			<p style="font-style:italic;text-align: justify">
				NAO TEM TEXTO
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
					NAO TEM TEXTO
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  FEED IMAGES  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($report->IG_feed_images === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert, 
					é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras 
					características a respeito do seu feed. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a 
					sua marca para outro patamar.
					<br>
					Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
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
					Para se ganhar autoridade, é preciso ter qualidade. Portanto, manter a proporção e a definição das suas postagens é primordial. Use o formato quadrado 
					(square) proporção 1:1 (1.080 x 1.080 pixels); ou o formato horizontal ou paisagem (landscape) proporção: 16:9 (1.920 x 1.080 pixels); ou o formato vertical 
					ou retrato (portrait) proporção 4:5 (1.080 x 1.350 pixels). Outros elementos também são importantes para uma identidade visual harmônica como a 
					diagramação, inserção de legendas entre outros detalhes que, se mal utilizados, podem transformar sua postagem em uma bagunça de informação. 
					<br>
					Ganhe tempo: contrate uma gestão em rede sociais – planos a partir de 400,00
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
		<!--   ----------------------------------------------------------------------------------  STORIES  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publica Stories:</b></td>
			@if ($report->IG_stories === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é 
					sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras 
					características a respeito da sua rede social. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a
					sua marca para outro patamar. 
					<br>
					Leve seu IGTV para outro nível! Contrate uma consultoria especializada R$ 200,00
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
					Traduzido como histórias, o Stories do Instagram é um recurso que tem como objetivo melhorar a interação entre os usuários. Consiste na
					possibilidade de publicar fotos ou vídeos que ficam acessíveis por até 24 horas. Como um passe de mágica, depois disso, eles se autodestroem 
					o imediatamente. Quem viu, viu. Se não viu, já era: não verá mais! E é exatamente esse imediatismo que torna a funcionalidade tão interessante e
					explorada por um número cada vez maior de usuários. Caso você queira deixar algum conteúdo dos stories disponível no seu perfil, é possível salvá-lo
					nos destaques (que também devem estar bem organizados, setorizados e possuir capa). No Instagram Stories, cada vídeo pode ter de 3 a 15 segundos
					de duração, na proporção 9:16  e as dimensões indicadas são 1080px x 1920px.  E uma dica: centralize os itens mais importantes da sua postagem e 
					deixe um espaço livre nas bordas. Isso deve garantir a visualização na maioria dos dispositivos.
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  PUBLICACOES COM INTERAÇÕES  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publicações com interação:</b></td>
			@if ($report->IG_interaction === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é 
					sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras 
					características a respeito da sua rede social. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a
					sua marca para outro patamar. 
					<br>
					Leve seu IGTV para outro nível! Contrate uma consultoria especializada R$ 200,00
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
					Traduzido como histórias, o Stories do Instagram é um recurso que tem como objetivo melhorar a interação entre os usuários. Consiste na
					possibilidade de publicar fotos ou vídeos que ficam acessíveis por até 24 horas. Como um passe de mágica, depois disso, eles se autodestroem 
					o imediatamente. Quem viu, viu. Se não viu, já era: não verá mais! E é exatamente esse imediatismo que torna a funcionalidade tão interessante e
					explorada por um número cada vez maior de usuários. Caso você queira deixar algum conteúdo dos stories disponível no seu perfil, é possível salvá-lo
					nos destaques (que também devem estar bem organizados, setorizados e possuir capa). No Instagram Stories, cada vídeo pode ter de 3 a 15 segundos
					de duração, na proporção 9:16  e as dimensões indicadas são 1080px x 1920px.  E uma dica: centralize os itens mais importantes da sua postagem e 
					deixe um espaço livre nas bordas. Isso deve garantir a visualização na maioria dos dispositivos.
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  INVESTIMENTO ADS  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($report->IG_value_ads,2,",",".") }}</b></td>
		</tr>
		@if ($report->IG_value_ads != "0")
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e 
					é sempre possível colher mais dados para melhorar sua performance e tráfego.
					<br>
					Leve seu Instagram para outro nível! Contrate uma consultoria especializada R$ 200,00
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
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					O Instagram ultrapassou a marca de 1 bilhão de usuários ativos no mundo em 2018 e, de acordo com uma pesquisa da Opinion Box realizada em
					maio de 2018, 50% dos usuários da rede já compraram algum produto ou contrataram algum serviço que conheceram lá. No Brasil, o número de 
					usuários que acessam a rede várias vezes ao dia chega a 63%, sendo que 83% dos entrevistados pelo estudo seguem alguma empresa ou marca no
					Instagram, ou seja, podemos perceber um crescimento expressivo dessa rede social no Brasil.
					Anunciar no Instagram depende muito do orçamento que você possui para alocar em cada campanha. Nesse momento, você deve escolher entre
					um valor diário ou um valor geral para ser distribuído durante toda a campanha. Inclusive, o próprio Instagram delimita um orçamento máximo por
					semana para o segundo caso, então é bem fácil de configurar a parte do orçamento na ferramenta. Esses anúncios podem ser feitos pelo próprio 
					aplicativo do Instagram ou pelo Gerenciador de Negócios do Facebook. 			
				</p>
			</td>
		</tr>
		@endif
	</table>
</div>
<br>
<!--   =========================================================  LINKEDIN ===================================================-->
<div>
	<p class="title-reports"><i class="fab fa-linkedin-in fa-fw"></i>LINKEDIN</p>
	<br>
	<table class="table-hover">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui conta Business:</b></td>
			@if ($report->IN_business === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					sem texto
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
					<br>
					O LinkedIn é uma verdadeira máquina de fazer negócios. A maior rede social para profissionais do mundo conta com mais de 500 milhões de usuários cadastrados, todos eles com um objetivo em comum: estabelecer conexões comerciais. Graças a isso, muitas empresas criam company pages com diversas finalidades, como interagir com potenciais parceiros, estabelecer-se como autoridade em um segmento, recrutar colaboradores e, claro, conquistar clientes. Empresas do segmento B2B têm no LinkedIn um oceano de possibilidades. Mas a rede não é só pra elas. Ter uma Company Page no LinkedIn pode ajudar a estreitar o relacionamento com clientes e parceiros e ser uma ótima estratégia de humanização de marca. Muitas empresas do segmento B2C fazem isso por lá ao compartilhar seus bastidores e como aplicam seus valores, no dia a dia com os funcionários.
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  MESMO NOME DO SITE  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($report->IG_same_site_name === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					XXX
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
					Depois de pronta a sua página de empresa no LinkedIn (e as suas Showcase Pages), é hora de você utilizar estratégias para fazer com que ela cresça e traga os resultados esperados para o seu negócio. 
					Depois que sua Company Page estiver criada, mobilize todos os funcionários da empresa para indicarem, em seus perfis, que trabalham ali. Além de criar um link para a página em cada perfil de funcionário, ela ganhará essas pessoas como seguidores automaticamente e sua empresa ganhará mais autoridade frente ao algoritmo. O compartilhamento e a interação com os conteúdos também ajudará a ampliar o alcance orgânico dos mesmos. Além da página, a empresa pode criar e participar de grupos relacionados, convidando o time para fazer isso também.
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  ABOUT  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Descrição da bio:</b></td>
			@if ($report->IG_about === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					XX
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
					XX
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  CONTEUDOS FEED  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($report->IG_feed_content === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					XX
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
					para usar e gerar conteúdo para o Linkedin você deve Atrair  seguidores tendo como objetivo criar um networking para a sua empresa. O ideal é postar de três a cinco vezes por semana. Há duas formas principais de publicação no Linkedin: LinkedIn Publisher: por meio da publicação de um artigo de formato longo – de cinco a sete parágrafos geralmente – que pode ser compartilhado com a rede do LinkedIn; Atualização de status: é um recurso semelhante ao Twitter, que é ótimo para atualizações e mensagens curtas e eficientes. Esse formato geralmente gera mais comentários e compartilhamentos. Você sabe que, se quer mesmo muitas visualizações, o indicado é fazer uso de vídeos. O Linkedin não só aceita este recurso, como permite que você faça atualizações de status de vídeo diretamente na plataforma. Você também pode adicionar vídeos tanto no seu perfil quanto nas atualizações da página da empresa. Conteúdo para interagir Nunca esqueça que o Linkedin é uma plataforma de conteúdo para pessoas, feita para a interação; sendo um lugar muito mais sobre e para o indivíduo do que para e sobre sua marca e empresa. Sendo assim, mostre quem você é, divulgue sua voz. Se você tem seu próprio negócio, ainda conseguirá passar a imagem de líder engajado, o que naturalmente acaba fortalecendo a sua marca.  Ao otimizar o seu perfil, você aumenta a chance de ser localizado por um grupo de influenciadores concorrentes. Em outras palavras, é uma forma de você ter certeza de que seu conteúdo alcança o público segmentado que você almeja. Você também pode investir em publicidade. É eficiente considerar o resultado deste orçamento.  
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  SEO DESCRIPTIONS  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($report->IG_SEO_descriptions === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<td colspan="2">
			<p style="font-style:italic;text-align: justify">
				NAO TEM TEXTO
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
					NAO TEM TEXTO
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  FEED IMAGES  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($report->IG_feed_images === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					XX
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
					Para se ganhar autoridade, é preciso ter qualidade portanto manter a proporção e a definição das suas postagem é primordial. 
					Os tamanhos de imagens para  Perfil pessoal: Avatar: 130 X 130 px , Foto de capa: 1.584 x 396 px. Perfil corporativo: Avatar: 130 X 130 px; Foto de capa: 1.584 x 396 px. Posts: Post com imagem: 520 X 320 px , Post com link: 520 X 272 px. Foto de capa do perfil pessoal  130 x 130, Imagem de capa corporativa 1.584 x 396, Imagem do perfil corporativo 130 x 130, Imagem de post sem link: 520 x 320, Imagem de post com link: 520 x 272.
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  PERFIL DOS FUNCIONÁRIOS  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Funcionários possuem perfil na rede::</b></td>
			@if ($report->IN_employee_profiles === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					XX
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
					XX
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  ANUNCIA VAGAS  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Anuncia/aceita vagas na rede:</b></td>
			@if ($report->IN_offers_job === "yes")
			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
				<b>SIM</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					XX
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
					XX
				</p>
			</td>
		</tr>
		@endif
		<!--   ----------------------------------------------------------------------------------  INVESTIMENTO ADS  -----------------------------------------------------------------------------------  -->
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($report->IG_value_ads,2,",",".") }}</b></td>
		</tr>
		@if ($report->IN_value_ads != "0")
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					<br>
					XXX
				</p>
			</td>
		</tr>
		@else
		<tr>
			<td colspan="2">
				<p style="font-style:italic;text-align: justify">
					Para você ter uma ideia da importância do LinkedIn, 92% dos profissionais do segmento B2B a consideram como a mais importante, acima até das demais redes sociais. O LinkedIn é fundamental para quem está buscando atingir um público segmentado por cargos, profissões, empresas e até mesmo investidores que tenham a ver com o perfil de uma empresa e/ou marca. Isso porque, o LinkedIn é a única que tem o viés profissional e foi criada exatamente para fazer conexões profissionais.  E existem muitas outras vantagens em anunciar no LinkedIn Ads: concorrência: como não há tantas marcas investindo em LinkedIn Ads, principalmente no Brasil e no idioma português, existe um maior alcance com menor investimento;  segmentação: o LinkedIn é uma das únicas redes sociais que solicitam o cargo e outros dados profissionais para os cadastrados. Sendo assim, é possível atingir os tomadores de decisão ou um público profissional específico para o seu negócio; foco profissional: enquanto Facebook, Instagram, Twitter e outras redes sociais são utilizadas prioritariamente para interesses pessoais, no LinkedIn as pessoas se cadastram justamente para tratar sobre negócios e receber novas oportunidades. Isso significa que elas estão naturalmente abertas para contatos de desconhecidos, mensagens de pessoas e marcas. Basicamente, o LinkedIn é um recanto de leads qualificados. A própria rede social oferece recursos exclusivos para captação de leads, como o LinkedIn Sales Navigator.		
				</p>
			</td>
		</tr>
		@endif
	</table>
	<!--   =========================================================  TWITTER ===================================================-->
	<div>
		<p class="title-reports"><i class="fab fa-twitter fa-fw"></i>TWITTER</p>
		<p class="labels">Nome:<span class="fields">{{ $report->TW_page_name }}</span></p>
		<p class="labels">Endereço:<span class="fields">{{ $report->TW_URL_name }}</span></p>
		<br>
		<table class="table-hover">
			<tr>
				<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
				<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
			</tr>
			<!--   ----------------------------------------------------------------------------------  CONTA BUSINESS  -----------------------------------------------------------------------------------  -->
			<tr>
				<td   class="table-list-left">
					Possui conta Business:
				</td>
				@if ($report->TW_business === "yes")
				<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
					<b>SIM</b>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="font-style:italic;text-align: justify">
						<br>
						Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar sua performance e tráfego.
						<br>
						Leve seu FACEBOOK para outro nível! Contrate uma consultoria especializada por R$ 200,00
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
						O Facebook se tornou parte essencial da estratégia de marketing digital de muitas empresas. Isso porque ele é a maior rede social da atualidade, com mais de 2 bilhões de usuários ativos. Tanto é que, segundo a pesquisa do site HootSuite, o Facebook já conta com cerca de 50 milhões de empresas promovendo seus produtos ou serviços com anúncios. Afinal, expor a sua marca em uma vitrine dessas sem pagar uma fortuna por isso, é o sonho de todo empreendedor.
						O gerenciador de anúncios Facebook Business é uma potente ferramenta para criar, gerenciar e verificar o desempenho de anúncios publicados na plataforma. Com ele também é possível direcionar seus anúncios a públicos específicos, definir o orçamento a ser destinado a cada um, verificar seu desempenho e ter um relatório sobre o retorno desse investimento.
						Além disso, nas últimas atualizações do Facebook, a rede social disponibilizou o Power Editor, ferramenta que te permite gerenciar múltiplos anúncios simultaneamente, tornando a tarefa mais prática e eficaz.
						Vale lembrar ainda que como o Facebook integra outras redes sociais, o gerenciador também te ajuda a administrar anúncios do Instagram Ads e do Audience Network - uma rede de aplicativos para exibição de propagandas.
						E isso é importante, afinal, com ela é possível fazer a mensagem ter um alcance maior, já que porque 72% das pessoas dizem que os posts nas redes sociais são o principal formato de conteúdo consumido.
					</p>
				</td>
			</tr>
			@endif
			<!--   ----------------------------------------------------------------------------------  CONTA VINCULADA FACEBOOK  -----------------------------------------------------------------------------------  -->
			<tr>
				<td   class="table-list-left">
					Conta Business vinculada com Facebook:
				</td>
				@if ($report->TW_linked_facebook === "yes")
				<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
					<b>SIM</b>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="font-style:italic;text-align: justify">
						<br>
						Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! 
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
						Sua conta business no instagram preferencialmente deve estar vinculada a sua conta no facebook. Isso porque o instagram foi comprado pelo facebook e já existem algumas unificações que otimizam as suas postagens e a análise de dados, como a programação de postagens no facebook estudio tanto para sua conta do facebook como para sua conta no instagram para o dia/horário da sua escolha. Indicamos usar o mesmo número de whatsapp na criação de todas as contas, pelo mesmo motivo: o whatsapp foi comprado pelo facebook e algumas integrações com o instagram/facebook já estão previstas. 
					</p>
				</td>
			</tr>
			@endif
			<!--   ----------------------------------------------------------------------------------  CONTA VINCULADA SITE  -----------------------------------------------------------------------------------  -->
			<tr>
				<td   class="table-list-left">
					Conta Business vinculada com Site:
				</td>
				@if ($report->TW_linked_site === "yes")
				<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
					<b>SIM</b>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="font-style:italic;text-align: justify">
						<br>
						Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! 
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
						Sua conta business no instagram preferencialmente deve estar vinculada a sua conta no facebook. Isso porque o instagram foi comprado pelo facebook e já existem algumas unificações que otimizam as suas postagens e a análise de dados, como a programação de postagens no facebook estudio tanto para sua conta do facebook como para sua conta no instagram para o dia/horário da sua escolha. Indicamos usar o mesmo número de whatsapp na criação de todas as contas, pelo mesmo motivo: o whatsapp foi comprado pelo facebook e algumas integrações com o instagram/facebook já estão previstas. 
					</p>
				</td>
			</tr>
			@endif
			<!--   ----------------------------------------------------------------------------------  MESMO NOME DO SITE  -----------------------------------------------------------------------------------  -->
			<tr>
				<td   class="table-list-left">
					<b>Conta possui mesmo nome do site:</b>
				</td>
				@if ($report->TW_same_site_name === "yes")
				<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
					<b>SIM</b>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="font-style:italic;text-align: justify">
						<br>
						Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar  o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito do nome da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
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
						Para que sua empresa seja encontrada de maneira fácil e rápida, use o mesmo nome em todos os seus canais de comunicação evitando ao máximo alterar o nome usado. Esse processo facilita a indexação no google, expondo de maneira agrupada os resultados da busca. 
						<br>
						Para que sua empresa seja encontrada de maneira fácil e rápida, use o mesmo nome em todos os seus canais de comunicação evitando ao máximo alterar o nome usado. Esse processo facilita a indexação no google, expondo de maneira agrupada os resultados da busca. 
						Ex: facebook/empresadigital
						instagram @empresadigital.net.br (se não conseguir usar o nome curto uso o domínio do seu site)
						Pinterest @empresadigital 
						Twiter @empresadigitalsc (evite usar siglas locais) 

						Contrate a padronização de rede social - R$ 200,00
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
			<!--   ----------------------------------------------------------------------------------  APRESENTAÇÃO DA PÁGINA  -----------------------------------------------------------------------------------  -->
			</tr>	
			<tr>
				<td   class="table-list-left"><b>Apresentação da página:</b></td>
				@if ($report->TW_about === "yes")
				<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
					<b>SIM</b>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="font-style:italic;text-align: justify">
						<br>
						Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar  o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito da sua biografia. Com técnicas de SEO, CANVAS, SWOT e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar. 

						Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
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
				<td>
					<p style="font-style:italic;text-align: justify">
						Sua biografia deve descrever claramente o que a sua empresa faz e quais são seus interesses.   Ela deve resumir todas informações da conta, trazendo ao visitante tudo que ele precisa saber sobre a pessoa ou empresa dona daquele perfil/página.

						Contrate a padronização de rede social - R$ 200,00
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
			<!--   ----------------------------------------------------------------------------------  PUBLICA NO FEED  -----------------------------------------------------------------------------------  -->
			<tr>
				<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
				@if ($report->TW_feed_content === "yes")
				<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
					<b>SIM</b>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="font-style:italic;text-align: justify">
						<br>
						Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar os números, a qualidade do conteúdo com técnicas de SEO e a harmonização do design através da experiência do usuário. 

						Leve seu feed pra outro nível! Contrate uma consultoria especializada em marketing digital – R$ 200,00
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
						A produção de conteúdo é necessária e de total relevância para se obter um retorno de investimento por meio das redes sociais. Pelas nossas análises o ideal é que você faça postagens diárias.
						Para iniciar trabalho de tráfego orgânico: Ao menos 2 vezes por semana podendo intercalar com 1 produto e 1 conteúdo de qualidade. 
						<br>
						Tipos de postagens:  Biográfica, Produto, frases e citações, tutorial, dicas, conteúdo longo 
					</p>
				</td>
			</tr>
			@endif
			<!--   ----------------------------------------------------------------------------------  INVESTIMENTO EM ADS -----------------------------------------------------------------------------------  -->		
			<tr>
				<td   class="table-list-left">
					<b>Investimento em ADs:</b>
				</td>
				<td   class="table-list-money-income"><b> R$ {{ number_format($report->TW_value_ads,2,",",".") }}</b></td>
			</tr>
			@if ($report->TW_value_ads != "0")
			<tr>
				<td colspan="2">
					<p style="font-style:italic;text-align: justify">
						<br>
						Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar a sua performance e tráfego.
					</p>
				</td>
			</tr>
			@else
			<tr>
				<td colspan="2">
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
			Editar informações
		</a>
		<a class="btn btn-secondary" href=" {{!! url('/relatorios', $report->id) !!}}">
			PDF
		</a>
		<a class="btn btn-secondary" href="{{route('report.index')}}">
			VOLTAR
		</a>
		@endsection