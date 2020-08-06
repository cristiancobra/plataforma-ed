@extends('layouts/master')

@section('title','EMPRESAS')

@section('image-top')
{{ asset('imagens/novo-email.png') }} 
@endsection

@section('description')

Organize seus recursos por empresa
<a href="/accounts/novo"><br><br>
	<button type="button" class="button">SOLICITAR NOVA EMPRESA</button> </a>
@endsection

@section('main')
<table style="color:#874983; text-align: center; margin: 5%;  font-weight: bold;font-size: 20px">
	<tr>
		<td   style="text-align:center"> <b>ID</b></td>
		<td   style="text-align:center"> <b>Usuário </b></td>
		<td   style="text-align:center"> <b>Empresa </b></td>
		<td   style="text-align:center"> <b>Email</b></td>
	</tr>

	@foreach ($accounts as $account)
	<tr style="font-size: 16px">
		<td style="padding-left: 10px;padding-right: 10px; font-size: 9px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white">  {{ $account->id }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""><b>   </b></td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white"">  {{ $account->name }}  </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white;text-align: left"> {{ $account->email  }} </td>
		<td style="padding-left: 10px;padding-right: 10px;text-align:center"> 
			<button class="button"><a href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank" style="text-decoration: none;color: black"><i class='fas fa-comment-dots'></i> mensagem</a></button></td>
		<td style="padding-left: 10px;padding-right: 10px;text-align:center"> 
			<button class="button"><a href=" https://vendas.empresadigital.net.br/index.php?module=Emails&action=index&parentTab=Colabora%C3%A7%C3%A3o"  target="_blank" style="text-decoration: none;color: black"><i class='fa fa-envelope'></i></a></button></td>
		<td style="padding-left: 10px;padding-right: 10px"> 
			<button class="button"><a href=" {{ route('accounts.show', ['account' => $account->id]) }}"  style="text-decoration: none;color: black"><i class='fa fa-eye'></i></a></button></td>
	</tr>
	@endforeach
</table>
@endsection
