{{-- Card de atalho das listagens (seção "shortcuts" do layouts/index), na cor principal da conta.
     Uso: <x-shortcut :href="route('task.index', [...])" :number="$total" label="minhas pendências" /> --}}
@props(['href', 'label', 'number' => null])

<div class="col-auto mb-2">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'shortcut-card']) }}>
        @if (!is_null($number) && $number !== '')
            <span class="shortcut-card-number">{{ $number }}</span>
        @endif
        <span class="shortcut-card-label">{{ $label }}</span>
    </a>
</div>

@once
    <style>
        .shortcut-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            min-height: 64px;
            padding: 8px 14px;
            border-radius: 10px;
            background-color: var(--principal-color, #874983);
            color: #fff !important;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .15);
            transition: transform .15s ease, background-color .15s ease;
        }

        .shortcut-card:hover {
            background-color: color-mix(in srgb, var(--principal-color, #874983) 80%, black);
            transform: translateY(-1px);
        }

        .shortcut-card-number {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.1;
        }

        .shortcut-card-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .03em;
        }
    </style>
@endonce
