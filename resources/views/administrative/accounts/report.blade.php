@extends('layouts/master')

@section('title','CONTAS')

@section('image-top')
{{asset('images/empresa.png')}} 
@endsection

@section('buttons')
@endsection

@section('main')
<table class="table-list">
    <tr>
        <td   class="table-list-header">
            Empresa
        </td>
        <td   class="table-list-header">
            Usuários
        </td>
    </tr>

    @foreach ($accounts as $account)
    <tr style="font-size: 16px">
        <td class="table-list-left">
            <i class="fa fa-store" aria-hidden="true"></i>
            ID: {{ $account->id }} - {{ $account->name }}
        </td>
        <td class="table-list-left">
            @foreach ($account->users as $user)
            <i class="fa fa-id-card-alt" aria-hidden="true"></i>
            ID: {{ $user->id }} - {{$user->contact->name}}
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
