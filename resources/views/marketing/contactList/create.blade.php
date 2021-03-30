@extends('layouts/master')

@section('title','LISTA DE CONTATOS')

@section('image-top')
{{asset('imagens/contact.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contactList.index')}}">
    VOLTAR
</a>
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
    <form action="{{route('contactList.store')}}" method="post" style="color: #874983">
        @csrf
        <label for="" >NOME: </label>
        <input name='name' type='text'>
        <br>
        <label for="" >DONO: </label>
        <select name="account_id">
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label for="" >DATA DE CRIAÇÃO: </label>
        <input name='created_in' type='date' value="{{date('d/m/Y')}}">
        <br>
        <br>
        <label for="contacts">SEGMENTAÇÃO: </label>
        <br>
        <label for="">Tipo: </label>
        {{createSelect('type', 'fields', returnContactType())}}
        <br>
        <br>
        <h5  for="">PESSOAL</h5>
        <label for="" >Data de Nascimento: </label>
        <input type="date" name="date_birth">
        <br>
        <br>
        <h5  for="">PROFISSIONAL</h5>
        <label for="">Profissão: </label>
        <input type="text" name="profession">   
        <br>
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
        <h5  for="">LOCALIZAÇÃO</h5>
        <label for="city">Cidade: </label>
        <input type="text" name="city">   
        <br>
        <label for="">Bairro: </label>
        <input type="text" name="neighborhood">   
        <br>
        <label for="">Estado: </label>
        {{createDoubleSelect('state', 'fields', returnStates())}}
        <br>
        <br>
        <label for="">País: </label>
        <input type="text" name="country" value="Brasil">   
        <br>
        <br>
        <br>

        <h5  for="">PERFIL</h5>
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
            <label for="">Orientação Sexual: </label>
            <input type="text" name="sexual_orientation">   
            <br>
            <br>
            <label for="status">SITUAÇÃO: </label>
            {{createSelect('status', 'fields', returnStatusActive())}}
            <br>
            <br>
            <br>
        <p style="text-align: right">
            {{submitFormButton('CRIAR')}}
        </p>
    </form>
</div>
@endsection