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

                <div class='row mt-5'>
                    <!--FIELDS  column-->
                    <div class="col-5">

                        @hasSection('label1')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label1')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content1')
                                </div>
                            </div>                                
                        </div>
                        @endif


                        @hasSection('label2')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label2')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content2')
                                </div>
                            </div>                                
                        </div>
                        @endif


                        @hasSection('label3')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label3')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content3')
                                </div>
                            </div>                                
                        </div>
                        @endif


                        @hasSection('label4')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label4')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content4')
                                </div>
                            </div>                                
                        </div>
                        @endif


                        @hasSection('label5')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label5')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content5')
                                </div>
                            </div>                                
                        </div>
                        @endif


                        @hasSection('label6')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label6')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content6')
                                </div>
                            </div>                                
                        </div>
                        @endif


                        @hasSection('label7')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label7')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content7')
                                </div>
                            </div>                                
                        </div>
                        @endif


                        @hasSection('label8')
                        <div class='row'>
                            <div class="col-4 pe-0">
                                <div class='show-label'>
                                    @yield('label8')
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class='show-field-end'>
                                    @yield('content8')
                                </div>
                            </div>                                
                        </div>
                        @endif


                    </div>
                    <!--fim da coluna  Fields-->

                    <div class='col-7'>
                        <div class='row mt-4'>

                            @hasSection('date_start')
                            <div class='col' style='text-align: center'>
                                @yield('date_start')
                            </div>
                            @endif

                            @hasSection('date_due')
                            <div class='col'>
                                @yield('date_due')
                            </div>
                            @endif

                            @hasSection('date_conclusion')
                            <div class='col'>
                                @yield('date_conclusion')
                            </div>
                            @endif
                        </div>
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
            </form>

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
