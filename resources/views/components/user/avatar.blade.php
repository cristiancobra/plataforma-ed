@props([
    'user' => null,
    'missingLabel' => 'membro da equipe excluído',
    'principalColor' => null,
])

@php
    $contactId = $user->contact->id ?? null;
    $contactUrl = $contactId ? route('contact.show', ['contact' => $contactId]) : null;
@endphp

@if (isset($user->image))
    @if ($contactUrl)
        <a href="{{ $contactUrl }}" title="Ver contato">
    @endif
    <div class='d-inline-block border border-3 rounded-circle position-relative overflow-hidden text-nowrap'
        style='width: 36px; height: 36px; border-color: {{ $principalColor ?? '#c28dbf' }} !important;'>
        <img src='{{ asset($user->image->path) }}' class='w-100 h-100' alt='Avatar do usuário'>
    </div>
    @if ($contactUrl)
        </a>
    @endif
@else
    @if ($contactUrl)
        <a href="{{ $contactUrl }}" title="Ver contato">
    @endif
    <div class='d-inline-flex align-items-center justify-content-center rounded-circle text-white text-center overflow-hidden'
        style='width: 36px; height: 36px; background-color: {{ $principalColor ?? '#c28dbf' }};'>
        <span class='fw-bold px-1' style='font-size: 10px; line-height: 1.2;'>
            {{ $user->contact->name ?? $missingLabel }}
        </span>
    </div>
    @if ($contactUrl)
        </a>
    @endif
@endif
