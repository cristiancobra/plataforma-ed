@extends('layouts/master')

@section('title','CONTATOS')

@section('image-top')
{{asset('images/contact.png')}} 
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
<div class='alert alert-danger'>
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action='{{route('contact.store')}}' method='post'>
        @csrf
        <label class='labels' for=''>Origem do Lead: </label>
        {{createSimpleSelect('lead_source', 'fields', $leadSources)}}
        <br>
        <br>
        <br>
        <h2 class='name' for=''>PESSOAL</h2>
        <label class='labels' for=''>Primeiro nome: </label>
        <input type='text' name='first_name' value='{{old('first_name')}}'>
        @if ($errors->has('first_name'))
        <span class='text-danger'>{{ $errors->first('first_name') }}</span>
        @endif
        <br>
        <label class='labels' for=''>Sobrenome: </label>
        <input type='text' name='last_name' value='{{old('last_name')}}'>
        @if ($errors->has('last_name'))
        <span class='text-danger'>{{ $errors->first('last_name') }}</span>
        @endif
        <br>
        <label class='labels' for=''>Data de Nascimento: </label>
        <input type='date' name='date_birth'>
        <br>
        <label class='labels' for=''>CPF: </label>
        <input type='text' name='cpf'>
        <br>
        <br>

        <h2 class='name' for=''>PROFISSIONAL</h2>
        <label class='labels' for=''>Profissão: </label>
        {{createSimpleSelect('profession', 'fields',  $professions) }}
        <br>
        <br>
        <label class='labels' for=''>Empresa: </label>
        <br>
        @foreach ($companies as $company)
        <p class='fields'>
            <input type='checkbox' name='companies[]' value='{{$company->id}}'>
            {{$company->name}}
        </p>
        @endforeach
        <br>
        <label class='labels' for=''>Cargo: </label>
        {{createSimpleSelect('job_position', 'fields',  $jobPositions) }}
        <br>
        <br>
        <label class='labels' for=''>Escolaridade: </label>
        <select name='schollarity'>
            <option  class='fields' value=''>
            </option>
            <option  class='fields' value='fundamental'>
                ensino fundamental
            </option>
            <option  class='fields' value='médio'>
                ensino médio
            </option>
            <option  class='fields' value='superior incompleto'>
                superior incompleto
            </option>
            <option  class='fields' value='superior completo'>
                superior completo
            </option>
            <option  class='fields' value='pós-graduação'>
                pós-graduação
            </option>
            <option  class='fields' value='sem escolaridade'>
                sem escolaridade
            </option>
        </select>
        <br>
        <br>
        <br>

        <h2 class='name' for=''>CONTATOS</h2>
        <label class='labels' for=''>Email: </label>
        <input type='text' name='email' value='{{old('email')}}'>
        @if ($errors->has('email'))
        <span class='text-danger'>{{ $errors->first('email') }}</span>
        @endif
        <br>
        <label class='labels' for=''>Telefone: </label>
        <input type='text' name='phone'>   
        <br>
        <label class='labels' for=''>Site: </label>
        <input type='text' name='site'>   
        <br>
        <label class='labels' for=''>Instagram: </label>
        <input type='text' name='instagram'>   
        <br>
        <label class='labels' for=''>Facebook: </label>
        <input type='text' name='facebook'>   
        <br>
        <label class='labels' for=''>Linkedin: </label>
        <input type='text' name='linkedin'>   
        <br>
        <label class='labels' for=''>Twitter: </label>
        <input type='text' name='twitter'>   
        <br>
        <br>
        <br>

        <h2 class='name' for=''>LOCALIZAÇÃO</h2>
        <label class='labels' for=''>Endereço: </label>
        <input type='text' name='address'>   
        <br>
        <label for='city'>Cidade: </label>
        <input type='text' name='city'>   
        <br>
        <label class='labels' for=''>Bairro: </label>
        <input type='text' name='neighborhood'>   
        <br>
        <label class='labels' for=''>Estado: </label>
        {{createDoubleSelect('state', 'fields', $states)}}
        <br>
        <br>
        <label class='labels' for=''>País: </label>
        <input type='text' name='country' value='Brasil'>   
        <br>
        <label class='labels' for=''>CEP: </label>
        <input type='text' name='zip_code'>
        <br>
        <br>
        <br>

        <h2 class='name' for=''>PERFIL</h2>
        <p>Utilize esses dados apenas com permissão dos contatos e se você for importante para seu modelo de negócio, obedecendo o previsto na
            <a href='http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/L13709.htm'>
                Lei Geral de Proteção de Dados
            </a>.
            <br>
            <br>	
            <label class='labels' for=''>Estado Civil: </label>
            <select name='civil_state'>
                <option  class='fields' value=''>

                </option>
                <option  class='fields' value='solteiro'>
                    solteiro(a)
                </option>
                <option  class='fields' value='casado'>
                    casado(a)
                </option>
                <option  class='fields' value='divorciado'>
                    divorciado(a)
                </option>
                <option  class='fields' value='união estável'>
                    união estável
                </option>
                <option  class='fields' value='viúvo'>
                    viúvo(a)
                </option>
            </select>

            <br>
            <label class='labels' for=''>Naturalidade: </label>
            <input type='text' name='naturality'>
            <br>
            <label class='labels' for=''>Filhos: </label>
            <input type='number' name='kids'>   
            <br>
            <label class='labels' for=''>Hobbie principal: </label>
            {{createSimpleSelect('hobbie', 'fields',  $hobbies)}}
            <br>
            <label class='labels' for=''>Renda: </label>
            <input type='text' name='income'>   
            <br>
            <label class='labels' for=''>Religião: </label>
            {{createSimpleSelect('religion', 'fields',  $religions)}}
            <br>
            <label class='labels' for=''>Etinia: </label>
            {{createSimpleSelect('etinicity', 'fields',  $etinicities)}}
            <br>
            <label class='labels' for=''>Gênero: </label>
            {{createSimpleSelect('gender', 'fields',  $genderTypes)}}
            <br>
            <br>
            <label class='labels' for=''>Tipo: </label>
            @if($type)
            <input type='hidden' name='type' value='{{Request::get('type')}}'>
            {{Request::get('type')}}
            @else
            {{createSimpleSelect('type', 'fields',  $contactTypes)}}
            @endif
            <br>
            <br>
            <label  class='labels' for=''>observações: </label>
            <br>
            <textarea id='observation' name='observation' rows='20' cols='90'>
            </textarea>
            <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
            <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
            <script>
    CKEDITOR.replace('observation');
            </script>
            <br>
            <br>
            <label for='status'>SITUAÇÃO: </label>
            <select class='fields' name='status'>
                <option value='ativo'>ativo</option>
                <option value='pendente'>pendente</option>
                <option value='desativado'>desativado</option>
            </select>
            <br>
            <br>
            <input class='btn btn-secondary' type='submit' value='CRIAR'>
    </form>
</div>
@endsection
