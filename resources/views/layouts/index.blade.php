<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body>

    <x-Navmenu.nav-menu/>

    <div class="grid">
        <x-sidebar.sidebar/>

        <main class='main2'>
            <header class='row pt-5 ps-5 pb-0'>
                @include('layouts.header')
            </header>

            <div class="col">
                @if(Session::has('failed'))
                <div class="alert alert-danger">
                    {{ Session::get('failed') }}
                    @php
                    Session::forget('failed');
                    @endphp
                </div>
                @endif

                <section id='white-page' class='white-page'>
                    <div class='row justify-content-end mt-3 mb-4 offset-2'>
                        @yield('shortcuts')
                    </div>

                    <div class="row mt-4 mb-3" id="filter_row">
                        <div class="col">
                            @yield('filter')
                        </div>
                        <div class="col-1">
                            <a id='filter_button' class='circular-button secondary'>
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                    @yield('table')

                    @include('layouts.footer')

                    @yield('createdAt')

            </div>
        </main>
        <script>
           
        </script>
    </div>
</div>
@yield('js-scripts')
</body>
</html>
