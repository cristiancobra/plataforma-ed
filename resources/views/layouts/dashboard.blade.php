<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body>

        @include('layouts.navMenu')

        <div class='container-fluid'>
            <div class='row' id='background-gray' style='background-color: #EEEEEE'>
                @include('layouts.sidebar')
                <main role='main' class='row offset-2 col-10 ps-3 pe-1 mt-3' id='whitepaper' style='background-color: #EEEEEE'>

                    <div class='row ps-4 pt-4 ' style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white'>
                        @yield('main')
                    </div>
                </main>
            </div>
            @yield('js-scripts')
        </div>
    </body>
</html>
