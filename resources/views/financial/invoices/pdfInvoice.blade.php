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
					{{$data['accountAddressCity']}}
					<br>
					{{$data['accountAddressState']}}
					<br>
					{{$data['accountAddressCountry']}}
					<br>
					CNPJ: {{$data['accountCnpj']}}
				</td>
				<td class="image-header">
					FATURA {{$data['invoiceId']}}
					<br>
					<br>
					VENCIMENTO
					<br>
					{{ date('d/m/Y', strtotime($data['invoicePayday'])) }}
				</td>
			</tr>
		</table>

		<div>

			<h3>
				<br>
				PARA:
			</h3>

			<!-- Dados do cliente--> 
			<p style="text-align: left">
				{{$data['customerName']}}
			</p>
			<p style="text-align: left">
				{{$data['customerEmail']}}
			</p>
			<p style="text-align: left">
				{{$data['customerPhone']}}
			</p>
			<p style="text-align: left">
				{{$data['customerAddress']}}
			</p>
			<p style="text-align: left">
				{{$data['customerAddressCity']}}
			</p>
			<p style="text-align: left">
				{{$data['customerAddressState']}}
			</p>
			<p style="text-align: left">
				{{$data['customerAddressCountry']}}
			</p>
		</div>
		<br>
		<table  class="table-list" style="width: 100%">
			<tr>
				<td class="table-list-header" style="width: 10%">
					QTDE
				</td>
				<td   class="table-list-header" style="width: 60%">
					NOME
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
				<td class="table-list-left" colspan="5">
			{!!html_entity_decode($invoiceLine->product->description)!!}
				</td>
			</tr>
			@endforeach

			<tr>
				<td   class="table-list-header-right" colspan="2"></td>
				<td   class="table-list-header-right" style="font-size: 14px">
					desconto: 
				</td>
				<td   class="table-list-header-right" style="font-size: 14px" colspan="2">
					<b>- {{number_format($data['invoiceDiscount'], 2,",",".") }}</b>
				</td>
			</tr>
			<tr>
				<td   class="table-list-header-right" colspan="2">
				<td   class="table-list-header-right"  style="font-size: 14px">
					TOTAL: 
				</td>
				</td>
				<td   class="table-list-header-right"   style="font-size: 14px" colspan="2">
					<b>R$ {{number_format($data['invoiceTotalPrice'], 2,",",".") }}</b>
				</td>
			</tr>
		</table>
		<table  class="table-list" style="width: 100%">
			<tr>
				<td>
					<h4>
						FORMAS DE PAGAMENTO:
					</h4>
					<p>
						À  VISTA: por boleto ou transferência bancária
						<br>
						PARCELADO: no cartão de crédito em até 12x
						<br>
					</p>
				</td>
				<td style="text-align: center">
					<h4>
						DADOS PARA PAGAMENTO:
					</h4>
					<p>
						Banco Inter
						<br>
						Agência: 0001
						<br>
						Conta: 2303763-6
						<br>
						CNPJ: {{$data['accountCnpj']}}
					</p>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<div>
			<h3>
				OBSERVAÇÕES:
			</h3>
			<p>
				{!!html_entity_decode($data['invoiceDescription'])!!}
			</p>
		</div>

	</body>
</html>