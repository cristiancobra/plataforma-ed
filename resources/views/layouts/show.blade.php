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

                <section id='white-page' class='white-page' style="margin-right:200px ">
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
                        <div class='show-label-large col'>
                            DESCRIÇÃO
                        </div>
                        <div class='description-field'>
                            @yield('description')
                        </div>
                    </div>

                    @yield('stock')

                    @yield('main')

                </section>

                @include('layouts.footer')

                @yield('createdAt')
            </div>
            </div>
        </main>

                <aside  id='workflow-container' class='fixed-top ms-auto text-center' style="
                      margin-top:15%;
                      border-style: solid;
                      border-right-style: none;
                      border-width: 1px;
                      border-radius: 10px 0px 0px 10px;
                      border-color: grey;
                      background-color: #D3D3D3;
                      width: 190px;
                      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                      ">
                    <div class='row pb-0 pt-3'>
                        <div class='col'>
                            <p style="font-size:22px">
                                FLUXO
                            </p>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col'>
                            @yield('workflow')
                        </div>
                    </div>
            </aside>
    </div>


    <script>
        $("#delete-button").click(function () {
            if (!confirm("Tem certeza que você quer apagar?")) {
                return false;
            }
        });
    </script>
    @yield('js-scripts')

</body>
</html>
