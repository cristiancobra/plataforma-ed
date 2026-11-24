@extends('layouts/index')

@section('title', 'REDES SOCIAIS')

@section('image-top')
    <i class="fas fa-share-alt"></i>
@endsection

@section('description')


    Total: <span class="labels">{{ $total }}</span>
@endsection

@section('buttons')
    <x-buttons.create model="socialmedia" :params="['type' => 'minha']" :principalColor="$principalColor ?? null" />

    <x-buttons.list model='socialmedia' :principalColor=$principalColor ?? null />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME DA REDE SOCIAL', 'class' => 'col-3'],
        ['label' => 'URL', 'class' => 'col-4'],
        ['label' => 'STUDIO DE CRIAÇÃO', 'class' => 'col-3'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-2'],
    ]" />
    @php
        $statusColors = ['publicada' => ['#E8F5E9', '#2E7D32'], 'desativada' => ['#ECEFF1', '#546E7A'], 'cancelado' => ['#FFEBEE', '#C62828']];
    @endphp
    @foreach ($socialmedias as $socialmedia)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('socialmedia.show', ['socialmedia' => $socialmedia->id]) }}">
            <div class="col-3 fw-bold small">{{ $socialmedia->socialmedia_name }}</div>
            <div class="col-4 text-center small">
                <a href="{{ $socialmedia->URL_name }}" target="_blank" onclick="event.stopPropagation()">{{ $socialmedia->URL_name }} <i class="fa fa-share-alt"></i></a>
            </div>
            <div class="col-3 text-center small">
                @if ($socialmedia->URL_studio)
                    <a href="{{ $socialmedia->URL_studio }}" target="_blank" onclick="event.stopPropagation()"><i class="fa fa-video"></i></a>
                @endif
            </div>
            <div class="col-2 text-center">
                <x-table.badge :label="$socialmedia->status" :colors="$statusColors[$socialmedia->status] ?? null" />
            </div>
        </div>
    @endforeach
@endsection

@section('paginate', $socialmedias->links())
