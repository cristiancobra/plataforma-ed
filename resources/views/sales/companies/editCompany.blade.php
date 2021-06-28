@extends('layouts/master')

@if($typeCompanies == 'cliente')
@section('title','EMPRESAS')
@elseif($typeCompanies == 'fornecedor')
@section('title','FORNECEDORES')
@elseif($typeCompanies == 'cliente e fornecedor')
@section('title','CLIENTE FORNECEDOR')
@elseif($typeCompanies == 'concorrente')
@section('title','CONCORRENTES')
@endif

@section('image-top')
{{asset('images/empresa.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('company', 'typeCompanies', $typeCompanies)}}
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
    <form action=" {{route('company.update', ['company' => $company->id])}} " method="post">
        @csrf
        @method('put')
        <label for="" >NOME: </label>
        <input type="text" name="name" value="{{$company->name}}" style="width: 600px">
        @if ($errors->has('name'))
        <span class="text-danger">{{ $errors->first('name') }}</span>
        @endif
        <br>
        <br>
        <label for="status">TIPO: </label>
        {{createSimpleSelect('type',' fields', $types, $company->type)}} 
        <br>
        <label for="" >CNPJ: </label>
        <input type="text" name="cnpj" value="{{$company->cnpj}}">
        <br>
        <br>
        <h2 class="name" for="">CONTATOS</h2>

        <br>
        <label for="" >Email: </label>
        <input type="text" name="email" value="{{$company->email}}">
        @if ($errors->has('email'))
        <span class="text-danger">{{$errors->first('email')}}</span>
        @endif
        <br>
        <label for="" >Email financeiro: </label>
        <input type="text" name="financial_email" value="{{$company->financial_email}}">
        @if ($errors->has('email'))
        <span class="text-danger">{{$errors->first('financial_email')}}</span>
        @endif
        <br>
        <label for="">Telefone: </label>
        <input type="text" name="phone" value="{{$company->phone}}">
        <br>
        <label for="">Site: </label>
        <input type="text" name="site" value="{{$company->site}}">
        <br>
        <label for="">Instagram: </label>
        <input type="text" name="instagram" value="{{$company->instagram}}">
        <br>
        <label for="">Facebook: </label>
        <input type="text" name="facebook" value="{{$company->facebook}}">
        <br>
        <label for="">Linkedin: </label>
        <input type="text" name="linkedin" value="{{$company->linkedin}}">
        <br>
        <label for="">Twitter: </label>
        <input type="text" name="twitter" value="{{$company->twitter}}">
        <br>
        <br>
        <br>

        <h2 class="name" for="">LOCALIZAÇÃO</h2>
        <label for="">Endereço: </label>
        <input type="text" name="address" value="{{$company->address}}">
        <br>
        <label for="" >CEP: </label>
        <input type="text" name="zip_code" value="{{$company->zip_code}}">
        <br>
        <label for="city">Cidade: </label>
        <input type="text" name="city" value="{{$company->city}}">
        <br>
        <label for="">Bairro: </label>
        <input type="text" name="neighborhood" value="{{$company->neighborhood}}">
        <br>
        <label for="">Estado: </label>
        {{editDoubleSelect('state', 'fields', $states, $company->state, returnStateName($company->state))}}
        <br>
        <label for="">País: </label>
        <input type="text" name="country"  value="{{$company->country}}">
        <br>
        <br>
        <h2 class="name" for="">PERFIL</h2>
        <label for="">Quantidade de empregados: </label>
        <input type="number"  style="text-align: right" name="employees" value="{{$company->employees}}">
        <br>
        <br>
        <label for="">Quantidade de clientes: </label>
        <input type="number" name="client_number" value="{{$company->client_number}}">
        <br>
        <br>
        <label for="">Faturamento: </label>
        <input type="number" name="revenues" value="{{$company->revenues}}">
        <br>
        <label class="labels" for="">Setor: </label>
        <select name="sector">
            <option value="{{$company->type}}">{{$company->type}}</option>
            <option value="agricultura">Agricultura</option>
            <option value="biotecnologia">Biotecnologia</option>
            <option value="química">Substâncias e produtos químicos</option>
            <option value="aeroespacial">Aeroespacial</option>
            <option value="hardware">Computadores e hardware</option>
            <option value="construção">Construção</option>
            <option value="consultoria">Consultoria</option>
            <option value="produtos de consumo">Produtos de consumo</option>
            <option value="serviços ao consumidor">Serviços ao consumidor</option>
            <option value="marketing digital">Marketing digital</option>
            <option value="educação">Educação</option>
            <option value="eletrônica">Eletrônica</option>
            <option value="moda">Moda</option>
            <option value="serviços financeiros">Serviços financeiros</option>
            <option value="alimentos e bebidas">Alimentos e bebidas</option>
            <option value="jogos">Jogos</option>
            <option value="serviços de saúde">Serviços de saúde</option>
            <option value="indústria">Indústria</option>
            <option value="internet/serviços da web">Internet/serviços da web</option>
            <option value="serviços de TI">Serviços de TI</option>
            <option value="jurídico">Jurídico</option>
            <option value="estilo de vida">Estilo de vida</option>
            <option value="marítimo">Marítimo</option>
            <option value="marketing/publicidade">Marketing/publicidade</option>
            <option value="mídias e entretenimento">Mídias e entretenimento</option>
            <option value="mineração">Mineração</option>
            <option value="petróleo e gás">Petróleo e gás</option>
            <option value="política">Política</option>
            <option value="imóveis">Imóveis</option>
            <option value="varejo/distribuição">Varejo/distribuição</option>
            <option value="segurança">Segurança</option>
            <option value="software">Software</option>
            <option value="esportes">Esportes</option>
            <option value="telecomunicações">Telecomunicações</option>
            <option value="transportes">Transportes</option>
            <option value="turismo">Turismo</option>
            <option value="outros">Outros</option>
        </select>
        <br>
        <label for="">Diferencial Competitivo: </label>
        <input type="text" name="competitive_advantage" value="{{$company->competitive_advantage}}">
        <br>
        <label for="">Modelo de negócios: </label>
        {{editDoubleSelect('business_model', 'fields', $businessModelTypes, $company->business_model , $company->business_model)}}
        <br>
        <br>
        <label  class="labels" for="">Proposta de valor: </label>
        <br>
        <textarea id="description" name="value_offer" rows="20" cols="90">
{{$company->value_offer}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <label for="status">SITUAÇÃO: </label>
        <select class="fields" name="status">
            <option value="{{$company->status}}">{{$company->status}}</option>
            <option value="ativo">ativo</option>
            <option value="pendente">pendente</option>
            <option value="desativado">desativado</option>
        </select>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
</div>
<br>
<br>
@endsection
