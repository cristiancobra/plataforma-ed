<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        @include('layouts.assets')
    </head>
    <body>
        <div class="grid-invoice">

            <div class="header">
                <div style="display: inline-block">
                    <h1 style="padding: 0px;margin-bottom: -2px">
                        @yield('title')
                    </h1>
                </div>
                <div style="display: inline-block">
                    <img src= @yield('image-top') width="70px" height="70px">
                </div>
            </div>



            <div class="main">
                @yield('main')
            </div>
        </div>
    </body>
</html>
