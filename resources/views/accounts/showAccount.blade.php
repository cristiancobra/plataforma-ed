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
<div class="row">
    <div class="col-12">
        <h1 style="text-align:left;color: #874983;margin-bottom: 20px">
            {{$account->name}}
        </h1>
    </div>
</div>
<div class="row mb-2 mt-2">
    <div class="col-12">
        <h5>
            <i class="fas fa-rocket"></i>
            SERVIÇOS CONTRATADOS
        </h5>
    </div>
</div>
<div class="row mb-2 mt-2">
    <div class='tb tb-header-start col-2'>
        IDENTIFICADOR
    </div>
    <div class='tb tb-header col-4'>
        DATA CRIAÇÃO 
    </div>
    <div class='tb tb-header col-2'>
        DATA PAGAMENTO
    </div>
    <div class='tb tb-header col-1'>
        VALOR DA FATURA
    </div>
    <div class='tb tb-header col-2'>
        PREÇO
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($invoiceLines as $invoiceLine)
<div class='row'>
    <div class='tb col-12 text-left'>
        <button class="button-round">
            <a href=" {{route('invoice.show', ['invoice' => $invoiceLine->invoice_id])}}">
                <i class='fa fa-eye' style="color:white"></i>
            </a>
        </button>
        @if($invoiceLine->invoice)
        FATURA {{$invoiceLine->invoice->id}}
        @else
        FATURA com problema
        @endif
    </div>
</div>
    <div class='row'>
    <div class='tb col-3'>
        {{$invoiceLine->product->name}}
    </div>
    <div class='tb col-3'>
        {{$invoiceLine->amount}}
    </div>
    <div class='tb col-3'>
        {{$invoiceLine->subtotalPrice}}
    </div>
    <div class='tb col-3 text-right'>
        {{formatCurrencyReal($invoiceLine->subtotalPrice)}}
    </div>
    {{formatTableStatus($invoiceLine)}}
</div>
@endforeach
<div class='row'>
    <div class='tb-footer'></div>
</div>
</div>
<br>
<br>




<p style="text-align:left;color: #874983">
    CNPJ:  {{formatCnpj($account->cnpj)}}
</p>
<p style="text-align:left;color: #874983">
    Descrição:  {{$account->description}}
</p>
<p style="text-align:left;color: #874983">
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
<p style="text-align:left;color: #874983">
    Email:  {{$account->email}}
</p>
<p style="text-align:left;color: #874983">
    Telefone:  {{$account->phone}}
</p>
<p style="text-align:left;color: #874983">
    Site:  {{$account->site}}
</p>
<p style="text-align:left;color: #874983">
    Endereço:  {{$account->address}}
</p>
<p style="text-align:left;color: #874983">
    Cidade:  {{$account->city}}
</p>
<p style="text-align:left;color: #874983">
    Estado:  {{returnStateName($account->state)}}
</p>
<p style="text-align:left;color: #874983">
    País:  {{$account->country}}
</p>
<p style="text-align:left;color: #874983">
    CEP:  {{$account->zip_code}}
</p>
<br>
<p style="text-align:left;color: #874983">
    Segmento:  {{$account->type}}
</p>
<p style="text-align:left;color: #874983">
    Qtde empregados:  {{$account->employees}}
</p>
<p style="text-align:left;color: #874983">
    Faturamento:  {{$account->revenues}}
</p>
<br>
<p style="text-align:left;color: #874983">
    Logomarca:  <img src="{{asset($account->image->path)}}" width="180px" height="60px" style="background-color:gainsboro;border-radius: 10px">
</p>
<p style="text-align:left;color: #874983">
    Cor principal: 
    <button type="button" style="color:white;background-color:{{$account->principal_color}};display: inline-block;border-radius:50%">P</button> {{$account->principal_color}}
</p>
<p style="text-align:left;color: #874983">
    Cor complementar: 
    <button type="button" style="color:white;background-color:{{$account->complementary_color}};display: inline-block;border-radius:50%">C</button> {{$account->complementary_color}}
</p>
<p style="text-align:left;color: #874983">
    Cor oposta: 
    <button type="button" style="color:{{$account->principal_color}};background-color:{{$account->opposite_color}};display: inline-block;border-radius:50%">O</button> {{$account->opposite_color}}
</p>
<br>
<p class="labels">SITUAÇAO:<span class="fields">  {{$account->status}} </span></p>
<br>
<p style="text-align:left;color: #874983">
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