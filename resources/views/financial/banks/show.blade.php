@extends('layouts/master')

@section('title', 'BANCOS')

@section('image-top')
    <i class="fas fa-exchange-alt"></i>
@endsection


@section('buttons')

    <x-buttons.list model='bank' :principalColor=$principalColor ?? null />
@endsection

@section('main')
    <br>
    <div>
        <p class="labels">
            NOME:<span class="fields">{{ $bank->name }}</span>
        </p>
        <p class="labels">
            CÓDIGO:<span class="fields">{{ $bank->bank_code }}</span>
        </p>
        <br>
        <br>
        <p class="fields">Criado em: {{ date('d/m/Y H:i', strtotime($bank->created_at)) }}
        </p>

        <div style="text-align:right;padding: 2%">
            <x-buttons.delete :action="route('bank.destroy', ['bank' => $bank->id])" />
            <a class="btn btn-secondary" href=" {{ route('bank.edit', ['bank' => $bank->id]) }}">
                <i class='fa fa-edit'></i>EDITAR
            </a>
            <a class="btn btn-secondary" href="{{ route('bank.index') }}"><i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
@endsection
