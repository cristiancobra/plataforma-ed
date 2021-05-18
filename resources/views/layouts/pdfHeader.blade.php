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
                text-align: center;
                font-size: 25px;
                padding:1px;
                border-radius:20px;
                background-color: grey;
                margin-top: 0px;
            }
        </style>
    </head>
    <body>
        <div class='header2' style="background-color:{{$data['accountPrincipalColor']}}">
            <p>
                FATURA {{$data['invoiceIdentifier']}}
                <br>
                <span style="font-size: 18px">Vencimento: {{date('d/m/Y', strtotime($data['invoicePayday']))}}</span>
            </p>            
            <img style='float: right' src='{{$data['accountLogo']}}' height='50px' width='150px'>
        </div>
    </body>
</html>