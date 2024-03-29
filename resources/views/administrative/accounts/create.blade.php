@extends('layouts/master')

@section('title','CONTAS')

@section('image-top')
{{ asset('images/empresa.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('account')}}
@endsection

@section('main')
<form action=" {{route('account.store')}} " method="post">
    @csrf
    <label for="" >Nome: </label>
    <input type="text" name="name">
    <br>
    <label for="" >CNPJ: </label>
    <input type="text" name="cnpj">
    <br>
    <label for="" >Email: </label>
    <input type="text" name="email">
    <br>
    <label for="">Telefone: </label>
    <input type="text" name="phone">   
    <br>
    <label for="">WhatsApp para vendas: </label>
    <input type="text" name="whatsapp_sales">   
    <br>
    <label for="">Site: </label>
    <input type="text" name="site">   
    <br>
    <br>
    <label for="">Endereço: </label>
    <input type="text" name="address">   
    <br>
    <label for="">Cidade: </label>
    <input type="text" name="city">   
    <br>
    <label for="">Estado: </label>
    {{createDoubleSelect('state', 'fields', $states)}}
    <br>
    <label for="">País: </label>
    <input type="text" name="country" value="Brasil">   
    <br>
    <label class="labels" for="">CEP: </label>
    <input type="text" name="zip_code">
    <br>
    <br>
    <label for="">Segmento: </label>
    <select name="type">
        <option value=""></option>
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
    <label for="">Qtde empregados: </label>
    <input type="text" name="employees">   
    <br>
    <label for="">Faturamento: </label>
    <input type="text" name="revenues">   
    <br>
    <br>
    <label for="">Logomarca: </label>
    {{createSelectIdName('image_id', 'fields', $logos, 'Sem logo')}}
    <br>
    <label for="">
        Cor principal (escura): 
    </label>
    <input type="text" name="principal_color" value="#874983">   
    <br>
    <label for="">
        Cor secundária: 
    </label>
    <input type="text" name="complementary_color" value="#c28dbf">   
    <br>
    <label for="">
        Cor oposta: 
    </label>
    <input type="text" name="opposite_color" value="#49d194">
    <br>
    <br>
    <label class="labels" for="" >Funcionários: </label>
    <br>
    @foreach ($users as $user)
    <p class="fields">
        <input type="checkbox" name="users[]" value="{{ $user->id }}">
        {{ $user->name }}
    </p>
    @endforeach
    <br>
    <br>
    <label class="labels" for="status">SITUAÇÃO: </label>
    <select class="fields" name="status">
        <option value="ativo">ativo</option>
        <option value="pendente">pendente</option>
        <option value="desativado">desativado</option>
    </select>
    <br>
    <br>
    <input class="btn btn-secondary" type="submit" value="Solicitar empresa">
</form>
@endsection