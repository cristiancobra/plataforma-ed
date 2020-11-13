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
		<div style="padding: 0;margin-top: -50px; margin-left: -50px;background-color:#874983;width: 115%;height: 100px;position: absolute">
			<div class="header">
				<h1 style="padding: 0px;margin-bottom: -2px">
					proposta comercial
				</h1>
			</div>
			<div class="image-header">
				<br>
				<br>
				<img src= "{{ asset('imagens/invoice.png') }}"  width="50px" height=50px">
			</div>
		</div>


			<div class="main">
				<p>
					Dono: {{$data['invoiceName']}}
				</p>
				te
				t
				ert
				etertert
			</div>
	</body>
</html>