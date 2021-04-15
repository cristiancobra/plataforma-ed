@extends('layouts/master')

@section('title','EDITAR CONTATO')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('contact.index')}}">
    <i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('main')
<div>
    <form action="{{route('contact.update', ['contact' =>$contact])}}" method="post" style="padding: 40px;color: #874983">
        @csrf
        @method('put')
        <label for="" >DONO: </label>
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
        <label for="">Origem do contato: </label>
        <select name="lead_source">
            <option  class="fields" value="{{ $contact->lead_source }}">
                {{ $contact->lead_source }}
            </option>
            <option  class="fields" value="site">
                site
            </option>
            <option  class="fields" value="pesquisa paga">
                pesquisa paga
            </option>
            <option  class="fields" value="pesquisa orgânica">
                pesquisa orgânica
            </option>
            <option  class="fields" value="email marketing">
                email marketing
            </option>
            <option  class="fields" value="indicação">
                indicação
            </option>
            <option  class="fields" value="mídia social">
                mídia social
            </option>
            <option  class="fields" value="outbound">
                outbound
            </option>
            <option  class="fields" value="desconhecida">
                desconhecida
            </option>
            <option  class="fields" value="outros">
                outros
            </option>
        </select>
        <br>
        <br>
        <br>
        <h2 class="name" for="">PESSOAL</h2>
        <label for="" >Primeiro nome: </label>
        <input type="text" name="first_name" value="{{ $contact->first_name }}">
        <br>
        <label for="" >Sobrenome: </label>
        <input type="text" name="last_name" value="{{ $contact->last_name }}">
        <br>
        <label for="" >Data de Nascimento: </label>
        <input type="date" name="date_birth" value="{{ $contact->date_birth }}">
        <br>
        <label for="" >CPF: </label>
        <input type="text" name="cpf" value="{{$contact->cpf}}">
        <br>
        <br>
        <br>
        <h2 class="name" for="">PROFISSIONAL</h2>
        <label for="">Profissão: </label>
        <input type="text" name="profession" value="{{$contact->profession}}">
        <br>
        <label for="">Empresa: </label>
        <br>
        @foreach ($companies as $company)
        <p class="fields">
            <input type="checkbox" name="companies[]" value="{{$company->id}}"
                   @if (in_array($company->id, $companiesChecked))
            checked
            @endif
            >
            {{$company->name}}
        </p>
        @endforeach
        <br>
        <br>
        <label for="">Cargo: </label>
        <input type="text" name="job_position" value="{{$contact->job_position}}">
        <br>
        <label for="">Escolaridade: </label>
        <select name="schollarity">
            <option  class="fields" value="{{$contact->schollarity}}">
                {{$contact->schollarity}}
            </option>
            <option  class="fields" value="fundamental">
                ensino fundamental
            </option>
            <option  class="fields" value="médio">
                ensino médio
            </option>
            <option  class="fields" value="superior incompleto">
                superior incompleto
            </option>
            <option  class="fields" value="superior completo">
                superior completo
            </option>
            <option  class="fields" value="pós-graduação">
                pós-graduação
            </option>
            <option  class="fields" value="sem escolaridade">
                sem escolaridade
            </option>
        </select>
        <br>
        <br>
        <br>

        <h2 class="name" for="">CONTATOS</h2>
        <label for="" >Email: </label>
        <input type="text" name="email" value="{{ $contact->email }}">
        <br>
        <label for="">Telefone: </label> 
        <input type="text" name="phone" value="{{ $contact->phone }}">
        <br>
        <label for="">Site: </label>
        <input type="text" name="site" value="{{ $contact->site }}">
        <br>
        <label for="">Instagram: </label>
        <input type="text" name="instagram" value="{{ $contact->instagram }}">   
        <br>
        <label for="">Facebook: </label>
        <input type="text" name="facebook" value="{{ $contact->facebook }}">   
        <br>
        <label for="">Linkedin: </label>
        <input type="text" name="linkedin" value="{{ $contact->linkedin }}">
        <br>
        <label for="">Twitter: </label>
        <input type="text" name="twitter" value="{{ $contact->twitter }}">
        <br>
        <br>
        <br>

        <h2 class="name" for="">LOCALIZAÇÃO</h2>
        <label for="">Endereço: </label>
        <input type="text" name="address" value="{{ $contact->address }}">   
        <br>
        <label  for="">Cidade: </label>
        <input type="text" name="city" value="{{ $contact->city }}">
        <br>
        <label for="">Bairro: </label>
        <input type="text" name="neighborhood" value="{{ $contact->neighborhood }}">
        <br>
        <label for="">Estado: </label>
        {{createDoubleSelect('state', 'fields', $states)}}
        <br>
        <label  for="">País: </label>
        <input type="text" name="country" value="{{$contact->country}}">
        <br>
        <label for="" >CEP: </label>
        <input type="text" name="zip_code" value="{{$contact->zip_code}}">
        <br>
        <br>
        <h2 class="name" for="">PERFIL</h2>
        <p>Utilize esses dados apenas com permissão dos contatos e se você for importante para seu modelo de negócio, obedecendo o previsto na
            <a href="http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/L13709.htm">
                Lei Geral de Proteção de Dados
            </a>
        </p>
        <br>
        <br>	
        <label for="">Estado Civil: </label>
        <input type="text" name="civil_state" value="{{ $contact->civil_state }}"> 
        <br>
        <label for="">Naturalidade: </label>
        <input type="text" name="naturality" value="{{ $contact->naturality }}">
        <br>
        <label for="">Filhos: </label>
        <input type="text" name="kids" value="{{ $contact->kids }}"> 
        <br>
        <label for="">Hobbie: </label>
        <input type="text" name="hobbie"  value="{{ $contact->hobbie }}">    
        <br>
        <label for="">Renda: </label>
        <input type="text" name="income" value="{{ $contact->income }}">    
        <br>
        <label for="">Religião: </label>
        <input type="text" name="religion" value="{{ $contact->religion }}">
        <br>
        <label for="">Etinia: </label>
        <input type="text" name="etinicity" value="{{ $contact->etinicity }}">    
        <br>
        <label for="">Orientação Sexual: </label>
        <input type="text" name="sexual_orientation" value="{{$contact->sexual_orientation}}">    
        <br>
        <br>
        <label  for="">Tipo: </label>
        <input type="text" name="type" value="{{ $contact->type }}">
        <br>
        <br>
        <label for="status">SITUAÇÃO: </label>
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
