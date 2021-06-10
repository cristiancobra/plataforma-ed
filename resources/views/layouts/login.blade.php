<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body style='background-color: #c28dbf'>

        @include('layouts.navMenu')

        <div class='container-fluid'>
            <div class='row'>
                <main role='main' class='col-lg-12 px-4'>
                    @yield('main')
                </main>
            </div>
            @yield('js-scripts')
        </div>
    </body>
</html>
