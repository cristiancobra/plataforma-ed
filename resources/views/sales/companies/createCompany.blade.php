@extends('layouts/master')

@section('title', 'ORGANIZAÇÕES')

@section('image-top')
    <i class="fa fa-building"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.list model="company" parameter="typeCompanies" :value="$typeCompanies" :principalColor="$principalColor" />
@endsection

@section('main')
    <form action="{{ route('company.store') }}" method="post">
        @csrf
        @include('sales.companies._form')

        <div class="d-flex gap-2 justify-content-end align-items-center mt-4">
            <x-buttons.cancel />
            <x-buttons.save title="Criar organização" :principalColor="$principalColor" />
        </div>
    </form>
@endsection
