<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <title> @yield('title') </title>

    @include('layouts.assets')

</head>

<body>

    <x-Navmenu.nav-menu />

    <div class="grid">
        <x-sidebar.sidebar />

        <main class='main2'>
            <header class='row pb-3'>
                @include('layouts.header')
            </header>

            <div class="col">
                <x-alerts />

                <section id='white-page' class='white-page'>
                    <div class='row justify-content-end mt-3 mb-4 offset-2'>
                        @yield('shortcuts')
                    </div>

                    @yield('filter')


                    @yield('table')
                    @yield('pagination')

                    {{-- Rodapé da listagem: só paginação (os botões ficam apenas no topo) --}}
                    <div class='row mt-5 mb-5 align-items-center'>
                        <div class="col-12 d-flex justify-content-center justify-content-md-start">
                            @yield('paginate')
                        </div>
                    </div>

                    @yield('createdAt')
                </section>
            </div>
        </main>
    </div>
    @yield('js-scripts')
    @stack('scripts')
</body>

</html>
