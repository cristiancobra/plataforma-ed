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
<br>
<h1 style="text-align:left;color: #874983;padding-left: 30px">
     {{$account->name}}
</h1>
<p style="text-align:left;color: #874983;padding-left: 30px">
    CNPJ:  {{formatCnpj($account->cnpj)}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Descrição:  {{$account->description}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Colaboradores: 
</p>
@foreach ($account->users as $user)
<a  class="white" href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank">
    <button class="button-round">
        <i class='fas fa-comment-dots'></i>
    </button>
</a>

<a  class="white" href=" {{route('user.show', ['user' => $user->id])}}">
    <button class="button-round">
        <i class='fa fa-eye'></i>
    </button>
</a>
{{$user->contact->name}}
<br>
@endforeach	
<br>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Email:  {{$account->email}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Telefone:  {{$account->phone}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Site:  {{$account->site}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Endereço:  {{$account->address}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Cidade:  {{$account->city}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Estado:  {{returnStateName($account->state)}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    País:  {{$account->country}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    CEP:  {{$account->zip_code}}
</p>
<br>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Segmento:  {{$account->type}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Qtde empregados:  {{$account->employees}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Faturamento:  {{$account->revenues}}
</p>
<br>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Logomarca:  <img src="{{asset($account->image->path)}}" width="180px" height="60px">
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Cor principal: 
    <button type="button" style="color:white;background-color:{{$account->principal_color}};display: inline-block;border-radius:50%">P</button> {{$account->principal_color}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Cor complementar: 
    <button type="button" style="color:white;background-color:{{$account->complementary_color}};display: inline-block;border-radius:50%">C</button> {{$account->complementary_color}}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Cor oposta: 
    <button type="button" style="color:{{$account->principal_color}};background-color:{{$account->opposite_color}};display: inline-block;border-radius:50%">O</button> {{$account->opposite_color}}
</p>
<br>
<p class="labels">SITUAÇAO:<span class="fields">  {{$account->status}} </span></p>
<br>
<p style="text-align:left;color: #874983;padding-left: 30px">
    Criado em:   {{date('d/m/Y H:i', strtotime($account->created_at))}}
</p>

<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
    <a href="{{route('account.edit', ['account' => $account->id])}}"  style="text-decoration: none;color: black">
        <button class="btn btn-secondary">
            <i class='fa fa-edit'></i>EDITAR
        </button>	
    </a>
    <a href="{{route('account.index')}}"  style="text-decoration: none;color: black">
        <button class="btn btn-secondary">
            <i class='fa fa-edit'></i>VOLTAR
        </button>	
    </a>
</div>
<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
    <form action="" method="post">
        @csrf
        @method('delete')
        <input class="button-delete" type="submit" value="APAGAR">
    </form>
</div>
<br>
@endsection