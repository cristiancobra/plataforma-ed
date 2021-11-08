<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body>

        @include('layouts.navMenu')

        <div class='container-fluid'>
            <div class='row' style='background-color: #EEEEEE'>
                @include('layouts.sidebar')
                <main role='main' class='offset-2 col-10 ml-sm-auto px-4' style='background-color: #EEEEEE'>

                        @include('layouts.header')

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
