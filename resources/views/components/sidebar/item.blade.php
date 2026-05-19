@props(['icon', 'title', 'principalColor' => '#000', 'submenu' => null, 'id' => null])

@php
    $menuId = $id ?? 'sidebar-menu-' . md5($title . rand());
@endphp

<div class="row pt-2">
    <div class="col sidebar-item text-center {{ $submenu ? 'sidebar-menu' : 'position-relative' }}"
        style="color: {{ $principalColor }}" id="{{ $menuId }}">
        <div class="sidebar-header" style="cursor: {{ $submenu ? 'pointer' : 'default' }};">
            <i class="{{ $icon }}"></i>
            <p class="mb-0 fw-bold" style="font-size:11px;">
                {{ $title }}
            </p>
        </div>
        @if ($submenu)
            <div class="sidebar-submenu">
                @foreach ($submenu as $item)
                    <a href="{{ $item['route'] }}" style="color: {{ $principalColor }};">
                        <i class="{{ $item['icon'] }} me-1"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

@if ($submenu)
    <script>
        (function() {
            var menu = document.getElementById('{{ $menuId }}');
            if (!menu || menu.dataset.initialized) return;

            menu.dataset.initialized = 'true';
            var header = menu.querySelector('.sidebar-header');
            if (!header) return;

            menu.addEventListener('mouseenter', function() {
                menu.classList.add('show');
            });

            menu.addEventListener('mouseleave', function() {
                menu.classList.remove('show');
            });

            header.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!menu.contains(e.target)) {
                    menu.classList.remove('show');
                }
            });
        })();
    </script>
@endif

@once
    <style>
        .sidebar-menu {
            display: block;
        }

        .sidebar-submenu {
            display: none;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 0.5rem 0;
            margin: 0.5rem 0;
        }

        .sidebar-menu.show .sidebar-submenu {
            display: block;
        }

        .sidebar-submenu a {
            display: flex;
            align-items: center;
            color: inherit;
            text-decoration: none;
            padding: 8px 16px;
            font-size: 10px;
            transition: background 0.2s;
        }

        .sidebar-submenu a:hover {
            background: #f0f0f0;
        }
    </style>
@endonce
