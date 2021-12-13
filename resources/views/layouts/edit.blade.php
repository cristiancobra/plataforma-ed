<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('title') </title>

        @include('layouts.assets')
    
    @stack('scripts')

    </head>
    <body>

    <x-Navmenu.nav-menu/>

    <div class="grid">
        <x-sidebar.sidebar/>

        <main class='main2'>
            @yield('form_start')
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
                    <div class='row mt-4'>
                        <div class='show-name col-8'>
                            @yield('name')
                        </div>
                        <div class='show-stage col-2' style='background-color:#c28dbf;border-radius: 30px'>
                            @yield('priority')
                        </div>
                        <div class='show-stage col-2' style='background-color:#c28dbf;border-radius: 30px'>
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

                    <div class='row mt-5'>
                        <div class='show-label-large col'>
                            DESCRIÇÃO
                        </div>
                        <div class='description-field'>
                            @yield('description')
                        </div>
                    </div>

                    @yield('stock')

                    @yield('main')

                    </form>
                </section>

                @include('layouts.footer')

                @yield('createdAt')
            </div>
    </div>



    <script type="text/javascript">
        $("#delete-button").click(function () {
            if (!confirm("Tem certeza que você quer apagar?")) {
                return false;
            }
        });
    </script>
    @yield('footer-scripts')
</div>
</div>
</body>
</html>
