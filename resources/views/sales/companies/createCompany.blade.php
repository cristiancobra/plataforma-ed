@extends('layouts/master')

@section('title', 'ORGANIZAÇÕES')

@section('image-top')
    <i class="fa fa-building"></i>
@endsection

@section('description')
@endsection

@section('buttons')

    <x-buttons.list model="company" parameter="typeCompanies" :value="$typeCompanies" :principalColor="$principalColor" />
@endsection

@section('main')
    <br>

    @if (Session::has('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed') }}
            @php
                Session::forget('failed');
            @endphp
        </div>
    @endif
    <div>
        <form action=" {{ route('company.store') }} " method="post" style="color: #874983">
            @csrf
            <div class="row mt-3 mb-3">
                <label for="">NOME: </label>
            </div>
            <div class="row">
                <input type="text" name="name" value="{{ old('name') }}">
            </div>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
            <div class="row mt-2">
                <label for="">CNPJ: </label>
            </div>
            <div class="row mt-2">
                <input type="text" name="cnpj">
            </div>
            <div class="row mt-2">
                <label for="type">Tipo de Organização:</label>
            </div>
            <div class="row mt-2">
                <select name="type" class="fields">
                    <option value="cliente" {{ old('type', $typeCompanies) == 'cliente' ? 'selected' : '' }}>Cliente
                    </option>
                    <option value="fornecedor" {{ old('type', $typeCompanies) == 'fornecedor' ? 'selected' : '' }}>
                        Fornecedor</option>
                    <option value="concorrente" {{ old('type', $typeCompanies) == 'concorrente' ? 'selected' : '' }}>
                        Concorrente</option>
                </select>
            </div>
            <div class="row mt-5 mb-3">
                <h2 class="name" for="">CONTATO</h2>
            </div>
            <label for="">Email: </label>
            <input type="text" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
            <br>
            <label for="">Email financeiro: </label>
            <input type="text" name="financial_email" value="{{ old('financial_email') }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('financial_email') }}</span>
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

            <div class="row mt-5 mb-3">
                <div class="col-md-6">
                    <h2 class="name" for="">ÁREAS DE ATUAÇÃO</h2>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col-md-6">
                    <label class="labels" for="field_of_activity_1">Área de atuação 1:</label>
                    <input type="text" name="field_of_activity_1" class="fields"
                        value="{{ old('field_of_activity_1') }}">

                    <label class="labels" for="field_of_activity_2">Área de atuação 2:</label>
                    <input type="text" name="field_of_activity_2" class="fields"
                        value="{{ old('field_of_activity_2') }}">

                    <label class="labels" for="field_of_activity_3">Área de atuação 3:</label>
                    <input type="text" name="field_of_activity_3" class="fields"
                        value="{{ old('field_of_activity_3') }}">

                    <label class="labels" for="field_of_activity_4">Área de atuação 4:</label>
                    <input type="text" name="field_of_activity_4" class="fields"
                        value="{{ old('field_of_activity_4') }}">

                    <label class="labels" for="field_of_activity_5">Área de atuação 5:</label>
                    <input type="text" name="field_of_activity_5" class="fields"
                        value="{{ old('field_of_activity_5') }}">
                </div>
            </div>

            <div class="row mt-5 mb-3">
                <h2 class="name" for="">LOCALIZAÇÃO</h2>
            </div>
            <label for="">Endereço: </label>
            <input type="text" name="address">
            <br>
            <label for="">CEP: </label>
            <input type="text" name="zip_code" value="">
            <br>
            <label for="city">Cidade: </label>
            <input type="text" name="city">
            <br>
            <label for="">Bairro: </label>
            <input type="text" name="neighborhood">
            <br>
            <label for="">Estado: </label>
            {{ createDoubleSelect('state', 'fields', $states) }}
            <br>
            <label for="">País: </label>
            <input type="text" name="country" value="Brasil">
            <br>
            <br>
            <br>
            <h2 class="name" for="">PERFIL</h2>
            <label for="">Quantidade de membros da equipe: </label>
            <input type="number" name="employees">
            <br>
            <label for="">Quantidade de clientes: </label>
            <input type="number" name="client_number">
            <br>
            <label for="">Faturamento: </label>
            <input type="number" name="revenues">
            <br>
            <label for="">Diferencial Competitivo: </label>
            <input type="text" name="competitive_advantage">
            <br>
            <label for="">Setor: </label>
            <input type="string" name="sector">
            <br>
            <label for="">Modelo de negócios: </label>
            {{ createDoubleSelect('business_model', 'fields', $businessModelTypes) }}
            <br>
            <br>
            <label class="labels" for="">Proposta de valor: </label>
            <br>
            <textarea id="description" name="value_offer" rows="5" cols="90">
		</textarea>

            <br>
            <br>
            @if ($typeCompanies != 'concorrente')
                <h2 class="name" for="">FUNCIONÁRIOS</h2>
                @foreach ($contacts as $contact)
                    <p class="fields">
                        <input type="checkbox" name="contacts[]" value="{{ $contact->id }}">
                        {{ $contact->name }}
                    </p>
                @endforeach
                <br>
                <br>
            @endif
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
    <br>
    <br>
@endsection
