@extends('layouts/master')

@section('title','EDITAR CONTATO')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('contact.index')}}">VER CONTATOS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
    <form action=" {{ route('contact.update', ['contact' =>$contact->id]) }} " method="post" style="padding: 40px;color: #874983">
        @csrf
        @method('put')
        <label class="labels" for="" >DONO: </label>
        <select name="account_id">
            <option  class="fields" value="{{ $contact->account->id }}">
                {{ $contact->account->name }}
            </option>
            @foreach ($accounts as $account)
            <option  class="fields" value="{{ $account->id }}">
                {{ $account->name }}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >Primeiro nome: </label>
        <input type="text" name="first_name" value="{{ $contact->first_name }}">
        <br>
        <label class="labels" for="" >Sobrenome: </label>
        <input type="text" name="last_name" value="{{ $contact->last_name }}">
        <br>
        <br>
        <label for="" >CPF: </label>
        <input type="text" name="cpf" value="{{ $contact->cpf }}">
        <br>
        <br>
        <label for="" >Data de Nascimento: </label>
        <input type="date" name="date_birth"value="{{ $contact->date_birth }}">
        <br>
        <label class="labels" for="" >Email: </label>
        <input type="text" name="email" value="{{ $contact->email }}">
        <br>
        <label class="labels" for="">Telefone: </label> 
        <input type="text" name="phone" value="{{ $contact->phone }}">
        <br>
        <label class="labels" for="">Site: </label>
        <input type="text" name="site" value="{{ $contact->site }}">
        <br>
        <br>
        <label for="">Instagram: </label>
        <input type="text" name="instagram"value="{{ $contact->instagram }}">   
        <br>
        <label for="">Facebook: </label>
        <input type="text" name="facebook"value="{{ $contact->facebook }}">   
        <br>
        <label for="">Linkedin: </label>
        <input type="text" name="linkedin"value="{{ $contact->linkedin }}">
        <br>
        <label for="">Twitter: </label>
        <input type="text" name="twitter"value="{{ $contact->twitter }}">
        <br>
        <label for="">Empresa: </label>
        <input type="text" name="company"value="{{ $contact->company }}">   
        <br>
        <label for="">Cargo: </label>
        <input type="text" name="job_position"value="{{ $contact->job_position }}">
        <br>
        <br>
        <label for="">Profissão: </label>
        <input type="text" name="profession"value="{{ $contact->profession }}">
        <br>
        <br>
        <label for="">Escolaridade: </label>
        <input type="text" name="schollarity"value="{{ $contact->schollarity }}">
        <br>
        <br>
        <label for="">Estado Civil: </label>
        <input type="text" name="civil_state"> value="{{ $contact->civil_state }}"> 
        <br>
        <br>
        <label for="">Filhos: </label>
        <input type="text" name="kids" value="{{ $contact->kids }}"> 
        <br>
        <br>
        <label for="">hobbie: </label>
        <input type="text" name="hobbie"> value="{{ $contact->hobbie }}">    
        <br>
        <label for="">renda: </label>
        <input type="text" name="income"> value="{{ $contact->income }}">    
        <br>
        <br>
        <label for="">Religião: </label>
        <input type="text" name="religion" value="{{ $contact->religion }}"> >   
        <br>
        <br>
        <label for="">Etinia: </label>
        <input type="text" name="etinicity" value="{{ $contact->etinicity }}">    
        <br>
        <br>
        <label for="">Naturalidade: </label>
        <input type="text" name="naturality" value="{{ $contact->naturality }}"> >   
        <br>
        <br>
        <label for="">Orientação Sexual: </label>
        <input type="text" name="sexual_orientation"> value="{{ $contact->sexual_orientation }}">    
        <br>
        <br>
        <label class="labels" for="">Endereço: </label>
        <input type="text" name="address" value="{{ $contact->address }}">   
        <br>
        <label class="labels" for="address_city">Cidade: </label>
        <input type="text" name="address_city" value="{{ $contact->address_city }}">
        <br>
        <br>
        <label for="">Bairro: </label>
        <input type="text" name="neighborhood"value="{{ $contact->neighborhood }}">
        <br>
        <label class="labels" for="">Estado: </label>
        <input type="text" name="address_state"  value="{{ $contact->address_state }}">
        <br>
        <label class="labels" for="">País: </label>
        <input type="text" name="address_country" value="{{ $contact->address_country }}">
        <br>
        <br>
        <label class="labels" for="">Tipo: </label>
        <input type="text" name="type" value="{{ $contact->type }}">
        <br>
        <br>
        <label for="">Origem do Lead: </label>
        <input type="text" name="lead_source"value="{{ $contact->lead_source }}">
        <br>
        <br>
        <label class="labels" for="status">SITUAÇÃO: </label>
        <select class="fields" name="status">
            <option value="{{ $contact->status }}">{{ $contact->status}}</option>
            <option value="ativo">ativo</option>
            <option value="pendente">pendente</option>
            <option value="desativado">desativado</option>
        </select>
        <br>
        <br>
        <input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

    </form>
</div>
<br>
<br>
@endsection
