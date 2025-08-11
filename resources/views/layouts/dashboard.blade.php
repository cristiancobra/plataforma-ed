<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body>

    <x-Navmenu.nav-menu/>
    
    <div class="grid">
    <x-sidebar.sidebar/>

    <main class='main2'>
            <section id='white-page' class='white-page'>
                @yield('main')
            </section>
    </main>
    </div>
    @yield('js-scripts')
</body>
</html>
