@props([
    'columns' => [],
    'backgroundColor' => null,
    'class' => '',
])

<div class="row text-center text-white p-2 mb-2 mt-5 rounded-pill align-items-center {{ $class }}"
    style="font-size: 0.9rem; background-color: {{ $backgroundColor ?? '#6c757d' }}">
    @foreach ($columns as $column)
        <div class="{{ $column['class'] ?? 'col' }} fw-bold">
            {{ $column['label'] ?? '' }}
        </div>
    @endforeach
</div>
