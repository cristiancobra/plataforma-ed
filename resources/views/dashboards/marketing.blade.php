@extends('layouts/master')

@section('title','FINANCEIRO')

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3 ms-1 me-1'>

    <div class='financial-display col-3'>
    <div>
        <div style='display: inline-block;float: left;width: 20%'>
            <img class='financial-image' src="{{asset('images/financial-planning.png')}}">
        </div>
        <div style='display: inline-block;float:left;width: 40%;padding-left: 10px'>
            <p style="color:white;font-size: 15px;text-align: left">
                VENDIDO:
                <br>
                COMPROMETIDO:
                <br>
                SALDO:
            </p>
        </div>
        <div style='display: inline-block;float:right;width: 30%'>
            <p style="color:white;font-size: 15px;text-align: right">
                
                <br>
                
                <br>
                
        </div>
    </div>
    </div>
    
    <div class='col-2 d-inline-block sales-button'>
        <a style='text-decoration:none' href='{{route('text.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-bullhorn" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                TEXTOS DE MARKETING
            </p>
        </a>
    </div>

  
</div>

@endsection