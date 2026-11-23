@extends('layouts/index')

@section('title', 'MODELOS DE CONTRATOS')

@section('image-top')
    <i class="fas fa-file-signature"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <a class="circular-button primary" href="{{ route('contract.index') }}">
        VER CONTRATOS
    </a>
    <a class="circular-button primary" href="{{ route('contractTemplate.create') }}">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
@endsection

@section('table')
    <div>
        <table class="table-list">
            <tr>
                <td class="table-list-header" style="width: 80%">
                    <b>TÍTULO </b>
                </td>
                <td class="table-list-header" style="width: 20%">
                    <b>ÚLTIMA ALTERAÇÃO</b>
                </td>
            </tr>

            @foreach ($contractsTemplates as $contractTemplate)
                <tr class="row-link" data-href="{{ route('contractTemplate.show', ['contractTemplate' => $contractTemplate->id]) }}" style="font-size: 14px">
                    <td class="table-list-left">
                        
                        <button class="button-round">
                            <a href=" {{ route('contractTemplate.edit', ['contractTemplate' => $contractTemplate->id]) }}">
                                <i class='fa fa-edit' style="color:white"></i>
                            </a>
                        </button>
                        {{ $contractTemplate->name }}
                    </td>
                    <td class="table-list-center">
                        {{ $contractTemplate->updated_at }}
                    </td>
                </tr>
            @endforeach
        </table>
        <p style="text-align: right">
            <br>
            {{ $contractsTemplates->links() }}
        </p>
        <br>
    @endsection
