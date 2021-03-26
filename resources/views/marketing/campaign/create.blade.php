@extends('layouts/master')

@section('title','CAMPANHAS')

@section('image-top')
{{asset('imagens/campaign.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('campaign.index')}}">
    VOLTAR
</a>
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
    <form action="{{route('campaign.store')}}" method="post" style="color: #874983">
        @csrf
        <label for="" >NOME: </label>
        <input name='name' type='text'>
        <br>
        <label for="" >DONO: </label>
        <select name="account_id">
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label for="" >RESPONSÁVEL: </label>
        <select name="user_id">
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label for="" >EMAIL MODELO: </label>
        <select name="email_id">
            @foreach ($emails as $email)
            <option  class="fields" value="{{$email->id}}">
                {{$email->title}}
            </option>
            @endforeach
        </select>
        <br>
        <label for="" >DATA DE ENVIO: </label>
        <input name='send_date' type='date'>
        <br>
        <br>
        <label for="status">SITUAÇÃO: </label>
        {{createSelect('status', 'fields', returnCampaignStatus())}}
        <br>
        <br>
        {{submitFormButton('CRIAR')}}
    </form>
</div>
@endsection