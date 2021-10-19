<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body class='p-2' style='background-color: #EEEEEE'>


        @if(Session::has('failed'))
        <div class='alert alert-danger'>
            {{ Session::get('failed') }}
            @php
            Session::forget('failed');
            @endphp
        </div>
        @endif

        <div id='white-page' class='row m-2 p-5' style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white'>

            <div class='row' style='margin-top: 40px'>
                <div class='col-6 col-xs-6 ps-5 pe-5 pt-1 pb-1' style='text-align: center'>
                    @yield('image')
                </div>
                <div class='offset-1 col-2 col-xs-3' style='text-align: center'>
                    <div class='show-label'>
                        PREÇO
                    </div>
                    @if($product->initial_stock)
                    <div class='show-label'>
                        ESTOQUE
                    </div>
                    @endif
                    <div class='show-label'>
                        PRAZO DE ENTREGA
                    </div>
                    <div class='show-label mt-5' style="background-color: {{$oppositeColor}}">
                    COMPRAR
                    </div>
                </div>
                <div class='col-2 col-xs-6' style='text-align: center'>
                    @yield('fields')
                       <div class='col mt-5 d-flex justify-content-center'>
                    <a class='text-button primary' target='_blank' href='https://api.whatsapp.com/send?phone=5516981076049&text=Preciso%20de%20ajuda%20com%20a%20minha%20empresa!%20'>WHATSAPP</a>
                    <a class='text-button secondary' href='{{route('product.redirect', [
                                                                                                                                'product' => 76, 
                                                                                                                                ])}}'>
                        COMPRAR
                    </a>
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

            @include('layouts.footer')

            @yield('createdAt')

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
