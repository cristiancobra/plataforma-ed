<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('page_name')</title>

        @include('layouts.assets')

    </head>
    <body>
        @yield('errors')

        @yield('banner')

        @yield('value_offer')
        
        @yield('about')

        @yield('strengths')		

        @yield('competitor_advantages')

        @yield('how-it-works')

        @yield('shop')

        @yield('form')

        @yield('js-scripts')
    </body>
</html>



