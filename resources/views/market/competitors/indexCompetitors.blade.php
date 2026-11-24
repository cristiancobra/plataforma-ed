@extends('layouts/index')

@section('title', 'CONCORRENTES')

@section('image-top')
    <i class="fas fa-trophy"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.create model="competitor" :principalColor="$principalColor ?? null" />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-4'],
        ['label' => 'FACEBOOK', 'class' => 'col'],
        ['label' => 'INSTAGRAM', 'class' => 'col'],
        ['label' => 'LINKEDIN', 'class' => 'col'],
        ['label' => 'TWITTER', 'class' => 'col'],
        ['label' => 'PINTEREST', 'class' => 'col'],
    ]" />
    @foreach ($competitors as $competitor)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('competitor.show', ['competitor' => $competitor->id]) }}">
            <div class="col-4 fw-bold small">{{ $competitor->name }}</div>
            <div class="col text-center small">{{ $competitor->facebook_followers }}</div>
            <div class="col text-center small">{{ $competitor->instagram_followers }}</div>
            <div class="col text-center small">{{ $competitor->linkedin_followers }}</div>
            <div class="col text-center small">{{ $competitor->twitter_followers }}</div>
            <div class="col text-center small">{{ $competitor->pinterest_followers }}</div>
        </div>
    @endforeach
@endsection

@section('paginate', $competitors->links())
