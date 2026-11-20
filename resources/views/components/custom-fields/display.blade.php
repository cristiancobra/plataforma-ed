{{-- Exibe os valores dos campos personalizados de um item de acervo (só os preenchidos). --}}
@props(['fields', 'values' => []])

@php
    $values = $values ?? [];
    $filled = $fields->filter(fn ($field) => array_key_exists($field->key, $values));
@endphp

@if ($filled->isNotEmpty())
    <div class="row">
        @foreach ($filled as $field)
            <div class="col-md-6">
                <p>
                    <strong>{{ $field->label }}:</strong>
                    @if ($field->type === \App\Enums\CustomFieldType::Url)
                        <a href="{{ $values[$field->key] }}" target="_blank" rel="noopener">{{ $values[$field->key] }}</a>
                    @elseif ($field->type === \App\Enums\CustomFieldType::Textarea)
                        {!! nl2br(e($values[$field->key])) !!}
                    @else
                        {{ $field->displayValue($values) }}
                    @endif
                </p>
            </div>
        @endforeach
    </div>
@endif
