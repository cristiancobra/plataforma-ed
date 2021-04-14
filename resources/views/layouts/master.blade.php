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
            <div class='row' style='background-color: #c28dbf'>
                @include('layouts.sidebar')
                <main role='main' class='col-md-9 ml-sm-auto col-lg-10 px-4' style='background-color: #EEEEEE'>

                    <div class='row' style='margin-top: 10px'>
                        @include('layouts.header')
                    </div>

                    <div style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white;padding: 20px;margin: 20px;margin-top:10px'>
                        <div class='col-lg-12'>
                            @yield('main')
                        </div>
                        @yield('js-scripts')
                    </div>
            </div>
        </div>

    </main>
    @yield('js-scripts')
</div>
</div>
</body>
</html>
