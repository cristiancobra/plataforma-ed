@extends('layouts/master')

@section('title','BANCOS')

@section('image-top')
{{ asset('imagens/bank.png') }} 
@endsection

@section('description')
Total: <span class="labels"></span>
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('bank.create')}}">
    <i class="fas fa-plus"></i>
</a>
@endsection

@section('main')
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 10%">
                ID
            </td>
            <td   class="table-list-header" style="width: 70%">
                NOME
            </td>
            <td   class="table-list-header" style="width: 10%">
                CÓDIGO
            </td>
        </tr>

        @foreach ($banks as $bank)
        <tr>
            <td class="table-list-left">
                @if($bank->id)
                <a class="white" href=" {{route('bank.show', ['bank' => $bank->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                    {{$bank->id}}
                </a>
                @else
                no
                @endif
            </td>
            <td class="table-list-left">
                {{$bank->name}}
            </td>
            <td class="table-list-center">
                {{$bank->bank_code}}
            </td>
        </tr>
        @endforeach
    </table>
</div>
<br>
@endsection