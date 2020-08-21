@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{ asset('imagens/astronauta-estrela.png') }} 
@endsection

@section('description')

Mantenha suas redes sociais em dia para manter um bom relacionamento com seus clientes

@endsection

@section('main')
<center>
	oiiiiiiiiiiiiiiii
<div style="width: 100%">
<div class="numbers">
	<p class="numeros_painel">  {{ $totalTasks }}</p>
	<p class="subtitulo-branco"> tarefas pendentes </p>
	<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DTasks%26action%3Dindex%26parentTab%3DAtividades" target="_blank" style="color: yellow">fazer</a></p>
</div>

<div class="numbers">
	<p class="numeros_painel">  {{  $totalLeads }} </p>
	<p class="subtitulo-branco"> potenciais aguardando </p>
	<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DLeads%26action%3Dindex%26parentTab%3DComercial" style="color: yellow">contatar</a></p>
</div>

<div class="numbers">
	<p class="numeros_painel"  style="font-size: 40px">  R$ {{  $totalOpportunities }} </p>
	<p class="subtitulo-branco"> em oportunidades</p>
	<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3Dindex%26parentTab%3DComercial" style="color: yellow">vender</a></p>
</div>
</div>
</center>


<div style="width:100vw; background-color: #c28dbf">
	<div class="admin-blocks"">
		<p class="subtitulo-roxo">FINANCEIRO</p>
		<br>
		<a href="https://financeiro.empresadigital.net.br/">
			<button class="botao-roxo">GERENCIADOR</button></a><br>
		<br>
		<a href="/transactions">
			<button class="botao-roxo">ENTRADAS</button></a><br>
	</div>

	<div class="admin-blocks">
		<p class="subtitulo-roxo">CONTRATOS DIGITAIS</p>
		<br>
		<a href="https://painel.autentique.com.br/" target="blank">
			<button class="botao-roxo">ACESSAR</button></a><br>
	</div>

	<div class="admin-blocks" >
		<p class="subtitulo-roxo">NOVA PLATAFORMA</p>
		<br>
		<a href="{{ route('user.create') }}" target="blank">
			<button class="botao-roxo">CRIAR</button></a><br>
	</div>

	<div class="admin-blocks" >
		<p class="subtitulo-roxo">PLATAFORMA</p>
		<br>
		<a href="/usuarios">
			<button class="botao-roxo">USUÁRIOS</button></a><br>
			<br>
		<a href="/accounts">
			<button class="botao-roxo">EMPRESAS</button></a><br>
	</div>
</div>

<div style="width:100vw; background-color: white;vertical-align: middle">
	<div class="admin-blocks">
		<p class="subtitulo-roxo">GERENCIAR EMAILS</p>
		<br>
		<a href="https://acadia.mxroute.com:2083/" target="blank">
			<button class="botao-claro">CRIAR CONTAS</button></a><br>
		login: solucoes
		<br>
	</div>


	<div class="admin-blocks">
		<p class="subtitulo-roxo">MIGRAÇÕES</p>
		<br>
		<a href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Empresa%20Digital/operacional/plataforma&fileid=8431" target="blank">
			<button class="botao-claro">ACESSAR</button></a><br>
		login: xxxxxx
	</div>

	<div class="admin-blocks">
		<p class="subtitulo-roxo">SERVIDORES</p>
		<br>
		<a href="https://62.171.185.126:8090/" target="blank">
			<button class="botao-roxo">SERVIDOR NOVO</button></a><br>
		login: admin
		<br>
		<br>
		<a href="https://167.86.97.159:2087" target="blank">
			<button class="botao-roxo">SERVIDOR ANTIGO</button></a><br>
		login: root
	</div>

	<div class="admin-blocks">
		<p class="subtitulo-roxo">FUNIL DE VENDAS</p>
		<br>
		<a href="/funil-vendas" target="blank">
			<button class="botao-claro">INICIAR</button></a><br>
	</div>
</div>
@endsection