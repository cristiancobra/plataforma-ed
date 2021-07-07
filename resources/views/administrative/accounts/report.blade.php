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
            {{ $account->name }}
        </td>
        <td class="table-list-left">
            @foreach ($account->users as $user)
            <i class="fa fa-id-card-alt" aria-hidden="true"></i>
            {{$user->contact->name}}
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
