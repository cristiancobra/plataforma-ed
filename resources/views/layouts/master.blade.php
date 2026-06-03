<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('title') </title>

    @include('layouts.assets')

</head>

<body>

    <x-Navmenu.nav-menu />

    <div class="grid">
        <x-sidebar.sidebar />

        <main role="main" class="main2">
            <header class='row pb-3'>
                @include('layouts.header')
            </header>

            <section id="white-page" class="white-page">
                <div class="col-lg-12 px-2">
                    @yield('main')
                </div>
            </section>
        </main>
    </div>
    @yield('js-scripts')
    @stack('scripts')
</body>

</html>
