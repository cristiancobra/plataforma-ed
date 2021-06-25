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

                    <div class='row' style='
                         margin-top: 10px;
                         margin-bottom: 15px;
                         margin-left:13px;
                         margin-right: 6px
                         '>
                        @include('layouts.header')
                    </div>

                    <div style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white;padding: 50px;margin: 20px;margin-top:0px'>
                        <div class='row' style='margin-top: -10px'>
                            <div class='show-name col-sm-8'>
                                @yield('name')
                            </div>
                            <div class='col-sm-2'>
                                @yield('priority')
                            </div>
                            <div class='col-sm-2'>
                                @yield('status')
                            </div>
                        </div>

                        <div class='row' style='margin-top: 40px'>
                            @yield('fieldsId')
                        </div>

                        <div class='row' style='margin-top: 50px'>
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

                        <div class='row' style='margin-top: 50px'>
                            <div class='show-label-large col-12'>
                                DESCRIÇÃO
                            </div>
                            <div class='description-field'>
                                @yield('description')
                            </div>
                        </div>

                        <div class='row' style='margin-top: 50px;margin-bottom: -5px'>
                            <div class='col-12 show-label-large'>
                                EXECUÇÃO
                            </div>
                        </div>
                        @yield('execution')

                        <div class='row' style='margin-top: 30px;text-align: right'>
                            <div class='col-12'style='text-align: right;padding-top: -10px'>
                                @yield('deleteButton')

                                @yield('extraButton')        
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
                    $("#delete-button").click(function () {
                        if (!confirm("Tem certeza que você quer apagar?")) {
                            return false;
                        }
                    });
                </script>
                @yield('js-scripts')
            </div>
        </div>
    </body>
</html>
