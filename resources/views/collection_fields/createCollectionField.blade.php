@extends('layouts.master')

@section('title', 'NOVO CAMPO DO ACERVO')

@section('image-top')
    <i class="fas fa-sliders-h"></i>
@endsection

@section('buttons')
    <x-buttons.list model="collection-field" :principalColor="$principalColor" />
@endsection

@section('main')
    <form action="{{ route('collection-field.store') }}" method="POST">
        @csrf
        @include('collection_fields._form')
    </form>
@endsection
