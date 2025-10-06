@extends('layouts/master')

@section('title', 'EDITAR CONTATO')

@section('image-top')
    {{ asset('images/contact.png') }}
@endsection

@section('description')
@endsection

@section('buttons')
    <a class="circular-button primary" href="{{ route('contact.index') }}">
        <i class="fas fa-arrow-left"></i>
    </a>
@endsection

@section('main')
    <div>
        <form action="{{ route('contact.update', ['contact' => $contact]) }}" method="post"
            style="padding: 40px;color: #874983">
            @csrf
            @method('put')
            <label for="">Origem do contato: </label>
            <select name="lead_source">
                <option class="fields" value="{{ $contact->lead_source }}">
                    {{ $contact->lead_source }}
                </option>
                <option class="fields" value="site">
                    site
                </option>
                <option class="fields" value="pesquisa paga">
                    pesquisa paga
                </option>
                <option class="fields" value="pesquisa orgânica">
                    pesquisa orgânica
                </option>
                <option class="fields" value="email marketing">
                    email marketing
                </option>
                <option class="fields" value="indicação">
                    indicação
                </option>
                <option class="fields" value="mídia social">
                    mídia social
                </option>
                <option class="fields" value="outbound">
                    outbound
                </option>
                <option class="fields" value="desconhecida">
                    desconhecida
                </option>
                <option class="fields" value="outros">
                    outros
                </option>
            </select>
            <br>
            <br>
            <br>
            <h2 class="name" for="">PESSOAL</h2>
            <label for="">Primeiro nome: </label>
            <input type="text" name="first_name" value="{{ $contact->first_name }}">
            <br>
            <label for="">Sobrenome: </label>
            <input type="text" name="last_name" value="{{ $contact->last_name }}">
            <br>
            <label for="">Data de Nascimento: </label>
            <input type="date" name="date_birth" value="{{ $contact->date_birth }}">
            <br>
            <label for="">CPF: </label>
            <input type="text" name="cpf" value="{{ $contact->cpf }}">
            <br>
            <br>
            <br>
            <h2 class="name" for="">PROFISSIONAL</h2>
            <label for="">Profissão: </label>
            <input type="text" name="profession" value="{{ $contact->professions }}">
            <div class="row mt-3 mb-3">
                <label class='labels' for='companies'>Empresa: </label>
                <select name="companies[]" id="companies" class="fields" multiple size="10">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}"
                            {{ in_array($company->id, $companiesChecked) ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>


                <div class="row mt-3 mb-3">
                    <div class="col-md-4">
                        <label class="labels" for="job_position">Cargo: </label>
                        <input type="text" name="job_position" value="{{ $contact->job_positions }}">
                    </div>
                    <div class="col-md-4">
                        <label class="labels" for="schollarity">Escolaridade: </label>
                        <select name="schollarity">
                            <option class="fields" value="{{ $contact->schollarity }}">
                                {{ $contact->schollarity }}
                            </option>
                            <option class="fields" value="fundamental">
                                ensino fundamental
                            </option>
                            <option class="fields" value="médio">
                                ensino médio
                            </option>
                            <option class="fields" value="superior incompleto">
                                superior incompleto
                            </option>
                            <option class="fields" value="superior completo">
                                superior completo
                            </option>
                            <option class="fields" value="pós-graduação">
                                pós-graduação
                            </option>
                            <option class="fields" value="sem escolaridade">
                                sem escolaridade
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="labels" for="usp_id">Número USP:</label>
                        <input type="text" class="fields" name="usp_id" size="8" value="{{ $contact->usp_id }}">
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-4">
                        <label class="labels" for="area_of_knowledge_1">Área do conhecimento 1:</label>
                        <input type="text" class="fields" name="area_of_knowledge_1" value="{{ $contact->area_of_knowledge_1 }}">
                    </div>
                    <div class="col-md-4">
                        <label class="labels" for="area_of_knowledge_2">Área do conhecimento 2:</label>
                        <input type="text" class="fields" name="area_of_knowledge_2" value="{{ $contact->area_of_knowledge_2 }}">
                    </div>
                    <div class="col-md-4">
                        <label class="labels" for="area_of_knowledge_3">Área do conhecimento 3:</label>
                        <input type="text" class="fields" name="area_of_knowledge_3" value="{{ $contact->area_of_knowledge_3 }}">
                    </div>
                    <div class="col-md-4">
                        <label class="labels" for="area_of_knowledge_4">Área do conhecimento 4:</label>
                        <input type="text" class="fields" name="area_of_knowledge_4" value="{{ $contact->area_of_knowledge_4 }}">
                    </div>
                    <div class="col-md-4">
                        <label class="labels" for="area_of_knowledge_5">Área do conhecimento 5:</label>
                        <input type="text" class="fields" name="area_of_knowledge_5" value="{{ $contact->area_of_knowledge_5 }}">
                    </div>
                </div>

                <div class="row mt-5 mb-3">
                    <h2 class="name" for="">CONTATOS</h2>
                </div>
                <label for="">Email: </label>
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

                <div class="row mt-5 mb-3">
                    <h2 class="name" for="">LOCALIZAÇÃO</h2>
                </div>
                <label for="">Endereço: </label>
                <input type="text" name="address" value="{{ $contact->address }}">
                <br>
                <label for="">Cidade: </label>
                <input type="text" name="city" value="{{ $contact->city }}">
                <br>
                <label for="">Bairro: </label>
                <input type="text" name="neighborhood" value="{{ $contact->neighborhood }}">
                <br>
                <label for="">Estado: </label>
                {{ createDoubleSelect('state', 'fields', $states) }}
                <br>
                <label for="">País: </label>
                <input type="text" name="country" value="{{ $contact->country }}">
                <br>
                <label for="">CEP: </label>
                <input type="text" name="zip_code" value="{{ $contact->zip_code }}">

                <div class="row mt-5 mb-3">
                    <h2 class="name" for="">PERFIL</h2>
                </div>
                <label for="">Estado Civil: </label>
                <input type="text" name="civil_state" value="{{ $contact->civil_state }}">
                <br>
                <label for="">Naturalidade: </label>
                <input type="text" name="naturality" value="{{ $contact->naturality }}">
                <br>
                <label for="">Filhos: </label>
                <input type="text" name="kids" value="{{ $contact->kids }}">
                <br>
                <label for="">Hobbie principal: </label>
                {{ createSimpleSelect('hobbie', 'fields', $hobbies, $contact->hobbie) }}
                <br>
                <label for="">Renda: </label>
                <input type="text" name="income">
                <br>
                <label for="">Religião: </label>
                {{ createSimpleSelect('religion', 'fields', $religions, $contact->religion) }}
                <br>
                <label for="">Etinia: </label>
                {{ createSimpleSelect('etinicity', 'fields', $etinicities, $contact->etinicity) }}
                <br>
                <label for="">Gênero: </label>
                {{ createSimpleSelect('gender', 'fields', $genderTypes, $contact->gender) }}
                <br>
                <label for="">Tipo: </label>
                {{ createSimpleSelect('type', 'fields', $contactTypes, $contact->type) }}

                <div class="row mt-5 mb-3">
                    <h2 class="name" for="">AUTORIZAÇÕES</h2>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label class="labels" for="">Dados pessoais:</label>
                    </div>
                    <div class="col-9">
                        {{ createCheckboxEdit('authorization_data', $contact->authorization_data) }}
                        Autorizo o armazenamento dos meus dados.
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label class="labels" for="">Contato:</label>
                    </div>
                    <div class="col-9">
                        {{ createCheckboxEdit('authorization_contact', $contact->authorization_contact) }} Permito que a
                        empresa entre em contato comigo.
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label class="labels" for="">Newsletter:</label>
                    </div>
                    <div class="col-9">
                        {{ createCheckboxEdit('authorization_newsletter', $contact->authorization_newsletter) }} Quero
                        receber notícias sobre a empresa e seus produtos/serviços.
                    </div>
                </div>

                <div class="row mt-5 mb-3">
                    <label for="status">
                        SITUAÇÃO:
                    </label>
                    {{ createSimpleSelect('status', 'fields', $status, $contact->status) }}
                </div>
                <input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">
        </form>
    </div>
    <br>
    <br>
@endsection
