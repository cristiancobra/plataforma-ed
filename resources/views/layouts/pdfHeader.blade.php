<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
                <style>
            * {
                font-family: Nunito, helvetica, sans-serif;
            }

            .header2 {
                color:white;
                text-align: left;
                font-size: 25px;
                padding-top:0px;
                padding-left:25px;
                border-radius:20px;
                background-color: grey;
                height: 80px;
            }
        </style>
    </head>
    <body>
        <div class='header2' style="background-color:{{$data['accountPrincipalColor']}}">
            <p style="float:left">
                @if($data['invoiceIdentifier'] == 0)
                PROPOSTA
                @else
                FATURA {{$data['invoiceIdentifier']}}
                <br>
                <span style="font-size: 14px">Vencimento: {{date('d/m/Y', strtotime($data['invoicePayday']))}}</span>
                @endif
            </p>
            <img style='float:right;text-align: right' src='{{$data['accountLogo']}}' height='50px' width='150px'>
        </div>
    </body>
</html>