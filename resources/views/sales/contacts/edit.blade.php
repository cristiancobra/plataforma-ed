@extends('layouts/master')

@section('title', 'CONTATOS')

@section('image-top')
    <i class="fas fa-address-book"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.list model="contact" :principalColor="$principalColor" />
@endsection

@section('main')
    <form action="{{ route('contact.update', $contact) }}" method="post">
        @csrf
        @method('PUT')
        @include('sales.contacts._form')

        <div class="d-flex gap-2 justify-content-end align-items-center mt-4">
            <x-buttons.cancel />
            <x-buttons.save :principalColor="$principalColor" />
        </div>
    </form>
@endsection
