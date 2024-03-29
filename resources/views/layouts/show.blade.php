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
                <div class="alert alert-danger ms-5 mt-5 mb-5">
                    <i class="fas fa-exclamation-circle late-paid ms-1 me-1" style="font-size:20px"></i>
                    {{ Session::get('failed') }}
                    @php
                    Session::forget('failed');
                    @endphp
                </div>
                @elseif(Session::has('success'))
                <div class="alert alert-success ms-5 mt-5 mb-5">
                    <i class="fas fa-check-circle paid ms-1 me-1" style="font-size:20px"></i>
                    {{ Session::get('success') }}
                    @php
                    Session::forget('success');
                    @endphp
                </div>
                @endif


                <section id='white-page' class='white-page' style="margin-right:200px ">
                    <div id="app">
                        <div class='row d-flex mt-4'>
                            <div class='show-name col-8'>
                                @yield('name')
                            </div>
                            <div class='col-2'>
                                <div-priority :priority="{{json_encode($priority)}}" />
                            </div>
                            <div class='col-2'>
                                <div-status :status="{{json_encode($status)}}" />
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


@yield('js-scripts')

</body>
</html>
