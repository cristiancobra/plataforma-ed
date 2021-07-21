<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('page_name')</title>

        @include('layouts.assets')

    </head>
    <body>
        @yield('banner')

        @yield('text1')

        @yield('text2')

        @yield('form')

        @yield('js-scripts')
    </body>
</html>



