@extends('layouts/master')

@section('title','NOVO CONTATO')

@section('image-top')
{{asset('imagens/contact.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('contact')}}
@endsection

@section('main')
<br>

@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action="{{route('contact.store')}}" method="post">
        @csrf
        <label for="">Origem do Lead: </label>
        <select name="lead_source">
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
        <input type="text" name="first_name" value="{{old('first_name')}}">
        @if ($errors->has('first_name'))
        <span class="text-danger">{{ $errors->first('first_name') }}</span>
        @endif
        <br>
        <label for="" >Sobrenome: </label>
        <input type="text" name="last_name" value="{{old('last_name')}}">
        @if ($errors->has('last_name'))
        <span class="text-danger">{{ $errors->first('last_name') }}</span>
        @endif
        <br>
        <label for="" >Data de Nascimento: </label>
        <input type="date" name="date_birth">
        <br>
        <label for="" >CPF: </label>
        <input type="text" name="cpf">
        <br>
        <br>

        <h2 class="name" for="">PROFISSIONAL</h2>
        <label for="">Profissão: </label>
        <input type="text" name="profession">   
        <br>
        <label for="">Empresa: </label>
        <br>
        @foreach ($companies as $company)
        <p class="fields">
            <input type="checkbox" name="companies[]" value="{{$company->id}}">
            {{$company->name}}
        </p>
        @endforeach
        <br>
        <label for="">Cargo: </label>
        <input type="text" name="job_position">   
        <br>
        <label for="">Escolaridade: </label>
        <select name="schollarity">
            <option  class="fields" value="">
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
        <input type="text" name="email" value="{{old('email')}}">
        @if ($errors->has('email'))
        <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif
        <br>
        <label for="">Telefone: </label>
        <input type="text" name="phone">   
        <br>
        <label for="">Site: </label>
        <input type="text" name="site">   
        <br>
        <label for="">Instagram: </label>
        <input type="text" name="instagram">   
        <br>
        <label for="">Facebook: </label>
        <input type="text" name="facebook">   
        <br>
        <label for="">Linkedin: </label>
        <input type="text" name="linkedin">   
        <br>
        <label for="">Twitter: </label>
        <input type="text" name="twitter">   
        <br>
        <br>
        <br>

        <h2 class="name" for="">LOCALIZAÇÃO</h2>
        <label for="">Endereço: </label>
        <input type="text" name="address">   
        <br>
        <label for="city">Cidade: </label>
        <input type="text" name="city">   
        <br>
        <label for="">Bairro: </label>
        <input type="text" name="neighborhood">   
        <br>
        <label for="">Estado: </label>
        {{createDoubleSelect('state', 'fields', $states)}}
        <br>
        <br>
        <label for="">País: </label>
        <input type="text" name="country" value="Brasil">   
        <br>
        <label for="" >CEP: </label>
        <input type="text" name="zip_code">
        <br>
        <br>
        <br>

        <h2 class="name" for="">PERFIL</h2>
        <p>Utilize esses dados apenas com permissão dos contatos e se você for importante para seu modelo de negócio, obedecendo o previsto na
            <a href="http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/L13709.htm">
                Lei Geral de Proteção de Dados
            </a>.
            <br>
            <br>	
            <label for="">Estado Civil: </label>
            <select name="civil_state">
                <option  class="fields" value="solteiro">
                    solteiro(a)
                </option>
                <option  class="fields" value="casado">
                    casado(a)
                </option>
                <option  class="fields" value="divorciado">
                    divorciado(a)
                </option>
                <option  class="fields" value="união estável">
                    união estável
                </option>
                <option  class="fields" value="viúvo">
                    viúvo(a)
                </option>
            </select>

            <br>
            <label for="">Naturalidade: </label>
            <input type="text" name="naturality">
            <br>
            <label for="">Filhos: </label>
            <input type="number" name="kids">   
            <br>
            <label for="">Hobbie: </label>
            <input type="text" name="hobbie">   
            <br>
            <label for="">Renda: </label>
            <input type="text" name="income">   
            <br>
            <label for="">Religião: </label>
            <input type="text" name="religion">   
            <br>
            <label for="">Etinia: </label>
            <input type="text" name="etinicity">   
            <br>
            <label for="">Gênero: </label>
            <input type="text" name="gender">   
            <br>
            <br>
            <label for="">Tipo: </label>
            <input type="text" name="type">
            <br>
            <br>
            <label for="status">SITUAÇÃO: </label>
            <select class="fields" name="status">
                <option value="ativo">ativo</option>
                <option value="pendente">pendente</option>
                <option value="desativado">desativado</option>
            </select>
            <br>
            <br>
            <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
</div>
@endsection