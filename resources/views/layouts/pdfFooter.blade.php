<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <style>
            * {
                font-family: Nunito, helvetica, sans-serif;
            }

            
            .footer {
                color:white;
                text-align: center;
                font-size: 12px;
                padding:5px;
                border-radius:20px;
                background-color: grey;
                margin-bottom: 15px;
                line-height: 1.7;
            }
        </style>
    </head>
    <body>
        <div class="footer" style="background-color: {{$data['accountPrincipalColor']}}">
            CNPJ: {{formatCnpj($data['companyCnpj'])}}
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            EMAIL:{{$data['email']}}
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            TEL:{{phoneBr($data['phone'])}}
            <br>
            {{$data['address']}}   -   
            {{$data['city']}} / 
            {{$data['state']}}
            <br>
        </div>
    </body>
</html>
