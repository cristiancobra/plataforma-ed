<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

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
            <header class='row' style='
                    padding-left: 30px;
                    padding-top: 10px;
                    padding-bottom: 15px;
                    '>
                @include('layouts.header')
            </header>

                    <div id='white-page' class='container mt-0 mb-5 px-5 pt-3' style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white'>
                        <div class='row justify-content-end mt-3 mb-4 offset-2'>
                            @yield('shortcuts')
                        </div>

                        <div class="row mt-4 mb-3" id="filter_row" style="display: none">
                            <div style="text-align:right">
                                @yield('filter')
                            </div>
                        </div>

                        @yield('table')

                        @include('layouts.footer')

                        @yield('createdAt')

                    </div>
                </main>
                <script>
                    // botão do filtro
                    $(document).ready(function () {
                        console.log('filter button')
                        //botao de exibir filtro
                        $('#filter_button').click(function () {
                            $('#filter_row').slideToggle(600);
                        });

                    });
                </script>
            </div>
        </div>
        @yield('js-scripts')
    </body>
</html>
