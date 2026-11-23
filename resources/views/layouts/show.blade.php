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


                <section id='white-page' class='white-page' style="margin-right:200px ">
                    <div id="app">
                        <div class='row d-flex mt-4'>
                            <div class='col-8'>
                                <h2 class="fw-bold" style="color: {{ $principalColor }}">
                                    @yield('name')
                                </h2>
                            </div>
                            <div class='col-2'>
                                <div-priority :priority="{{ isset($priority) ? json_encode($priority) : 'null' }}" />
                            </div>
                            <div class='col-2'>
                                <div-status :status="{{ isset($status) ? json_encode($status) : 'null' }}" />
                            </div>
                        </div>

                    </div>


                    <div class='row' style='margin-top: 40px'>
                        @yield('fieldsId')
                    </div>

                    <div class='row mt-5'>
                        <div class='col-4' style='text-align: center'>
                            @yield('date_start')
                        </div>
                        <div class='col-4'>
                            @yield('date_due')
                        </div>
                        <div class='col-4'>
                            @yield('date_conclusion')
                        </div>
                    </div>

                    <div class='row mt-5'>
                        <h4 class="mb-3 fw-bold" style="color: {{ $principalColor }}">
                            DESCRIÇÃO
                        </h4>
                        <div class="border rounded p-3 bg-light">
                            @yield('description')
                        </div>
                    </div>
                    @yield('images')
                    @yield('stock')
                    @yield('main')
                    @yield('attachments')
                </section>
                @include('layouts.footer')
                @yield('createdAt')
            </div>
    </div>
    </main>

    </div>


    @yield('js-scripts')

</body>

</html>
