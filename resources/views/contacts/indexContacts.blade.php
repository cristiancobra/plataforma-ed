@extends('layouts/master')

@section('title','CONTATOS')

@section('image-top')
{{asset('imagens/contact.png')}} 
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('contact.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div style="text-align: right">
    <form action="{{route('contact.index')}}" method="post" style="display: inline-block">
        @csrf
        <input type="text" name="name" placeholder="nome do contato" value="">
    
        <input class="btn btn-secondary" type="submit" value="FILTRAR">
    </form>
</div>
<br>
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 25%">
                NOME
            </td>
            <td   class="table-list-header" style="width: 35%">
                EMPRESA
            </td>
            <td   class="table-list-header" style="width: 25%">
                EMAIL
            </td>
            <td   class="table-list-header" style="width: 15%">
                TELEFONE
            </td>
        </tr>

        @foreach ($contacts as $contact)
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
            <td class="table-list-left">
                {{$contact->email}}
                <a class="white" href="">
                    <button class="button-round">
                        <i class='fa fa-envelope'></i>
                    </button>
                </a>
            </td>
            <td class="table-list-right">
                {{$contact->phone}}
            </td>
        </tr>
        @endforeach
    </table>
    <p style="text-align: right">
        <br>
        {{$contacts->links()}}
    </p>
    <br>
    @endsection