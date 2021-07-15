@extends('layouts/index')

@section('title','IMPORTAR CONTATOS')

@section('image-top')
{{asset('images/record.png')}} 
@endsection

@section('buttons')
@endsection


@section('table')
<div class='row mt-2'>
    <div class="col">
        <label class='labels' for='account_id'>EMPRESA: </label>
        <input type='hidden' name='account_id' value='{{$account->id}}'>
        {{$account->name}}
    </div>
</div>
<div class='row'>
    <div class="col">
        <label class='labels' for='total'>TOTAL: </label>
        {{$recordsTotal}} contatos
    </div>
</div>
<div class="row mt-5">
    <form action='{{route('contact.storecsv')}}' method='post'>
        @csrf
        <button class='btn btn-secondary' type='submit' value='IMPORTAR'>
            IMPORTAR
        </button>
        <br>
        <br>
        <table class="table-list">
            <tr>
                <td   class="table-list-header" style="width: 5%">
                    
                </td>
                <td   class="table-list-header" style="width: 10%">
                    NOME
                </td>
                <td   class="table-list-header" style="width: 15%">
                    SOBRENOME
                </td>
                <td   class="table-list-header" style="width: 20%">
                    ENDEREÇO
                </td>
                <td   class="table-list-header" style="width: 10%">
                    CIDADE
                </td>
                <td   class="table-list-header" style="width: 10%">
                    ESTADO
                </td>
                <td   class="table-list-header" style="width: 10%">
                    PAÍS
                </td>
                <td   class="table-list-header" style="width: 20%">
                    EMAIL
                </td>
                <td   class="table-list-header" style="width: 15%">
                    TELEFONE
                </td>
                <td   class="table-list-header" style="width: 15%">
                    CEP
                </td>
                <td   class="table-list-header" style="width: 15%">
                    GÊNERO
                </td>
                <td   class="table-list-header" style="width: 15%">
                    CPF
                </td>
            </tr>
          @php
                    $counter = 0;
                    @endphp
            @foreach ($records as $record)
            <input type="hidden" name="account_id[]" value="{{$account->id}}">
            <tr style="font-size: 14px">
                <td class="table-list-left">
                    @php
                    $counter += 1;
                    @endphp
                    {{$counter}}
                </td>
                <td class="table-list-left">
                            <input type="hidden" name="first_name[]" value="{{$record['nome']}}">
                    {{$record['nome']}}
                </td>
                <td class="table-list-left">
                            <input type="hidden" name="last_name[]" value="{{$record['sobrenome']}}">
                    {{$record['sobrenome']}}
                </td>
                <td class="table-list-left">
                    <input type="hidden" name="address[]" value="{{$record['endereco']}}">
                    {{$record['endereco']}}
                </td>
                <td class="table-list-left">
                    <input type="hidden" name="city[]" value="{{$record['cidade']}}">
                    {{$record['cidade']}}
                </td>
                <td class="table-list-left">
                    <input type="hidden" name="state[]" value="{{$record['estado']}}">
                    {{$record['estado']}}
                </td>
                <td class="table-list-left">
                    <input type="hidden" name="country[]" value="{{$record['pais']}}">
                    {{$record['pais']}}
                </td>

                <td class="table-list-left">
                    <input type="hidden" name="email[]" value="{{$record['email']}}">
                    {{$record['email']}}
                </td>
                <td class="table-list-right">
                    <input type="hidden" name="phone[]" value="{{$record['telefone']}}">
                    {{$record['telefone']}}
                </td>
                <td class="table-list-right">
                    <input type="hidden" name="zip_code[]" value="{{$record['cep']}}">
                    {{$record['cep']}}
                </td>
                <td class="table-list-right">
                    <input type="hidden" name="gender[]" value="{{$record['genero']}}">
                    {{$record['genero']}}
                </td>
                <td class="table-list-right">
                    <input type="hidden" name="cpf[]" value="{{$record['cpf']}}">
                    {{$record['cpf']}}
                </td>
            </tr>
            @endforeach
        </table>
        <br>
        <button class='btn btn-secondary' type='submit' value='IMPORTAR'>
            IMPORTAR
        </button>
    </form>
</div>
    @endsection
