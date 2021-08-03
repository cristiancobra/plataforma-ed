<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <style>
            * {
                font-family: Nunito, helvetica, sans-serif;
            }
            .container {
                color:white;
                padding-top: 1px;
                padding-left: 20px;
                vertical-align: top;
                height:100px;
                border-radius: 20px;
                background-color: grey;
            }
            .text-col {
                color:white;
                float:left;
                font-weight: 800;
                width: 75%;
            }
            .image-col {
                text-align: center;
                float:left;
                height: 50px;
                width: 150px;
            }
            .image {
                text-align: right;
                float:right;
                top:0px;
                left:0px;
                width:150px;
                height:50px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container' style='background-color:{{$data['accountPrincipalColor']}}'>
            <div class='text-col'>
                <p style='font-size:28px'>

                    @switch($data['pdfTitle'])
                    @case('ORÇAMENTO')
                    ORÇAMENTO
                    <br>
                    <span style='font-size: 14px'>Data: {{date('d/m/Y', strtotime($data['invoicePayday']))}} - proposta válida por {{$data['invoiceExpirationDate']}} dias</span>
                    @break

                    @case('FATURA')
                <p style='font-size:22px'>
                    FATURA {{$data['invoiceIdentifier']}}
                    <br>
                    <span style='font-size: 14px'>Vencimento: {{date('d/m/Y', strtotime($data['invoicePayday']))}}</span>
                    @break

                    @case('CONTRATO')
                    @if($data['contractIdentifier'] > 0)
                <p style='font-size:14px;margin-top:-10px'>
                    CONTRATO {{$data['contractIdentifier']}}
                    <br>
                    <span style='font-size: 22px'>{{$data['contractName']}}</span>
                    @else
                <p style='font-size:28px'>
                    MINUTA DE CONTRATO
                    @endif
                    @break

                    @case('RELATÓRIO DE PRODUÇÃO')
                <p style='font-size:32px'>
                    RELATÓRIO DE PRODUÇÃO
                    <br>
                    @break

                    @default
                <p style='font-size:22px'>
                    Não possui título
                    @endswitch     
                </p>
            </div>
            <div class='image-col'>
                <img class='image' src='{{public_path($data['accountLogo'])}}'>
            </div>
        </div>
    </body>
</html>