@extends('layouts/master')

@section('title', 'USUÁRIOS')

@section('image-top')
    <i class="fas fa-id-card-alt"></i>
@endsection

@section('buttons')
@endsection

@section('main')
    <table class="table-list">
        <tr>
            <td class="table-list-header">
                Usuários
            </td>
            <td class="table-list-header">
                Empresa
            </td>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td class="table-list-left">
                    <i class="fa fa-id-card-alt" aria-hidden="true"></i>
                    {{ $user->contact->name }}
                </td>

                <td class="table-list-left">
                    <i class="fa fa-store" aria-hidden="true"> </i>
                    @if ($user->account)
                        {{ $user->account->name }}
                    @else
                        Conta excluída
                    @endif
                    <br>
                </td>
        @endforeach
    </table>
    <p style="text-align: right">
        <br>
        {{ $users->links() }}
    </p>
    <br>
@endsection
