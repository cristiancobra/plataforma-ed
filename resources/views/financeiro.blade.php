<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Empresa Digital</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo asset('css/style.css')?>" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

        <!-- Styles -->
        <style>
        </style>
    </head>
    <body>
        <div>
  @include ('menu-plataforma'); 
   </div>
    <div class="content">
        <iframe src='http://financeiro.empresadigital.net.br' width='100%' height='100%'></iframe>
       </div>
    </body>
    </body>
</html>
