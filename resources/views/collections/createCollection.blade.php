@extends('layouts/master')

@section('title', 'ACERVO')

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.list model="collection" :principalColor="$principalColor ?? null" />
@endsection

@section('main')
    <form action='{{ route('collection.store') }}' method='post' enctype='multipart/form-data'>
        @csrf
        @include('collections._form', ['collection' => new \App\Models\Collection()])

        <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
            <x-buttons.cancel />
            <x-buttons.save title="Criar item" />
        </div>
    </form>
@endsection
