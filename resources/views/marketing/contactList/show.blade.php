@extends('layouts/master')

@section('title','LISTA DE CONTATOS')

@section('image-top')
{{asset('imagens/contact.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='button-primary'  href='{{route('contactList.index')}}'>
    VOLTAR
</a>
@endsection

@section('main')
<br>

@if(Session::has('failed'))
<div class='alert alert-danger'>
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <h1 class='name'>
        {{$contactList->name}}
    </h1>
    <p class='labels'>
        EMPRESA:<span class='fields'>{{$contactList->account->name}}</span>
    </p>
    <p class='labels'>
        DATA DE CRIAÇÃO:<span class='fields'>{{dateBR($contactList->created_in)}}</span>
    </p>
    <br>
    <p class='labels'>
        SITUAÇAO:<span class='fields'>{{$contactList->status}}</span>
    </p>
    <br>
    <p class='labels'>
        CONTATOS:<span class='fields'>{{$contactList->status}}</span>
    </p>
    <div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 30%">
                NOME
            </td>
            <td   class="table-list-header" style="width: 30%">
                EMPRESA
            </td>
            <td   class="table-list-header" style="width: 25%">
                DONO
            </td>
            <td   class="table-list-header" style="width: 15%">
                TIPO
            </td>
        </tr>

        @foreach($contactList->contacts as $contact)
        <tr style="font-size: 14px">
            <td class="table-list-left">
                <a class="white" href=" {{route('contact.show', ['contact' => $contact->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('contact.edit', ['contact' => $contact->id])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$contact->name}}
            </td>
            <td class="table-list-left">
                @if($contact->companies)
                @foreach ($contact->companies as $company)
                <a class="white" href=" {{route('company.show', ['company' => $company->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('company.edit', ['company' => $company->id])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$company->name}}
                <br>
                @endforeach
                @else
                Não possui
                @endif
            </td>
            <td class="table-list-center">
                {{$contact->account->name}}
            </td>
            {{formatContactType($contact->type)}}
        </tr>
        @endforeach
    </table>
    <br>
    <div style="text-align:right;padding: 2%">
        <form   style="text-decoration: none;color: black;display: inline-block" action="{{route('contactList.destroy', ['contactList' => $contactList->id])}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="APAGAR">
        </form>
        <a class="button-secondary" href=" {{route('contactList.edit', ['contactList' => $contactList->id])}}" style="text-decoration: none;color: white;display: inline-block">
            <i class='fa fa-edit'></i>EDITAR
        </a>
        <a class="button-secondary" href="{{route('contactList.index')}}">
            VOLTAR
        </a>
    </div>
    <br>
    <br>
</div>
@endsection