<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Empresa Digital</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo asset('css/style.css') ?>" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">


    </head>
    <body>

        @include ('menu-plataforma'); 

        <div class="content">
            <iframe src='https://crm.empresadigital.net.br/index.php?module=Emails&action=index&parentTab=Colabora%C3%A7%C3%A3o' width='100%' height='100%' border="0px"></iframe>
        </div>
    </body>
</html>
