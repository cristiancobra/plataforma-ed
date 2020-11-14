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
		<div class="container">
			<div class="logo">
				<img src="{{$data['accountLogo']}}" height="50px" width="150px">
			</div>
			<div class="account">
				<p style="text-align: left">
					{{$data['accountEmail']}}
				</p>
				<p style="text-align: left">
					{{$data['accountPhone']}}
				</p>
				<p style="text-align: left">
					{{$data['accountAddress']}}
				</p>
				<p style="text-align: left">
					{{$data['accountAddressCity']}}
				</p>
				<p style="text-align: left">
					{{$data['accountAddressState']}}
				</p>
				<p style="text-align: left">
					{{$data['accountAddressCountry']}}
				</p>
			</div>
</div>

		<div class="main">
			<!-- Dados das empresa--> 
			<h2>
				{{$data['accountName']}}
			</h2>
			<p style="text-align: left">
				{{$data['invoiceId']}}
			</p>

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
	</body>
</html>