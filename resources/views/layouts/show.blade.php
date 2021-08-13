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

                    <div class='row' style='
                         margin-top: 10px;
                         margin-bottom: 15px;
                         margin-left:13px;
                         margin-right: 6px
                         '>
                        @include('layouts.header')
                    </div>

                    @if(Session::has('failed'))
                    <div class="alert alert-danger">
                        {{ Session::get('failed') }}
                        @php
                        Session::forget('failed');
                        @endphp
                    </div>
                    @endif

                    <div id='white-page'  class='container' style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white'>
                        <div class='row mt-4'>
                            <div class='show-name col-8'>
                                @yield('name')
                            </div>
                            <div class='show-stage col-2'>
                                @yield('priority')
                            </div>
                            <div class='show-stage col-2'>
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

                        @yield('main')

                        @include('layouts.footer')

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
