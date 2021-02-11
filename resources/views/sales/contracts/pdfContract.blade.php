<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Fonts -->

		<!-- Styles -->
		<link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    </head>
    <body>
		<table>
			<tr>
				<td class="logo">
					<img src="{{$data['accountLogo']}}" height="50px" width="150px">
				</td>
				<td class="account">
					{{$data['accountEmail']}}
					<br>
					{{$data['accountPhone']}}
					<br>
					{{$data['accountAddress']}}
					<br>
					{{$data['accountCity']}} / 
					{{$data['accountState']}}
					<br>
					CNPJ: {{$data['accountCnpj']}}
				</td>
				<td class="image-header">
					CONTRATO {{$data['contractId']}}
					<br>
					<br>
					VENCIMENTO
					<br>
					{{ date('d/m/Y', strtotime($data['contractDateDue'])) }}
				</td>
			</tr>
		</table>
		<h2 style="text-align: center">
			{{$data['contractName']}}
		</h2>
		<br>
		<h3 style="text-align: center">
			Objeto do contrato
		</h3>
		<p>
			1. É objeto deste contrato o/a {{$data['contractName']}} nos termos aqui descritos.
		</p>
		<br>
		<h3 style="text-align: center">
			Identificação das partes
		</h3>
		<p>
			2. São partes deste contrato a empresa contratada 
			<span class="labels">{{$data['accountName']}}</span>
			inscrita no CNPJ sob o nº
			<span class="labels">{{$data['accountCnpj']}}</span>.
			Localizada na
			<span class="labels">{{$data['accountAddress']}}</span>,
			em
			<span class="labels">{{$data['accountCity']}}</span>,
			–
			<span class="labels">{{$data['accountState']}}</span>,
			CEP
			<span class="labels">{{$data['accountZipCode']}}</span>,
			representada por
			<span class="labels">{{$data['userName']}}</span>,
			inscrito no CPF sob o nº
			<span class="labels">{{$data['userCpf']}}</span>,
			residente em
			<span class="labels">{{$data['userAddress']}}</span>,
			em
			<span class="labels">{{$data['userCity']}}</span>,
			/
			<span class="labels">{{$data['userState']}}</span>,
			CEP:
			<span class="labels">{{formatZipCode($data['userZipCode'])}}</span> e,
		</p>
		<p>
			a empresa contratante
			<span class="labels">{{$data['companyName']}}</span>
			inscrita no CNPJ sob o nº
			<span class="labels">{{$data['companyCnpj']}}</span>.
			Localizada na
			<span class="labels">{{$data['companyAddress']}}</span>,
			em
			<span class="labels">{{$data['companyCity']}}</span>,
			–
			<span class="labels">{{$data['companyState']}}</span>,
			CEP
			<span class="labels">{{$data['companyZipCode']}}</span>,
			representada por
			<span class="labels">{{$data['contactName']}}</span>,
			inscrito no CPF sob o nº
			<span class="labels">{{$data['contactCpf']}}</span>,
			residente em
			<span class="labels">{{$data['contactAddress']}}</span>,
			em
			<span class="labels">{{$data['contactCity']}}</span>,
			/
			<span class="labels">{{$data['contactState']}}</span>,
			CEP:
			<span class="labels">{{formatZipCode($data['contactZipCode'])}}</span>.
		</p>
		<br>
		<h3 style="text-align: center">
			Serviços/produtos contratados
		</h3>
		<p>
			3. Os produtos/serviços contratados e suas especificidades são:
		</p>
		<br>
		<table  class="table-list" style="width: 100%">
			<tr>
				<td class="table-list-header" style="width: 10%">
					QTDE
				</td>
				<td   class="table-list-header" style="width: 50%">
					NOME
				</td>
				<td   class="table-list-header" style="width: 10%">
					ENTREGA
				</td>
				<td   class="table-list-header" style="width: 10%">
					IMPOSTO
				</td>
				<td   class="table-list-header" style="width: 10%">
					UNITÁRIO
				</td>
				<td   class="table-list-header" style="width: 10%">
					TOTAL
				</td>
			</tr>

			@foreach ($data['invoiceLines'] as $invoiceLine)
			<tr style="font-size: 14px; width: 10%; text-align: center">
				<td class="table-list-center">
					{{ $invoiceLine->amount }}
				</td>
				<td class="table-list-left">
					{{ $invoiceLine->product->name}}
				</td>
				<td class="table-list-center">
					{{$invoiceLine->amount * $invoiceLine->product->due_date}} dia(s)
				</td>
				<td class="table-list-right">
					{{ number_format($invoiceLine->subtotalTax_rate, 2,",",".") }}
				</td>
				<td class="table-list-right">
					{{ number_format($invoiceLine->product->price,2,",",".") }}
				</td>
				<td class="table-list-right">
					{{ number_format($invoiceLine->subtotalPrice,2,",",".") }}
				</td>
			</tr>
			<tr style="font-size: 12px">
				<td class="table-list-left" colspan="6">
					{!!html_entity_decode($invoiceLine->product->description)!!}
				</td>
			</tr>
			@endforeach

			<tr>
				<td   class="table-list-header-right" style="font-size: 14px" colspan="4">
					desconto: 
				</td>
				<td   class="table-list-header-right" style="font-size: 14px" colspan="2">
					- {{formatCurrencyReal($data['invoiceDiscount'])}}
				</td>
			</tr>
			<tr>
				<td   class="table-list-header-right"  style="font-size: 14px" colspan="4">
					TOTAL: 
				</td>
				<td   class="table-list-header-right"   style="font-size: 14px" colspan="2">
					 {{formatCurrencyReal($data['invoiceTotalPrice'])}}
				</td>
			</tr>
			<tr>
				<td   class="table-list-header-right" colspan="4">
					PARCELAMENTO: 
				</td>
				<td   class="table-list-header-right" colspan="2">
					@if($data['invoiceNumberInstallmentTotal'] == 1)
					À vista
					@else
					{{$data['invoiceNumberInstallmentTotal']}} x  {{formatCurrencyReal($data['invoiceInstallmentValue'])}}
					@endif
				</td>
			</tr>
		</table>
		<p style="text-align: left;margin-top: 0px;">
			{!!html_entity_decode($data['contractText'])!!}
		</p>
		<br>
		<br>
		<br>
		<p style="text-align: center">
			Assinam esse contrato no dia {{date('d/m/Y', strtotime($data['contractDateStart']))}}
		</p>
		<br>
		<br>
		<div style="text-align: center;width: 100%">
			<div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
				<p style="text-align: center">
					<br>
					______________________________________
					<br>
					<span class="labels">{{$data['userName']}}</span> - <span class="labels">{{$data['accountName']}}</span>
					<br>
					contratada
				</p>
			</div>
			<div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
				<p style="text-align: center">
					______________________________________
					<br>
					<span class="labels">{{$data['contactName']}}</span> - <span class="labels">{{$data['companyName']}}</span>
					<br>
					contratante
				</p>
			</div>
		</div>
		<br>
		<br>
		<div style="text-align: center;width: 100%">
			<div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
				<p style="text-align: center">
					______________________________________
					<br>
					<span class="labels">{{$data['contractWitness1']}}</span> - testemunha 1
				</p>
			</div>
			<div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
				<p style="text-align: center">
					______________________________________
					<br>
					<span class="labels">{{$data['contractWitness2']}}</span> - testemunha 2
				</p>
			</div>
		</div>
		<br>
	</body>
</html>