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
            <div class='row' style='background-color: #EEEEEE'>
                @include('layouts.sidebar')
                <main role='main' class='offset-2 col-10 ml-sm-auto px-2' style='background-color: #EEEEEE'>

                    <div class='row' style='
                         margin-top: 10px;
                         margin-bottom: 15px;
                         margin-left:13px;
                         margin-right: 6px
                         '>
                        @include('layouts.header')
                    </div>

                    <div style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white;padding: 20px;margin: 20px;margin-top:10px'>
                        <div class='col-lg-12 px-2'>
                            @yield('main')
                        </div>
                    </div>
                </main>
            </div>
            @yield('js-scripts')
        </div>
    </body>
</html>
