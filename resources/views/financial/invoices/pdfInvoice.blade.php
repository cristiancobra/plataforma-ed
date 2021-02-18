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
					{{$data['accountAddressCity']}} / 
					{{$data['accountAddressState']}}
					<br>
					CNPJ: {{$data['accountCnpj']}}
				</td>
				<td class="image-header">
					FATURA {{$data['invoiceIdentifier']}}
					<br>
					<br>
					VENCIMENTO
					<br>
					{{ date('d/m/Y', strtotime($data['invoicePayday'])) }}
				</td>
			</tr>
		</table>

		<div>
			<h4>
				<br>
				PARA:
			</h4>
			<!-- Dados do cliente--> 
			<p style="text-align: left">
				{{$data['customerName']}}
				<br>
				{{$data['companyName']}}
				@if(isset($data['companyCnpj']))
				<br>
				cnpj: {{$data['companyCnpj']}}
				@endif
				@if(isset($data['companyEmail']))
				<br>
				{{$data['companyEmail']}}
				@endif
				@if(isset($data['companyPhone']))
				<br>
				{{$data['companyPhone']}}
				@endif
				@if(isset($data['companyAddress']))
				<br>
				{{$data['companyAddress']}}
				<br>
				{{$data['companyCity']}} / 
				{{$data['companyState']}} -
				{{$data['companyCountry']}}
				@endif
			</p>
		</div>
		<br>
		<h4>
			DESCRIÇÃO:
		</h4>
		<p style="text-align: left;margin-top: 0px;">
			{!!html_entity_decode($data['opportunityDescription'])!!}
		</p>
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
		<table  class="table-list" style="width: 100%;text-align:left">
			<tr>
				<td>
					<h4>
						OBSERVAÇÕES:
					</h4>
					<p>
						{!!html_entity_decode($data['invoiceDescription'])!!}
					</p>
					<br>
					<hr>
				</td>
			</tr>
			<tr>
				<td>
					<h4 style="margin-bottom: 0px">
						FORMAS DE PAGAMENTO:
					</h4>
				</td>
			</tr>
			<tr>
				<td>
					<p>
						À  VISTA: por boleto ou transferência bancária
						<br>
						PARCELADO: no cartão de crédito em até 12x
						<br>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<h4 style="margin-bottom: 0px">
						DADOS PARA PAGAMENTO:
					</h4>
				</td>
			</tr>
			@foreach ($data['bankAccounts'] as $bankAccount)
			<tr>
				<td>
					<p>
						{{$bankAccount->name}} - {{$bankAccount->bank_code}}
						<br>
						Agência: {{$bankAccount->agency}}
						<br>
						Conta: {{$bankAccount->account_number}}
						<br>
						CNPJ: {{$data['accountCnpj']}}
					</p>
				</td>
			</tr>
			@endforeach			
		</table>
		<br>
		<br>
	</body>
</html>