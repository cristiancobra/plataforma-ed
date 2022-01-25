<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body style='background-color: white'>


        @if(Session::has('failed'))
        <div class='alert alert-danger'>
            {{ Session::get('failed') }}
            @php
            Session::forget('failed');
            @endphp
        </div>
        @endif

        <!--        banner  -->
        <div class='container-fluid m-0 p-0 w-100'>
            @if($shop->banner)
            <div class='row pt-5' style='
                 height:140px;
                 background-image: url({{asset($shop->banner->path)}});
                 background-size: cover;
                 background-position: center;
                 background-repeat: no-repeat;
                 '>
            </div>
            @else
            <div class="row d-flex justify-content-center" style="
                 height: 140px;
                 align-items: center;
                 opacity: 0.8;
                 background-color: {{$principalColor}};
                 overflow: hidden;

                 ">
                <p style="
                   color: {{$oppositeColor}};
                   text-align: center;
                   font-size: 32px;
                   ">
                    {{$shop->headline}}
                </p>
            </div>
            @endif
        </div>


        <!--principal-->
        <div class='container'>
            <div class='row' style='margin-top: 40px'>
                <div class='col-6 ps-5 pe-5 pt-1 pb-1' style='text-align: center'>
                    @yield('image')
                </div>
                <div class='col-6'">
                    <div class="row mb-3">
                        <div class="col"  style='
                             color:{{$principalColor}};
                             font-size: 36px;
                             '>
                            @yield('name')
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"  style='
                             color:lightslategray;
                             font-size: 15px;
                             '>
                            @yield('description')
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-5 d-flex align-items-center' style='text-align: center'>
                            @if($whatsappLink != null)
                            <a target='_blank' href='{{$whatsappLink}}'>
                                <button class='text-button primary d-flex align-items-center w-75 ps-3 pe-3 pt-1 pb-0'>
                                    <i class="fab fa-whatsapp" style='
                                       font-size:36px;
                                       color:white;
                                       '>
                                           
                                    </i>
                                    <p style='
                                       color:white;
                                       font-size:14px;
                                       padding-top: 6px;
                                       '>
                                    COMPRAR POR WHATSAPP
                                    </p>
                                </button>
                            </a>
                            @endif
                            <!--                        desativado botao de COMPRAR-->
                            @if(1 == 2)
                            <a class='text-button secondary' href='{{route('product.redirect', [
                                                                                                                                'product' => 76, 
                                                                                                                                ])}}'>
                                COMPRAR
                            </a>
                            @endif
                            <!--fim do botao comprar -->
                        </div>
                        <div class='col-4 pe-0' style='text-align: center'>
                            <div class='show-label' style='
                                                                            background-color: {{$complementaryColor}};
                                                                            font-size: 18px;
                                                                            '>
                                PREÇO
                            </div>
                            <div class='show-label' style='
                                 color: {{$complementaryColor}};
                                 background-color: white;
                                 font-weight: 200;
                                 '>
                                PRAZO DE ENTREGA
                            </div>
                            @if($product->stock)
                            <div class='show-label' style='
                                 color: {{$complementaryColor}};
                                 background-color: white;
                                 font-weight: 200;
                                 '>
                                QUANTIDADE DISPONÍVEL
                            </div>
                            @endif
                        </div>
                        <div class='col-3 ps-0' style='text-align: center'>
                            <div class='show-field-end text-end' style="font-size: 18px">
                                @yield('price')
                            </div>
                            <div class='show-field-end text-end'>
                                @yield('due_date')
                            </div>
                            @if($product->stock)
                            <div class='show-field-end text-end'>
                                @yield('stock')
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @yield('main')

                @include('layouts.footer')

            </div>
        </div>
        <script>
            $('#delete-button').click(function () {
                if (!confirm('Tem certeza que você quer apagar?')) {
                    return false;
                }
            });
        </script>
        @yield('js-scripts')
    </body>
</html>
