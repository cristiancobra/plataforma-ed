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
                    @if($data['invoiceIdentifier'] == 0)
                    PROPOSTA
                    @else
                <p style='font-size:22px'>
                    FATURA {{$data['invoiceIdentifier']}}
                    <br>
                    <span style='font-size: 14px'>Vencimento: {{date('d/m/Y', strtotime($data['invoicePayday']))}}</span>
                    @endif
                </p>
            </div>
            <div class='image-col'>
                <img class='image' src='{{public_path('/imagens/logo-empresa-digital.png')}}'>
            </div>
        </div>
    </body>
</html>