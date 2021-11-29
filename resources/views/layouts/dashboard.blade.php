<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body style='width:100%;overflow-x: hidden'>

    <x-Navmenu.nav-menu/>

    <x-sidebar.sidebar/>

    <div class="row"style='
         margin-top: 55px;
         margin-left: 120px;
         background-color: #EEEEEE;
         min-height: 100vh;
         '>
        <div class="col">
            <div id='white-page' class='container mt-5 mb-5 px-5 pt-3 pb-5' style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white'>
                @yield('main')
            </div>
        </div>
    </div>
    @yield('js-scripts')
</body>
</html>
