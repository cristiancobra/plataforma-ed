@extends('layouts/master')

@section('title','CAMPANHAS')

@section('image-top')
{{asset('imagens/campaign.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='button-primary'  href='{{route('campaign.index')}}'>
    VOLTAR
</a>
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
    <h1 class='name'>
        {{$campaign->name}}
    </h1>
    <p class='labels'>
        EMPRESA:<span class='fields'>{{$campaign->account->name}}</span>
    </p>
    <p class='labels'>
        RESPONSÁVEL:<span class='fields'>{{$campaign->user->contact->name}}</span>
    </p>
    <br>
    <div class='labels' style='background-color: #d7bde2 ;padding: 1%'>
        TÍTULO:
        <br>
        {{$campaign->email->title}}
        <br>
        <br>
        MENSAGEM:
        <br>
        <br>
        {!!html_entity_decode($campaign->email->message)!!}
    </div>
    <br>
    <br>
    <p class='labels'>
        DATA DE ENVIO:<span class='fields'>{{dateBR($campaign->send_date)}}</span>
    </p>
    <br>
    <br>
    <p class='labels'>
        SITUAÇAO:<span class='fields'>{{$campaign->status}}</span>
    </p>
    <br>
    <div style="text-align:right;padding: 2%">
        <form   style="text-decoration: none;color: black;display: inline-block" action="{{route('campaign.destroy', ['campaign' => $campaign->id])}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="APAGAR">
        </form>
        <form  style="text-decoration: none;display: inline-block" action="{{route('campaign.send')}}" method="post">
            @csrf
            <input type='hidden' name='account' value='{{$account->id}}'>
            <input type='hidden' name='contact' value='{{$contact->id}}'>
            <input type='hidden' name='email' value='{{$campaign->email_id}}'>
            {{submitFormButton('ENVIAR')}}
        </form>
        <a class="button-secondary" href=" {{route('campaign.edit', ['campaign' => $campaign->id])}}" style="text-decoration: none;color: white;display: inline-block">
            <i class='fa fa-edit'></i>EDITAR
        </a>
        <a class="button-secondary" href="{{route('campaign.index')}}">
            VOLTAR
        </a>
    </div>
    <br>
    <br>
</div>
@endsection