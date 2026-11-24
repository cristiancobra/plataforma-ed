<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <title> @yield('title') </title>

    @include('layouts.assets')

    @stack('scripts')

</head>

<body>

    <x-Navmenu.nav-menu />

    <div class="grid">
        <x-sidebar.sidebar />

        <main class='main2'>
            @yield('form_start')
            <header class='row pb-3'>
                {{-- Cabeçalho: título + atalhos (header_buttons, ex.: ir para a lista). Cancelar/Salvar ficam só no rodapé. --}}
                <div class="col-8" style="font-size: 32px">
                    <span style="font-size: 30px; margin-top: -7px; display: inline-block;">
                        @yield('image-top')
                    </span>
                    @yield('title')
                </div>
                <div class="col-4 gap-1 d-flex justify-content-end" style="text-align: right">
                    @yield('header_buttons')
                </div>
            </header>


            <div class='mx-5'>
                <x-alerts />
            </div>

            @yield('errors')


            <section id='white-page' class='white-page'>
                <div class='row mt-4'>
                    <div class='show-name col-8'>
                        @yield('name')
                    </div>
                    <div class='show-stage col-2' style='background-color:var(--principal-color, #874983);border-radius: 30px'>
                        @yield('priority')
                    </div>
                    <div class='show-stage col-2' style='background-color:var(--principal-color, #874983);border-radius: 30px'>
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


                        @hasSection('label9')
                            <div class='row'>
                                <div class="col-4 pe-0">
                                    <div class='show-label'>
                                        @yield('label9')
                                    </div>
                                </div>
                                <div class="col-8 ps-0">
                                    <div class='show-field-end'>
                                        @yield('content9')
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

                <div class="row mt-5">
                    @yield('main')
                </div>

                <div class="row mt-5">
                    @yield('images')
                </div>

                {{-- Cancelar/Salvar: uma única vez, no rodapé (depois dos anexos, quando houver) --}}
                @unless (View::hasSection('attachments'))
                    <div class='row mt-5 mb-5'>
                        <div class="col-12 d-flex justify-content-end gap-2">
                            @yield('buttons')
                        </div>
                    </div>
                @endunless
                </form>

                <div class="row mt-5">
                    @yield('attachments')
                </div>

                {{-- Cancelar/Salvar após os anexos (a página com anexos não os mostra antes) --}}
                @hasSection('attachments')
                    <div class='row mt-5 mb-5'>
                        <div class="col-12 d-flex justify-content-end gap-2">
                            @yield('buttons')
                        </div>
                    </div>
                @endif

                @yield('createdAt')
            </section>
    </div>
    </div>



    <script type="text/javascript">
        var deleteButton = document.getElementById('delete-button');
        if (deleteButton) {
            deleteButton.addEventListener('click', function (e) {
                if (!confirm('Tem certeza que você quer apagar?')) {
                    e.preventDefault();
                }
            });
        }
    </script>
    @yield('footer-scripts')
    </div>
    </div>
</body>

</html>
