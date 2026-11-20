@extends('layouts/master')

@section('title', 'ACERVO')

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.list model="collection" :object="$collection ?? null" :principalColor="$principalColor ?? null" />
@endsection

@section('main')
    <form action='{{ route('collection.update', $collection) }}' method='post' enctype='multipart/form-data'>
        @csrf
        @method('PUT')
        @include('collections._form')

        <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
            <x-buttons.cancel />
            <x-buttons.save />
        </div>
    </form>
@endsection
