@extends('layouts/master')

@section('title','TRANSAÇÃO')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('transaction.index')}}">VER TRANSAÇÕES </a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">  {{$transaction->page_name}}  </h1>
	<br>
	<p class="labels">DONO:<span class="fields"></span></p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Análise da página</b></td>
			<td   class="table-list-header"><b>situação</b></td>
		</tr>
	</table>

	<div style="text-align:right;padding: 2%">
			<form class="button" action="{{ route('transaction.destroy', ['transaction' => $transaction->id]) }}" method="post">
				@csrf
				@method('delete')
				<input type="submit" value="">
			</form>
		<a class="btn btn-secondary" href=" {{ route('transaction.edit', ['transaction' => $transaction->id]) }}">
			<i class='fa fa-edit'></i>EDITAR</a>
				<a class="btn btn-secondary" href="{{route('transaction.index')}}">VOLTAR</a>
	</div>
	<br>
	<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>
@endsection