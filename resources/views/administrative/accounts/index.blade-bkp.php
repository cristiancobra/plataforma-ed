@extends('layouts/master')

@section('title','CONTAS')

@section('image-top')
{{asset('images/empresa.png')}} 
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('account.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<table class="table-list">
    <tr>
        <td   class="table-list-header">
            <b>Empresa </b>
        </td>
        <td   class="table-list-header">
            <b>Usuários </b>
        </td>
    </tr>

    @foreach ($accounts as $account)
    <tr style="font-size: 16px">
        <td class="table-list-left">
            <a  class="white" href=" {{ route('account.show', ['account' => $account->id]) }}">
                <button class="button-round">
                    <i class='fa fa-eye'></i>
                </button>
                <a href=" {{ route('account.edit', ['account' => $account->id]) }}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
            </a>
            {{ $account->name }}
        </td>

        <td class="table-list-left">
            @foreach ($account->users as $user)
            <a  class="white" href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank">
                <button class="button-round">
                    <i class='fas fa-comment-dots'></i>
                </button>
            </a>

            <a  class="white" href=" {{ route('user.show', ['user' => $user->id]) }}">
                <button class="button-round">
                    <i class='fa fa-eye'></i>
                </button>
            </a>
            {{$user->name}}
            <br>
            @endforeach	
        </td>
        @endforeach
</table>
<p style="text-align: right">
    <br>
    {{ $accounts->links() }}
</p>
<br>
@endsection
