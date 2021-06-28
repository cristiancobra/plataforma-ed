@extends('layouts/master')

@section('title','MODELO DE NEGÓCIO')

@section('image-top')
{{asset('images/control-panel.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
<a class='circular-button secondary'  href='{{route('account.edit', ['account' => $account])}}'>
    <i class='fa fa-edit' aria-hidden='true'></i>
</a>
<a class='circular-button primary'  href='{{route('account.create', ['account' => $account])}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endsection

@section('main')
<div class="row">
    <div class="col-12">
        {{$account->name}}
        <br>
        {{$account->type}}
    </div>
</div>
<div class="row">
    <div class="col-4 panel-how">
        <p class='panel-title'>
            COMO?
        </p>
    </div>
    <div class="col-3 panel-what">
        <p class='panel-title'>
            O QUÊ?
        </p>
    </div>
    <div class="col-4 panel-who">
        <p class='panel-title'>
            PRA QUEM?
        </p>
    </div>
</div>
<div class="row">
    <div class="col-2 panel-how">
        <p class='panel-title'>
            FORNECEDORES
        </p>
        <ul>
            @foreach($providers as $provider)
            <li class='panel-text'>
                {{$provider->name}}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-2 panel-how">
        <p class='panel-title'>
            ATIVIDADE-CHAVE
        </p>

    </div>
    <div class="col-3 panel-what">
        <p class='panel-title'>
            PROPOSTA DE VALOR
        </p>
        <p class='panel-text'>
            {{$account->value_offer}}
        </p>
        <br>
        <br>
        <p class='panel-title'>
            DIFERENCIAL COMPETITIVO
        </p>
        <p class='panel-text'>
            {{$account->competitive_advantage}}
        </p>
    </div>
    <div class="col-2 panel-who">
        <p class='panel-title'>
            REDES SOCIAIS
        </p>
                <ul>
            @foreach($socialmedias as $socialmedia)
            <li class='panel-text'>
                {{$socialmedia->name}}
                <br>
                {{$socialmedia->socialmedia_name}}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-2 panel-who">
        <p class='panel-title'>
            SEGMENTO DE CLIENTES
        </p>
                <p class='panel-text'>
            {{$account->business_model}}
        </p>
    </div>
</div>
<div class="row">
    <div class="col-5 panel-how-much">
        <p class='panel-title'>
            DESPESAS
        </p>
            <ul>
            @foreach($expenses as $expense)
            <li class='panel-text'>
                {{$expense->name}}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-5 panel-how-much">
        <p class='panel-title'>
            RECEITAS
        </p>
                <ul>
            @foreach($revenues as $revenue)
            <li class='panel-text'>
                {{$revenue->name}}
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-12 panel-how-much">
        <p class='panel-title'>
            QUANTO
        </p>
        <p class='panel-text'>
            {{$account->revenues}}
        </p>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<div class='row mt-2 mb-2'>
    <div class='col-12 tasks-toDo'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
            <p class='panel-title'>
                PROPOSTA DE VALOR
            </p>
            <p class='panel-title'>
                {{$account->value_offer}}
            </p>
        </a>
    </div>
</div>
<div class='row mt-2 mb-2'>
    <div class='col-lg-3 d-inline-block tasks-my'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'contact_id' => '',
				'user_id' => Auth::user()->id,
				])}}'>
            <p class='panel-title'>

            </p>
            <p class='panel-title'>
                minhas
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block text-center tasks-now'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'feito',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
            <p class='panel-title'>

            </p>
            <p class='panel-title'>
                feitas
            </p>
        </a>
    </div>
</div>


<br>
<br>
@endsection