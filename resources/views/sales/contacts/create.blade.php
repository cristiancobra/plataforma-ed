@extends('layouts/master')

@section('title', 'CONTATOS')

@section('image-top')
    <i class="fas fa-address-book"></i>
@endsection

@section('description')
@endsection

@section('buttons')

    <x-buttons.list model='contact' :principalColor=$principalColor ?? null />
@endsection

@section('main')
    <style>
        .btn-submit-contact:hover {
            opacity: 0.85;
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
    </style>
    <div class="container-fluid">
        @if (Session::has('failed'))
            <div class='alert alert-danger'>
                {{ Session::get('failed') }}
                @php
                    Session::forget('failed');
                @endphp
            </div>
        @endif

        <form action='{{ route('contact.store') }}' method='post'>
            @csrf

            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class='form-label' for='lead_source'>Origem do Lead:</label>
                        {{ createSimpleSelect('lead_source', 'form-control', $leadSources) }}
                    </div>
                </div>
            </div>

            <!-- SEÇÃO PESSOAL -->
            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: {{ $principalColor }}">
                    <h4 class="mb-0"><i class="fas fa-user"></i> PESSOAL</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='first_name'>Primeiro nome:</label>
                            <input type='text' class="form-control" id="first_name" name='first_name'
                                value='{{ old('first_name') }}'>
                            @if ($errors->has('first_name'))
                                <span class='text-danger'>{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='last_name'>Sobrenome:</label>
                            <input type='text' class="form-control" id="last_name" name='last_name'
                                value='{{ old('last_name') }}'>
                            @if ($errors->has('last_name'))
                                <span class='text-danger'>{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='date_birth'>Data de Nascimento:</label>
                            <input type='date' class="form-control" id="date_birth" name='date_birth'
                                value='{{ old('date_birth') }}'>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='cpf'>CPF:</label>
                            <input type='text' class="form-control" id="cpf" name='cpf'
                                value='{{ old('cpf') }}'>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEÇÃO PROFISSIONAL -->
            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: {{ $principalColor }}">
                    <h4 class="mb-0"><i class="fas fa-briefcase"></i> PROFISSIONAL</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class='form-label' for='profession'>Profissão:</label>
                            <input type='text' class="form-control" id="profession" name='profession'
                                value="{{ old('profession') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class='form-label' for='companies'>Empresas:</label>
                            <select name="companies[]" id="companies" class="form-control" multiple size="5">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ in_array($company->id, old('companies', [])) ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Segure Ctrl/Cmd para selecionar múltiplas empresas</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='job_position'>Cargo:</label>
                            <input type='text' class="form-control" id="job_position" name='job_position'
                                value="{{ old('job_position') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='schollarity'>Escolaridade:</label>
                            <select name='schollarity' id='schollarity' class="form-control">
                                <option value=''>Selecione...</option>
                                <option value='fundamental' {{ old('schollarity') == 'fundamental' ? 'selected' : '' }}>
                                    Ensino Fundamental</option>
                                <option value='médio' {{ old('schollarity') == 'médio' ? 'selected' : '' }}>Ensino Médio
                                </option>
                                <option value='superior incompleto'
                                    {{ old('schollarity') == 'superior incompleto' ? 'selected' : '' }}>Superior Incompleto
                                </option>
                                <option value='superior completo'
                                    {{ old('schollarity') == 'superior completo' ? 'selected' : '' }}>Superior Completo
                                </option>
                                <option value='pós-graduação'
                                    {{ old('schollarity') == 'pós-graduação' ? 'selected' : '' }}>Pós-graduação</option>
                                <option value='sem escolaridade'
                                    {{ old('schollarity') == 'sem escolaridade' ? 'selected' : '' }}>Sem Escolaridade
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="usp_id">Número USP:</label>
                            <input type="text" class="form-control" id="usp_id" name="usp_id"
                                value="{{ old('usp_id') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class='form-label'>Áreas do Conhecimento:</label>
                            <input type='text' class="form-control mb-2" name='area_of_knowledge_1'
                                placeholder="Área 1" value="{{ old('area_of_knowledge_1') }}">
                            <input type='text' class="form-control mb-2" name='area_of_knowledge_2'
                                placeholder="Área 2" value="{{ old('area_of_knowledge_2') }}">
                            <input type='text' class="form-control mb-2" name='area_of_knowledge_3'
                                placeholder="Área 3" value="{{ old('area_of_knowledge_3') }}">
                            <input type='text' class="form-control mb-2" name='area_of_knowledge_4'
                                placeholder="Área 4" value="{{ old('area_of_knowledge_4') }}">
                            <input type='text' class="form-control" name='area_of_knowledge_5' placeholder="Área 5"
                                value="{{ old('area_of_knowledge_5') }}">
                        </div>
                    </div>
                </div>
            </div>
            <!-- SEÇÃO CONTATOS -->
            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: {{ $principalColor }}">
                    <h4 class="mb-0"><i class="fas fa-envelope"></i> CONTATOS</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='email'>Email:</label>
                            <input type='email' class="form-control" id="email" name='email'
                                value='{{ old('email') }}'>
                            @if ($errors->has('email'))
                                <span class='text-danger'>{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='phone'>Telefone:</label>
                            <input type='text' class="form-control" id="phone" name='phone'
                                value='{{ old('phone') }}'>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='site'>Site:</label>
                            <input type='url' class="form-control" id="site" name='site'
                                value='{{ old('site') }}' placeholder="https://">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class='form-label' for='instagram'>Instagram:</label>
                            <input type='text' class="form-control" id="instagram" name='instagram'
                                value='{{ old('instagram') }}' placeholder="@usuario">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='facebook'>Facebook:</label>
                            <input type='text' class="form-control" id="facebook" name='facebook'
                                value='{{ old('facebook') }}'>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='linkedin'>LinkedIn:</label>
                            <input type='text' class="form-control" id="linkedin" name='linkedin'
                                value='{{ old('linkedin') }}'>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='twitter'>Twitter:</label>
                            <input type='text' class="form-control" id="twitter" name='twitter'
                                value='{{ old('twitter') }}' placeholder="@usuario">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEÇÃO LOCALIZAÇÃO -->
            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: {{ $principalColor }}">
                    <h4 class="mb-0"><i class="fas fa-map-marker-alt"></i> LOCALIZAÇÃO</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class='form-label' for='address'>Endereço:</label>
                            <input type='text' class="form-control" id="address" name='address'
                                value='{{ old('address') }}'>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='zip_code'>CEP:</label>
                            <input type='text' class="form-control" id="zip_code" name='zip_code'
                                value='{{ old('zip_code') }}'>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class='form-label' for='city'>Cidade:</label>
                            <input type='text' class="form-control" id="city" name='city'
                                value='{{ old('city') }}'>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='neighborhood'>Bairro:</label>
                            <input type='text' class="form-control" id="neighborhood" name='neighborhood'
                                value='{{ old('neighborhood') }}'>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class='form-label' for='state'>Estado:</label>
                            {{ createDoubleSelect('state', 'form-control', $states) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class='form-label' for='country'>País:</label>
                            <input type='text' class="form-control" id="country" name='country'
                                value='{{ old('country', 'Brasil') }}'>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEÇÃO PERFIL -->
            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: {{ $principalColor }}">
                    <h4 class="mb-0"><i class="fas fa-user-circle"></i> PERFIL</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            Utilize esses dados apenas com permissão dos contatos e se for importante para seu modelo de
                            negócio,
                            obedecendo o previsto na
                            <a href='http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/L13709.htm'
                                target="_blank" class="alert-link">
                                Lei Geral de Proteção de Dados
                            </a>.
                        </small>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='civil_state'>Estado Civil:</label>
                            <select name='civil_state' id='civil_state' class="form-control">
                                <option value=''>Selecione...</option>
                                <option value='solteiro' {{ old('civil_state') == 'solteiro' ? 'selected' : '' }}>
                                    Solteiro(a)</option>
                                <option value='casado' {{ old('civil_state') == 'casado' ? 'selected' : '' }}>Casado(a)
                                </option>
                                <option value='divorciado' {{ old('civil_state') == 'divorciado' ? 'selected' : '' }}>
                                    Divorciado(a)</option>
                                <option value='união estável'
                                    {{ old('civil_state') == 'união estável' ? 'selected' : '' }}>União Estável</option>
                                <option value='viúvo' {{ old('civil_state') == 'viúvo' ? 'selected' : '' }}>Viúvo(a)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='naturality'>Naturalidade:</label>
                            <input type='text' class="form-control" id="naturality" name='naturality'
                                value='{{ old('naturality') }}'>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='kids'>Filhos:</label>
                            <input type='number' class="form-control" id="kids" name='kids' min="0"
                                value='{{ old('kids') }}'>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='hobbie'>Hobbie Principal:</label>
                            {{ createSimpleSelect('hobbie', 'form-control', $hobbies) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='religion'>Religião:</label>
                            {{ createSimpleSelect('religion', 'form-control', $religions) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='income'>Renda:</label>
                            <input type='text' class="form-control" id="income" name='income'
                                value='{{ old('income') }}'>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='etinicity'>Etnia:</label>
                            {{ createSimpleSelect('etinicity', 'form-control', $etinicities) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='gender'>Gênero:</label>
                            {{ createSimpleSelect('gender', 'form-control', $genderTypes) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class='form-label' for='type'>Tipo:</label>
                            @if ($type)
                                <input type='hidden' name='type' value='{{ Request::get('type') }}'>
                                <input type='text' class="form-control" value='{{ Request::get('type') }}' disabled>
                            @else
                                {{ createSimpleSelect('type', 'form-control', $contactTypes) }}
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class='form-label' for='observation'>Observações:</label>
                            <textarea id='observation' name='observation' rows='5' class="form-control">{{ old('observation') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class='form-label' for='status'>Situação:</label>
                            <select class='form-control' id='status' name='status'>
                                <option value='ativo' {{ old('status', 'ativo') == 'ativo' ? 'selected' : '' }}>Ativo
                                </option>
                                <option value='pendente' {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente
                                </option>
                                <option value='desativado' {{ old('status') == 'desativado' ? 'selected' : '' }}>
                                    Desativado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 text-end">
                <button type='submit' class='btn text-white btn-submit-contact'
                    style="background-color: {{ $principalColor }};">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
