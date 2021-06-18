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
                <main role='main' class='offset-2 col-10 ml-sm-auto px-2' style='background-color: #EEEEEE'>

                    <div class='row mt-2 mb-2' style='
                         margin-left:13px;
                         margin-right: 6px
                         '>
                        @include('layouts.header')
                    </div>

                    <div class='mx-3 px-5 pt-3' style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white'>
                        <div class='row justify-content-end' style='margin-bottom: -5px'>
                            @yield('shortcuts')
                        </div>

                        <div class="row mt-4 mb-3" id="filter-row">
                            <div style="text-align:right">
                                @yield('filter')
                            </div>
                        </div>

                        @yield('table')

                        <div class="row mt-3 mb-1">
                            <p>
                                {{$tasks->links()}}
                            </p>
                        </div>

                        <div class='row mt-1 mb-5' style='text-align: right'>
                            <div class='col-12'style='text-align: right;padding-top: -10px'>
                                <form   style='text-decoration: none;color: black;display: inline-block' action='@yield('deleteButton')' method='post'>
                                    @csrf
                                    @method('delete')
                                    <button id='' class='circular-button delete' style='border:none;padding-left:7px;padding-top: -2px' "type='submit'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                                <a class='circular-button secondary' href='@yield('editButton')'>
                                    <i class='fa fa-edit'></i>
                                </a>
                                <a class='circular-button primary'  href='@yield('backButton')'>
                                    <i class='fas fa-arrow-left'></i>
                                </a>
                            </div>
                        </div>

                        @yield('createdAt')

                    </div>
                </main>
                <script>
                    $(document).ready(function () {
                        console.log('executing js here..')
                        //botao de exibir filtro
                        $('#filter_button').click(function () {
                            $('#filter').slideToggle(600);
                        });

                    });
                </script>
            </div>
        </div>
        @yield('js-scripts')
    </body>
</html>
