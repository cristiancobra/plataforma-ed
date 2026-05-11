@props([
    'variant' => 'primary',
    'title' => '',
    'href' => null,
    'icon' => null,
    'submit' => false,
])

@if ($href)
    <a class='btn btn-{{ $variant }} rounded-circle' title='{{ $title }}' href='{{ $href }}'
        {{ $attributes }}>
        @if ($icon)
            <i class='{{ $icon }}'></i>
        @else
            {{ $slot }}
        @endif
    </a>
@elseif($submit)
    <button class='btn btn-{{ $variant }} rounded-circle' title='{{ $title }}' type='submit'
        {{ $attributes }}>
        @if ($icon)
            <i class='{{ $icon }}'></i>
        @else
            {{ $slot }}
        @endif
    </button>
@else
    <button class='btn btn-{{ $variant }} rounded-circle' title='{{ $title }}' type='button'
        {{ $attributes }}>
        @if ($icon)
            <i class='{{ $icon }}'></i>
        @else
            {{ $slot }}
        @endif
    </button>
@endif
