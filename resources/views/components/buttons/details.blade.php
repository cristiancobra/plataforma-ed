@props(['href', 'title' => 'Visualizar', 'color' => null, 'size' => 36])

@php
    $circleColor = $color ?? ($principalColor ?? '#c28dbf');
@endphp

<a href="{{ $href }}" title="{{ $title }}"
    class="d-inline-flex align-items-center justify-content-center rounded-3 border"
    style="width: {{ $size }}px; height: {{ $size }}px; border-color: {{ $circleColor }}; background: #fff;">
    <i class="fa fa-eye" aria-hidden="true" style="color: {{ $circleColor }}; font-size: {{ intval($size / 2) }}px;"></i>
</a>
