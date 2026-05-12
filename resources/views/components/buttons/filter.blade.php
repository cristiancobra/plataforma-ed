@props([
    'title' => 'Filtrar',
    'id' => 'filter_button',
    'principalColor' => '#6c757d',
])

<a id="{{ $id }}" class="btn rounded-circle" title="{{ $title }}"
    style="background-color: {{ $principalColor }}; border-color: {{ $principalColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"
    onclick="toggleFilter()" {{ $attributes }}>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>

@once
    <style>
        #filter.filter-hidden {
            display: none !important;
        }

        #filter:not(.filter-hidden) {
            display: block !important;
        }
    </style>
    <script>
        function toggleFilter() {
            const filter = document.getElementById('filter');
            if (!filter) return;

            filter.classList.toggle('filter-hidden');
        }
    </script>
@endonce