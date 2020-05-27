<?php

use App\User;
use App\LoginTesteController;
?>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Empresa Digital</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <script type="text/javascript" src="<?php echo asset('js/teste.js') ?>"></script>

    </head>
    <body>
        <div>

            @include ('menu-plataforma'); 

        </div>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div style="float: left">
                <!-- Use any element to open the sidenav -->
                <span onclick="openNav()">open</span>
            </div>
            <div class="main" style="float: left; width: 100vw; height: 100vh">
                <iframe src='http://crm.empresadigital.net.br' width='100%' height='100%' border="0px"></iframe>
            </div>
    </body>
</html>
