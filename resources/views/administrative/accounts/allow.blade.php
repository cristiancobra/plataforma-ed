@extends('layouts/dashboard')

@section('buttons')
@endsection

@section('main')
<div class='row mt-5'>
    <div class='col'>
        <div class='row mt-5'>
            <p style='color: #52004d;font-weight: 600;text-align: center;font-size: 22px'>
                CONTA BLOQUEADA
            </p>
        </div>
        <div class='row'>
            <div class='col d-flex justify-content-center'>
                <img class='ms-auto me-auto pt-1 pb-2' src='{{asset('images/cao-astronauta.png')}}' width='160px' height='210px'>
            </div>
        </div>
        <div class='row mt-2'>
            <div class='col'>
                <p class='text-center fs-5'>
                    Ocorreu algum problema com seu pagamento ou seu período de teste expirou.
                    <br>
                    Entre em contato com nossa equipe para mais informações.
                </p>
            </div>
            <div class='row mt-2 mb-5'>
                <div class='col d-flex justify-content-center'>
                    <a class='text-button primary' target='_blank' href='https://api.whatsapp.com/send?phone=5516981076049&text=Preciso%20de%20ajuda%20com%20a%20minha%20empresa!%20'>WHATSAPP</a>
                    <a class='text-button secondary' href='{{route('product.redirect', ['product' => 76])}}'>REATIVAR CONTA</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
