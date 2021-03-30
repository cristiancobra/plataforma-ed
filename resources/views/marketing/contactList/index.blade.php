@extends('layouts/master')

@section('title','LISTAS DE CONTATOS')

@section('image-top')
{{asset('imagens/contact.png')}} 
@endsection

@section('description')
Total: <span class="labels">{{$total}}</span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contactList.create')}}">
    CRIAR
</a>
@endsection

@section('main')
<div style="text-align: right">
    <form action="{{route('contactList.index')}}" method="post">
        @csrf
        <input type="text" name="name" placeholder="nome do contato" value="">
        <select class="select" name="account_id">
            <option  class="select" value="">
                Qualquer empresa
            </option>
            @foreach ($accounts as $account)
            <option  class="select" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
            <option  class="select" value="">
                todas
            </option>
        </select>
        {{submitFormButton('FILTRAR')}}
    </form>
</div>
<br>
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 30%">
                NOME
            </td>
            <td   class="table-list-header" style="width: 25%">
                EMPRESA
            </td>
            <td   class="table-list-header" style="width: 10%">
                SITUAÇÃO
            </td>
        </tr>

        @foreach($contactLists as $contactList)
        <tr style="font-size: 14px">
            <td class="table-list-left">
                <a class="white" href=" {{route('contactList.show', ['contactList' => $contactList->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('contactList.edit', ['contactList' => $contactList])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$contactList->name}}
            </td>
            <td class="table-list-left">
                {{$contactList->account->name}}            
            </td>
            @if($contactList->status == 'rascunho')
            <td class="td-draft">
                {{$contactList->status}}
            </td>
            @else
            <td class="td-aproved">
                {{$contactList->status}}
            </td>
            @endif
        </tr>
        @endforeach
    </table>
    <p style="text-align:right">
        <br>
        {{$contactLists->links()}}
    </p>
    <br>
    @endsection