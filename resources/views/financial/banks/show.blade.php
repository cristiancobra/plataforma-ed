@extends('layouts/master')

@section('title','BANCOS')

@section('image-top')
{{ asset('imagens/transaction.png') }} 
@endsection


@section('buttons')
{{createButtonBack()}}
{{createButtonList('bank')}}
@endsection

@section('main')
<br>
<div>
    <p class="labels">
        NOME:<span class="fields">{{$bank->name}}</span>
    </p>
    <p class="labels">
        CÓDIGO:<span class="fields">{{$bank->bank_code}}</span>
    </p>
    <br>
    <br>
    <p class="fields">Criado em:  {{date('d/m/Y H:i', strtotime($bank->created_at))}}
    </p>

    <div style="text-align:right;padding: 2%">
        <form   style="text-decoration: none;color: black;display: inline-block" action="{{route('bank.destroy', ['bank' => $bank->id])}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="APAGAR">
        </form>            
        <a class="btn btn-secondary" href=" {{route('bank.edit', ['bank' => $bank->id])}}">
            <i class='fa fa-edit'></i>EDITAR
        </a>
        <a class="btn btn-secondary" href="{{route('bank.index')}}"><i class="fas fa-arrow-left"></i>
        </a>
    </div>
</div>
@endsection