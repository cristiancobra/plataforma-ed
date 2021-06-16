@extends('layouts/master')

@section('title','CONTAS')

@section('image-top')
{{asset('imagens/empresa.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('account')}}
@endsection

@section('main')
<form action=" {{route('account.update', ['account' => $account->id])}} " method="post">
    @csrf
    @method('put')
    <label class="labels" for="">Nome: </label>
    <input type="text" name="name"  value="{{$account->name}}">
    <br>
    <br>
    <label  class="labels" for="" >CNPJ: </label>
    <input type="text" name="cnpj"  value="{{$account->cnpj}}">
    <br>
        <label class="labels" for="">Logomarca: </label>
    {{createSelectIdName('image_id', 'fields', $logos, 'Sem logo', $account->image)}}
    <br>
    <label class="labels" for="">Cor principal: </label>
    <input type="text" name="principal_color" value="{{$account->principal_color}}">   
    <br>
    <label class="labels" for="">Cor complementar: </label>
    <input type="text" name="complementary_color" value="{{$account->complementary_color}}">   
    <br>
    <label class="labels" for="">Cor oposta: </label>
    <input type="text" name="opposite_color" value="{{$account->opposite_color}}">   
    <br>
    <br>
    <label class="labels" for="" >DESCRIÇÃO:</label>
    <textarea id="description" name="description" rows="20" cols="90">
		{{$account->description}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
CKEDITOR.replace('description');
    </script>
    <br>
    <br>
    <label class="labels" for="">Email: </label>
    <input type="text" name="email" value="{{$account->email}}">
    <br>
    <label class="labels" for="">Telefone: </label>
    <input type="text" name="phone" value="{{$account->phone}}">   
    <br>
    <label class="labels" for="">Site: </label>
    <input type="text" name="site" value="{{$account->site}}">   
    <br>
    <br>
            <h2 class="name" for="">LOCALIZAÇÃO</h2>
    <label class="labels" for="">Endereço: </label>
    <input type="text" name="address"  value="{{$account->address}}">   
    <br>
    <label class="labels" for="">Cidade: </label>
    <input type="text" name="city" value="{{$account->address_city}}">   
    <br>
    <label class="labels" for="">Estado: </label>
    {{editDoubleSelect('state', 'fields', $states, $account->state, returnStateName($account->state))}}
    <br>
    <label class="labels" for="">País: </label>
    <input type="text" name="country" value="{{$account->address_country}}">   
    <br>
    <label class="labels" for="">CEP: </label>
    <input type="text" name="zip_code" value="{{$account->zip_code}}">
    <br>
    <br>
            <h2 class="name" for="">PERFIL</h2>
    <br>
    <label class="labels" for="">Qtde empregados: </label>
    <input type="text" name="employees" value="{{$account->employees}}">
    <br>
            <label class="labels" for="">Faturamento: </label>
        <input type="number" name="revenues" value="{{$account->revenues}}">
        <br>
    <br>
    <label class="labels" for="">Setor: </label>
    <select name="sector">
        <option value="{{$account->type}}">{{$account->type}}</option>
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
    <br>
       <label class="labels"for="">Diferencial Competitivo: </label>
        <input type="text" name="competitive_advantage" value="{{$account->competitive_advantage}}">
        <br>
        <label class="labels"for="">Modelo de negócios: </label>
        {{editDoubleSelect('business_model', 'fields', $businessModelTypes, $account->business_model , $account->business_model)}}
        <br>
        <br>
        <label  class="labels" for="">Proposta de valor: </label>
        <br>
        <textarea id="description" name="value_offer" rows="20" cols="90">
{{$account->value_offer}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
    <br>
    <br>
    <label class="labels" for="status">SITUAÇÃO: </label>
{{createSimpleSelect('status', 'fields', $status, $account->status)}}
    <br>
    <br>
    <input class="btn btn-secondary" type="submit" value="ATUALIZAR">

</form>
@endsection