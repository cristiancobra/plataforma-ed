@extends('layouts/index')

@section('title', 'CONTATOS')

@section('image-top')
    <i class="fas fa-address-book"></i>
@endsection

@section('buttons')
    <x-buttons.create model="contact" parameter="type" :value="request('type')" :principalColor="$principalColor" />
@endsection

@section('filter')
    <x-table.filter :action="route('contact.index')" :reset-url="route('contact.index')" :filters-active="$filtersActive"
        :total-filtered="$total" :total-total="$totalTotal">
        <x-filter.input name="name" placeholder="nome ou sobrenome" />
        <x-filter.select name="type" :options="$types" placeholder="Todos os tipos" />
        <x-filter.select name="company_id" :options="$companies" placeholder="Todas as organizações" />
        <x-filter.select name="lead_source" :options="$leadSources" placeholder="Todas as origens" />
        <x-filter.select name="status" :options="$statuses" placeholder="Todas as situações" />
        <x-filter.select name="filter" :options="['news' => 'Mais recentes primeiro']" placeholder="Ordem alfabética" />
    </x-table.filter>
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'ORGANIZAÇÃO', 'class' => 'col-2'],
        ['label' => 'EMAIL', 'class' => 'col-2'],
        ['label' => 'TELEFONE', 'class' => 'col-2'],
        ['label' => 'TIPO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
        ['label' => 'VER', 'class' => 'col-1'],
    ]" />
    @foreach ($contacts as $contact)
        <div class="row border-bottom align-items-center py-2">
            <div class="col-3 fw-bold">
                {{ $contact->name }}
                @if ($contact->job_position)
                    <div class="small text-muted fw-normal">{{ $contact->job_position }}</div>
                @endif
            </div>
            <div class="col-2 text-center small">
                {{ $contact->companies->pluck('name')->implode(', ') ?: '-' }}
            </div>
            <div class="col-2 text-center text-break small">
                {{ $contact->email ?: '-' }}
            </div>
            <div class="col-2 text-center">
                {{ $contact->phone ?: '-' }}
            </div>
            <div class="col-1 text-center">
                <x-table.badge :label="$contact->type" />
            </div>
            <div class="col-1 text-center">
                <x-table.badge :label="$contact->status" :colors="\App\Models\Contact::statusColors($contact->status)" />
            </div>
            <div class="col-1 text-center">
                <x-buttons.details :href="route('contact.show', $contact)" title="Visualizar" :color="$principalColor" :size="32" />
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">
        {{ $contacts->links() }}
    </div>
@endsection
