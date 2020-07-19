@extends('layouts/painel')

@section('title','Empresa Digital ADMIN')

@section('admin') 

<div class="grid-admin">
	<div class="financeiro">
		<p class="subtitulo-roxo">FINANCEIRO</p>
		<br>
		<a href="https://financeiro.empresadigital.net.br/">
			<button class="botao-roxo">GERENCIADOR</button></a><br>
		<br>
		<a href="/transactions">
			<button class="botao-roxo">ENTRADAS</button></a><br>
	</div>

	<div class="contratos">
		<p class="subtitulo-roxo">CONTRATOS DIGITAIS</p>
		<br>
		<a href="https://painel.autentique.com.br/" target="blank">
			<button class="botao-roxo">ACESSAR</button></a><br>
	</div>

	<div class="nova-plataforma" >
		<p class="subtitulo-branco">NOVA PLATAFORMA</p>
		<br>
		<a href="{{ route('user.create') }}" target="blank">
			<button class="botao-claro">CRIAR</button></a><br>
	</div>

	<div class="usuarios-plataforma" >
		<p class="subtitulo-branco">USUÁRIOS DA PLATAFORMA</p>
		<br>
		<a href="/usuarios">
			<button class="botao-claro">VER LISTA</button></a><br>
	</div>

	<div class="emails">
		<p class="subtitulo-branco">GERENCIAR EMAILS</p>
		<br>
		<a href="https://acadia.mxroute.com:2083/" target="blank">
			<button class="botao-claro">CRIAR CONTAS</button></a><br>
		login: solucoes
		<br>
	</div>

	<div class="migracoes">
		<p class="subtitulo-roxo">MIGRAÇÕES</p>
		<br>
		<a href="https://nuvem.empresadigital.net.br/index.php/apps/files/?dir=/Empresa%20Digital/operacional/plataforma&fileid=8431" target="blank">
			<button class="botao-roxo">ACESSAR</button></a><br>
		login: xxxxxx
	</div>

	<div class="servidores">
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

	<div class="vendas">
		<p class="subtitulo-branco">FUNIL DE VENDAS</p>
		<br>
		<a href="/funil-vendas" target="blank">
			<button class="botao-claro">INICIAR</button></a><br>
	</div>


</div>

@endsection