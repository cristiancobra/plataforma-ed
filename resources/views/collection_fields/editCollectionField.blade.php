@extends('layouts.master')

@section('title', 'EDITAR CAMPO DOS TIPOS DE ACERVO')

@section('image-top')
    <i class="fas fa-sliders-h"></i>
@endsection

@section('buttons')
    <x-buttons.list model="collection-field" :principalColor="$principalColor" />
@endsection

@section('main')
    <form action="{{ route('collection-field.update', $field) }}" method="POST">
        @csrf
        @method('PUT')
        @include('collection_fields._form')
    </form>
@endsection
