@extends('layouts/master')

@if($typeCompanies == 'cliente')
@section('title','EMPRESAS')
@else
@section('title','FORNECEDORES')
@endif

@section('image-top')
{{asset('imagens/empresa.png')}} 
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
    <form action="{{route('company.update', [
        'company' => $company->id,
         'typeCompanies' => $typeCompanies,
            ])}}" method="post">
        @csrf
        @method('put')
        <label for="type">TIPO: </label>
        <select class="fields" name="type">
            <option value="{{$company->type}}">
                {{$company->type}}
            </option>
            <option value="cliente">
                cliente
            </option>
            <option value="fornecedor">
                fornecedor
            </option>
            <option value="cliente e fornecedor">
                cliente e fornecedor
            </option>
        </select>
        <br>
        <label for="" >DONO: </label>
        <select name="account_id">
            <option  class="fields" value="{{$company->account_id}}">
                {{$company->account->name}}
            </option>
            @foreach ($accounts as $account)
            <option  class="fields" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <br>
        <label for="" >NOME: </label>
        <input type="text" name="name" value="{{$company->name}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{ $errors->first('name') }}</span>
        @endif
        <br>
        <label for="" >CNPJ: </label>
        <input type="text" name="cnpj" value="{{$company->cnpj}}">
        <br>
        <label for="" >CEP: </label>
        <input type="text" name="zip_code" value="{{$company->zip_code}}">
        <br>
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
        <label for="city">Cidade: </label>
        <input type="text" name="city" value="{{$company->city}}">
        <br>
        <label for="">Bairro: </label>
        <input type="text" name="neighborhood" value="{{$company->neighborhood}}">
        <br>
        <label for="">Estado: </label>
        {{editDoubleSelect('address_state', 'fields', $states, $company->address_state, returnStateName($company->address_state))}}
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
        <label for="status">SITUAÇÃO: </label>
        {{createSimpleSelect('status', 'fields', returnStatusActive(), $company->status)}}
        <br>
        <br>
        <div style="text-align:right">
            <button class='circular-button primary' type='submit'>
            <i class='fa fa-check'></i>
        </button>
        </div>
    </form>
</div>
<br>
<br>
@endsection