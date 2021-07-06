@extends('layouts/master')

@section('title','CONTATOS')

@section('image-top')
{{ asset('images/contact.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('contact')}}
@endsection

@section('main')
<br>
<div>
    <h1 class="name">
        PÚBLICO-ALVO
    </h1>
    <label class="labels"  for="" >
        Origem do contato:
    </label>
    @foreach($sources as $source)
    {{$source}}
    @endforeach
    <br>
    <br>
    <h2 class="name" for="">PESSOAL</h2>
    <label class="labels"  for="" >Primeiro nome: </label> {{$contact->first_name}}
    <br>
    <label class="labels"  for="" >Sobrenome: </label> {{$contact->last_name}}
    <br>
    <label class="labels"  for="" >Data de nascimento: </label> {{$contact->date_birth}}
    <br>
    <label class="labels"  for="" >CPF: </label> {{$contact->cpf}}
    <br>
    <br>
    <h2 class="name" for="">
        OPORTUNIDADES:
    </h2>
    @foreach ($contact->opportunities as $opportunity)
    <a  class="white" href=" {{route('opportunity.show', ['opportunity' => $opportunity->id])}}">
        <button class="button-round">
            <i class='fa fa-eye'></i>
        </button>
    </a>
    {{ $opportunity->name }}
    <br>
    @endforeach	
    <br>
    <br>
    <h2 class="name" for="">PROFISSIONAL</h2>
    <label class="labels"  for="" >Profissão: </label> {{ $contact->profession }}
    <br>
    <label class="labels"  for="" >Empresa: </label> {{ $contact->company }}
    <br>
    <label class="labels"  for="" >Cargo: </label> {{ $contact->job_position }}
    <br>
    <label class="labels"  for="" >Escolaridade: </label> {{ $contact->schollarity }}
    <br>
    <br>
    <h2 class="name" for="">
        EMPRESAS ONDE TRABALHA:
    </h2>
    @if(!$contact->companies()->exists())
    Não possui empresa cadastrada
    <br>
    <a class="btn btn-secondary" href="{{ route('company.create')}}">
        CRIAR EMPRESA
    </a>
    <br>
    @else
    @foreach ($contact->companies as $company)
    <a  class="white" href=" {{route('company.show', ['company' => $company->id])}}">
        <button class="button-round">
            <i class='fa fa-eye'></i>
        </button>
    </a>
    {{$company->name}}
    <br>
    @endforeach	
    @endif
    <br>
    <br>
    <h2 class="name" for="">CONTATOS</h2>
    <label class="labels"  for="" >Email: </label> {{ $contact->email}}
    <br>
    <label class="labels"  for="">Telefone: </label> {{ $contact->phone}}
    <br>
    <label class="labels"  for="">Site: </label> {{ $contact->site}}
    <br>
    <label class="labels"  for="">Instagram: </label> {{ $contact->instagram}}
    <br>
    <label class="labels"  for="">Facebook: </label> {{ $contact->facebook}}
    <br>
    <label class="labels"  for="">Linkedin: </label> {{ $contact->linkedin}}
    <br>
    <label class="labels"  for="">Twitter: </label> {{ $contact->twitter}}
    <br>
    <br>
    <br>
    <h2 class="name" for="">LOCALIZAÇÃO</h2>
    <label class="labels" for="">Endereço: </label> {{ $contact->address}}
    <br>
    <label class="labels" for="">Cidade: </label> {{ $contact->city}}
    <br>
    <label class="labels" for="">Bairro: </label> {{ $contact->neighborhood}}
    <br>
    <label class="labels"  for="">Estado: </label> {{ $contact->state}}
    <br>
    <label class="labels"  for="">País: </label> {{ $contact->country}}
    <br>
    <label class="labels"  for="">CEP: </label> {{ $contact->zip_code}}
    <br>
    <br>
    <br>
    <h2 class="name" for="">PERFIL</h2>
    <label class="labels"  for="">Estado civil:  </label>
    {{ $contact->civil_state}}
    <br>
    <label class="labels"  for="">Naturalidade:  </label>
    {{ $contact->naturality}}
    <br>
    <label class="labels"  for="">Filhos:  </label>
    {{ $contact->kids}}
    <br>
    <label class="labels"  for="">Hobbie:  </label>
    {{ $contact->hobbie}}
    <br>
    <label class="labels"  for="">Renda:  </label>
    {{ $contact->income}}
    <br>
    <label class="labels"  for="">Religião:  </label>
    {{ $contact->religion}}
    <br>
    <label class="labels"  for="">Etinia:  </label>
    {{ $contact->etinicity}}
    <br>
    <label class="labels"  for="">Gênero:  </label>
    {{ $contact->gender}}
    <br>
    <br>
    <label for="">Tipo: </label> {{ $contact->type }}
    <br>
    <label for="">Stituação: </label> {{ $contact->status }}
    <br>
    <br>
    <p class="labels"> <b>Criado em:</b> {{ date('d/m/Y H:i', strtotime($contact->created_at)) }} </p>

    <div style="text-align:right;padding: 2%">
        <form   style="text-decoration: none;display: inline-block" action="{{ route('contact.destroy', ['contact' => $contact->id]) }}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="APAGAR">
        </form>
        <a class="btn btn-secondary" href=" {{ route('contact.edit', ['contact' => $contact->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
            <i class='fa fa-edit'></i>EDITAR</a>
        <a class="btn btn-secondary" href="{{route('contact.index')}}"><i class="fas fa-arrow-left"></i></a>
    </div>
    <br>
</div>
@endsection