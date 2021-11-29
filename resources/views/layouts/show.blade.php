<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body style='width:100%;
          overflow-x: hidden;
          '>
    <x-Navmenu.nav-menu/>

    <x-sidebar.sidebar/>


    <div class="row" id='mainframe' style='
         margin-top: 55px;
         margin-left: 120px;
         background-color: #EEEEEE;
         min-height: 100vh;
         '>
        <header class='row' style='
                padding-left: 30px;
                padding-top: 10px;
                padding-bottom: 15px;
                '>
            @include('layouts.header')
        </header>

        <div class="col-10">
            @if(Session::has('failed'))
            <div class="alert alert-danger">
                {{ Session::get('failed') }}
                @php
                Session::forget('failed');
                @endphp
            </div>
            @endif

            <section id='white-page' class='container ms-3 me-3' style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white'>
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

        <section  id='workflow' class='col-2 ps-3 pe-4 text-center'>
            <div  id='workflow-container' class='conteiner' style="
                  border-style: solid;
                  border-width: 1px;
                  border-radius: 10px;
                  border-color: grey;
                  background-color: #D3D3D3;
                  position: fixed;
                  width: 200px;
                  ">
                <div class='row mb-3'>
                    <div class='col'>
                        <p style="font-size:26px">
                            FLUXO
                        </p>
                    </div>
                </div>
                <div class='row mb-3'>
                    <div class='col'>
                        @yield('workflow')
                    </div>
                </div>
            </div>
        </section>
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
