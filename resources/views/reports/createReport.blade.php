@extends('layouts/master')

@section('title','CRIAR BRIEFING')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')

Ferramenta de Briefing e maturidade digital 
<a href=" {{ route('user.index') }}">
	<br>
	<br>
	<button type="button" class="button">VER COLABORADORES</button> </a>
@endsection

@section('main')
<p class="title-reports">DADOS DO RELATÓRIO </p>
<br>
<form action=" {{ route('reports.store') }} " method="post">
	@csrf
	<label class="labels" for="" >DONO: </label>
	<select class="fields" name="user_id">
		@foreach ($users as $user)
		<option value="{{ $user->id }}">
			{{ $user->name }}
		</option>
		@endforeach
	</select>
	<br>
	<label  class="labels" for="">Nome do relatório: </label>
	<input class="fields" type="text" name="name">
	<br>
	<label class="labels" for="">Data da realização: </label>
	<input class="fields" type="date" name="date">
	<br>
	<label class="labels" for="">Situação: </label>
	<select class="fields" name="status">
		<option value="pending">pendente</option>
		<option value="disable">desativado</option>
		<option value="active">ativo</option>
	</select>
	<br>
	<br>
	<p class="title-reports">IDENTIDADE VISUAL </p>
	<br>
	<label class="labels" for="" >Logomarca: </label><br>
	<input type="radio" name="logo" value="good" checked="checked"><span class="fields">Adequada</span><br>
	<input type="radio" name="logo" value="regular"><span class="fields">Precisa de adequações</span><br>
	<input type="radio" name="logo" value="bad"><span class="fields">Não possui</span><br>
	<br>
	<br>
	<label class="labels" for="" >Paleta de cores? [Kit de UI ]</label>
	<br>
	<input type="radio" name="palette" value="good" checked="checked"><span class="fields">Adequada</span><br>
	<input type="radio" name="palette" value="regular"><span class="fields">Precisa de adequações</span><br>
	<input type="radio" name="palette" value="bad"><span class="fields">Não possui</span><br>
	<br>
	<br>
	<p class="title-reports">FACEBOOK</p>
	<br>
	<label class="labels" for="">Nome da página:</label>
	<br>
	<input type="text" name="page_name"><span class="fields"></span><br>
	<br>
	<label class="labels" for="">Conta Business vinculada com Instagram: </label>
	<br>
	<input type="radio" name="FB_linked_instagram" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_linked_instagram" value="no"><span class="fields">Não</span><br>
	<br>


	<label class="labels" for="">Conta possui mesmo nome do site: </label>
	<br>
	<input type="radio" name="FB_same_site_name" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_same_site_name" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Apresentação da página:</label>
	<br>
	<input type="radio" name="FB_about" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_about" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Publica conteúdos no feed:</label>
	<br>
	<input type="radio" name="FB_feed_content" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_feed_content" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Feed organizado:</label>
	<br>
	<input type="radio" name="FB_harmonic_feed" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_harmonic_feed" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Publicações usam SEO:</label>
	<br>
	<input type="radio" name="FB_SEO_descriptions" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_SEO_descriptions" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Imagens têm tamanho correto:</label>
	<br>
	<input type="radio" name="FB_feed_images" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_feed_images" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Publica Stories:</label>
	<br>
	<input type="radio" name="FB_stories" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_stories" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Publicações com interação:</label>
	<br>
	<input type="radio" name="FB_interaction" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_interaction" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Paga ADs:</label>
	<br>
	<input type="radio" name="FB_pay_ads" value="yes" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="FB_pay_ads" value="no"><span class="fields">Não</span><br>
	<br>
	<label class="labels" for="">Investimento em ADs:</label>
	<input type="number" min="1" step="10">
	<br>


	<br>   <p class="destaque_amarelo">INSTAGRAM </p>
	<label for="" >Sua empresa  possui conta bussiness? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Conta está vinculada ao facebook? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Nome da conta está igual ao site? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Apresentação/ bio está preenchida? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >bio possui link para site o linktree? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Produz conteúdo para FEED?  : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >FEED é organizado? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >As imagens do FEED estão no tamanho correto?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Produz conteúdo para IGTV? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" > Produz STORIES?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Usa recursos de INTERAÇÂO do stories?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Paga ads? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Quanto de ads? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<input class="botao-claro"  type="submit" value="Salvar">
	<br>
	<br>   <p class="destaque_amarelo">FACEBOOK</p>
	<label for="" >Sua empresa  possui conta bussiness? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >-Conta está vinculada ao Instagram?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Nome da conta está igual ao site? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Apresentação/ bio está preenchida? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >bio possui link para site o linktrhee? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Produz conteúdo para FEED?  : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >FEED é organizado? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >As descrições do FEED usam hastags com SEO? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >As imagens do FEED estão no tamanho correto?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Produz conteúdo para IGTV? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" > Produz STORIES?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Usa recursos de INTERAÇÂO do stories?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Paga ads? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Quanto de ads? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>


	<br>
	<input class="botao-claro"  type="submit" value="Enviar">

	<br>   <p class="destaque_amarelo">LINKEDIN</p>
	<label for="" >Sua empresa  possui conta bussiness? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Funcionários da empresa possuem perfil linkado? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Nome da conta está igual ao site? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Apresentação/ bio está preenchida? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Possui anúncio de vaga de trabalho? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Produz conteúdo para FEED?  : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >FEED é organizado? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >As imagens do FEED estão no tamanho correto?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>

	<label for="" > Produz STORIES?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Usa recursos de INTERAÇÃO?: </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >é usuário premium? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Paga ads? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<label for="" >Quanto de ads? : </label><br>
	<input type="radio" name="possui-logomarca">sim.<br> 
	<input type="radio" name="possui-logomarca">não. <br> 
	<br>
	<input class="botao-claro"  type="submit" value="Salvar">
</form>

<form action=" {{ route('user.store') }} " method="post" style="padding: 40px;color:white">
	@csrf
	<br>   <p class="destaque_amarelo">INSTAGRAM </p>
	<label for="" >Possui quantos SEGUIDORES?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a LOCALIZAÇÃO de seus seguidores?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a FAIXA ETÁRIA dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o Gênero dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o conteúdo mais curtido do FEED?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o stories mais vizualizado?  : </label><br>
	<br>
	<input class="botao-claro"  type="submit" value="Salvar">
	<br>
	<br>   <p class="destaque_amarelo">FACEBOOK</p>
	<br>
	<label for="" >Possui quantos SEGUIDORES?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a LOCALIZAÇÃO de seus seguidores?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a FAIXA ETÁRIA dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o Gênero dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o conteúdo mais curtido do FEED?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o stories mais vizualizado?  : </label><br>
	<input class="botao-claro"  type="submit" value="Salvar">

	<br>   <p class="destaque_amarelo">LINKEDIN</p>
	<br>
	<label for="" >Possui quantos SEGUIDORES?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a LOCALIZAÇÃO de seus seguidores?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a FAIXA ETÁRIA dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o Gênero dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o conteúdo mais curtido do FEED?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o stories mais vizualizado?  : </label><br>
	<input class="botao-claro"  type="submit" value="Salvar">

	<br>   <p class="destaque_amarelo">PINTEREST</p>
	<label for="" >Possui quantos SEGUIDORES?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a LOCALIZAÇÃO de seus seguidores?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a FAIXA ETÁRIA dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o Gênero dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o conteúdo mais curtido do FEED?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é a pasta mais adicionada?  : </label><br>
	<input class="botao-claro"  type="submit" value="Enviar dados">
	<input class="botao-claro"  type="submit" value="Salvar">
	<br>   <p class="destaque_amarelo">TWITTER</p>
	<label for="" >Possui quantos SEGUIDORES?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a LOCALIZAÇÃO de seus seguidores?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a FAIXA ETÁRIA dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o Gênero dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o conteúdo mais curtido do FEED?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o stories mais vizualizado?  : </label><br>
	<input class="botao-claro"  type="submit" value="Salvar">
	<br>   <p class="destaque_amarelo">PODCAST/SPOTIFY</p>
	<label for="" >Possui quantos SEGUIDORES?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a LOCALIZAÇÃO de seus seguidores?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" >Qual a FAIXA ETÁRIA dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o Gênero dos seus seguidores? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o conteúdo mais curtido do FEED?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual é o podcast mais ouvido?  : </label><br>
	<input class="botao-claro"  type="submit" value="Salvar">
	<br>   <p class="destaque_amarelo">WEBSITE</p>
	<br>
	<label for="" > Qual o numero de visitantes dia?: </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<label for="" > Qual o numero de visitantes mes? : </label><br>
	<input type="text" name="possui-logomarca"> Cole o link aqui: <br> 
	<br>
	<input class="botao-claro"  type="submit" value="Salvar">
	</div>
	</div>



	<p>




		6-Produz conteúdo para FEED? 
		Sim
		Não 

		7-FEED é organizado? 
		Sim
		Não

		8-As imagens do FEED estão no tamanho correto?
		Sim
		Não

		9-Paga ads?
		Sim
		Não 

		10-Quanto de ads? 


		PINTEREST

		Possui conta? 
		Sim
		Não 

		Nome da conta está igual ao site?
		Sim
		Não

		Apresentação/ bio está preenchida?
		Sim
		Não

		Possui pastas com ideias? 
		Sim
		Não

		Produz conteúdo? 
		Sim
		Não 

		Qual peridicidade?
		2x na semana
		1xpor semana
		15 dias
		1x por mês 

		Produz STORIES?
		Sim
		Não

		Paga ads?
		Sim
		Não 

		Quanto de ads? 


		7- TWITTER
		Possui conta? 
		Sim
		Não 

		Conta está vinculada ao facebook?
		Sim
		Não

		Nome da conta está igual ao site?
		Sim
		Não

		Apresentação/ bio está preenchida?
		Sim
		Não

		bio possui link para site?
		Sim
		Não

		Produz conteúdo para FEED? 
		Sim
		Não 

		Paga ads?
		Sim
		Não 

		Quanto de ads? 


		8- PODCAST/SPOTIFY
		Possui conta? 
		Sim
		Não 

		Nome da conta está igual ao site?
		Sim
		Não

		Apresentação/ bio está preenchida?
		Sim
		Não

		bio possui link para site?
		Sim
		Não

		Produz conteúdo para FEED? 
		Sim
		Não 

		FEED é organizado? 
		Sim
		Não

		As imagens do FEED estão no tamanho correto?
		Sim
		Não

		Paga ads?
		Sim
		Não 

		Quanto de ads? 

		9- NUVEM

		Não
		Sim do google
		Sim do Dropbox
		Sim própria
		Sim, pago hospedagem. 



		10- EMAIL CORPORATIVO: ex seunome@suaempresa.com.br

		Possui domínio próprio?
		Não
		Sim

		Cada departamento possui um email?
		Não
		Sim

		Cada Funcionário possui um email?
		Não
		Sim

		11- Sua empresa faz estratégia de EMAIL MARKETING?

		Nunca fiz
		não sei o que é 
		Sim

		11- Sua empresa possui CRM?

		não sei o que é 
		Sim
		não

		12- GOOGLE SUITE

		Sim – tenho um conta gratuita
		Sim – tenho uma conta premium
		Não

		usa e-mail?
		Sim
		não

		atingiu o limite de espaço no email?
		Sim
		não

		Quantos usuários pagantes? 

		Usa nuvem?
		Sim
		não

		Sua nuvem atingiu o limite de espaço?
		Sim 
		não

		Usa editor de texto?
		Sim
		não

		Usa formulário? 
		Sim
		não

		Usa agenda? 
		Sim
		não

		Paga ads? 
		Sim
		não

		quanto de ads?

		Conta está vinculada com youtube? 
		Sim
		não

		Usa MEU NEGÓCIO? 
		Sim
		não

		Possui seguidores? 
		Sim
		não

		Quantos seguidores?

		Possui avaliações e comentários? 
		Sim
		não

		Situação atual da avaliação? 
		Bom
		Médio
		Ruim 
		ótimo

		Nome da conta está igual ao site?
		Sim
		Não

		Apresentação/ bio está preenchida?
		Sim
		Não

		bio possui link para site?
		Sim
		Não

		Produz conteúdo para FEED? 
		Sim
		Não 

		FEED é organizado? 
		Sim
		Não

		As imagens do FEED estão no tamanho correto?
		Sim
		Não


		3- WHATS APP 

		Possui numero pessoal? 
		Sim
		Não 

		Possui conta bussiness? 
		Sim
		Não 


		Possui respostas automáticas de vendas?
		Sim
		Não

		Nome da conta está igual ao site?
		Sim
		Não

		Apresentação/ bio está preenchida?
		Sim
		Não

		Loja possui produtos e valores?
		Sim
		Não

		Quantos produtos? 

		Produz conteúdo para STATUS? 
		Sim
		Não 

		Possui lista de transmissão? 
		Sim
		Não 

		Backup dos números do celular? 
		Sim
		Não 

		Grupo de vendas? 
		Sim
		Não 

		Faz toda a comunicação da empresa pelo whatsapp?
		Sim
		Não 

		Faz a comunicação da empresa com outros aplicativos? Qual
		slack
		Trello
		outro

		Já teve a conta deletada e perdeu dados?
		Sim
		não

		Possui mais de um número? 
		Sim
		não

		Quais números? 

		3-  TELEGRAM

		Possui número pessoal? 
		Sim
		Não 

		Possui conta bussiness? 
		Sim
		Não 

		Possui respostas automáticas de vendas?
		Sim
		Não

		Nome da conta está igual ao site?
		Sim
		Não

		Apresentação/ bio está preenchida?
		Sim
		Não

		possui canal?
		Sim
		Não

		Produz conteúdo para STATUS? 
		Sim
		Não 

		Possui lista de transmissão? 
		Sim
		Não 

		faz Backup dos números do celular? 
		Sim
		Não 

		Grupo de vendas? 
		Sim
		Não 

		Faz toda a comunicação da empresa pelo whatsapp?
		Sim
		Não 

		Faz a comunicação da empresa com outros aplicativos? Qual
		slack
		Trello
		outro

		Já teve a conta deletada e perdeu dados?
		Sim
		não

		Possui mais de um número? 
		Sim
		não

		Quais números? 


		3-  SITE

		Possui website? 
		Sim
		não

		Qual serviço usa? 
		WIX – gratuito
		WIX pago
		WORDPRESS - gratuito
		WORDPRESS – pago
		outra plataforma -gratuita - qual
		outraplataforma paga – qual 

		Quam faz o seu site? 
		Eu mesmo faço
		pago um web designer
		pago uma empresa de marketing 

		Quem atualiza o seu site? 
		Eu mesmo faço
		pago um web designer
		pago uma empresa de marketing 

		Seu site possui BLOG?
		Sim
		não

		Qual a peridiocidade de postagens no BLOG?
		1 x por semana
		2x por semana
		2x por mês
		1x por mês
		não posto já faz mais de 1 ano 



		3-  LOJA VIRTUAL

		possui loja virtual? 
		sim, mas não vendo por lá
		Não
		sim, vendo bastante.

		Qual plataforma sua loja usa?
		Woocomerce
		xtech
		mercadolivre
		outra – qual

		Quantos produtos sua loja vende?
		1
		até 10
		10-50
		acima de 50

		Qual tipo de produto você vende?
		Físico
		Virtual


		3-  PÙBLICO_ALVO

		Você conhece o seu público-alvo? 
		Sim
		Não
		Não sei o que é 

		Sua listas de clientes estão segmentadas?
		Sim
		Não
		Não sei o que é 

		3-  PERSONA

		você conhece as PERSONAS da sua empresa?
		Sim
		não

		quantas personas sua empresa tem? 
		1
		2
		3
		mais de 4
		Não tenho
		não sei o que é

		3-  CONCORRENTES

		você sabe quem são os concorrentes da sua empresa? 
		Sim, são grandes corporações
		sim, são empresas perto  do meu estabelecimento
		sim, são empresas da minha cidadade
		Não

		3-  BANCO DE DADOS

		sua empresa possui banco de dados? 
		Sim uso softwares 
		Sim, uso planilhas no exel
		Não, mas anoto no carderno
		Não
		Não sei o que é

	</p>
	@endsection