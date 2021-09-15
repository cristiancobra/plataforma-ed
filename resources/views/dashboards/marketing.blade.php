@extends('layouts/master')

@section('title','MARKETING')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3 ms-1 me-1'>
    
    <div class='col-2 d-inline-block sales-button'>
        <a style='text-decoration:none' href='{{route('text.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-bullhorn" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                TEXTOS DE MARKETING
            </p>
        </a>
    </div>
    
    <div class='col-2 d-inline-block sales-button'>
        <a style='text-decoration:none' href='{{route('socialmedia.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-bullhorn" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                REDES SOCIAIS
            </p>
        </a>
    </div>
    
    <div class='col-2 d-inline-block sales-button'>
        <a style='text-decoration:none' href='{{route('page.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-window-maximize" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                PÁGINAS
            </p>
        </a>
    </div>
    
    <div class='col-2 d-inline-block sales-button'>
        <a style='text-decoration:none' href='{{route('report.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-chart-pie" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                RELATÓRIOS
            </p>
        </a>
    </div>
    
    <div class='col-2 d-inline-block sales-button'>
        <a style='text-decoration:none' href='{{route('image.index')}}'>
            <p class='panel-text'>
                <i class="fas fa-cloud-upload-alt" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                <br>
                IMAGENS
            </p>
        </a>
    </div>
</div>

@endsection