@extends('layouts/index')

@section('title', 'USUÁRIOS')

@section('image-top')
    <i class="fas fa-users"></i>
@endsection

@section('description')
    @isset($total)
        Total: <span class='labels'>{{ $total }} </span>
    @endisset
@endsection

@section('buttons')
    <a class='circular-button secondary' href='{{ route('user.index') }}'>
        <i class='fas fa-arrow-left'></i>
    </a>
    <x-buttons.create model="user" :principalColor="$principalColor ?? null" />
@endsection

@section('table')
    <form action="{{ route('user.index') }}" method="post" class="mb-4">
        @csrf
        <div class="row g-2 align-items-end p-3 shadow-sm rounded">
            <x-filter.input name="user_name" placeholder="nome ou sobrenome" />
            <div class="col-auto">
                <button class="btn btn-sm" type="submit" style="background-color: {{ $principalColor }}; color: #fff;">
                    <i class="fa fa-filter me-1" aria-hidden="true"></i> FILTRAR
                </button>
            </div>
        </div>
    </form>
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'FOTO', 'class' => 'col-1'],
        ['label' => 'NOME', 'class' => 'col-4'],
        ['label' => 'PERFIL', 'class' => 'col-2'],
        ['label' => 'EMAIL', 'class' => 'col-5'],
    ]" />
    @foreach ($users as $user)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('user.show', ['user' => $user->id]) }}">
            <div class="col-1 text-center">
                <x-user.avatar :user="$user" />
            </div>
            <div class="col-4 fw-bold small">{{ $user->contact->name }}</div>
            <div class="col-2 text-center small">{{ $user->perfil }}</div>
            <div class="col-5 small">
                <a href="mailto:{{ $user->email }}" target="_blank" onclick="event.stopPropagation()"><i class="fa fa-envelope me-1"></i>{{ $user->email }}</a>
            </div>
        </div>
    @endforeach
@endsection

@section('paginate', $users->links())
