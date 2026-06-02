@props(['icon', 'title', 'principalColor' => '#000', 'submenu' => null, 'id' => null])

@php
    $menuId = $id ?? 'sidebar-menu-' . md5($title . rand());
@endphp

<div class="row pt-2">
    <div class="col sidebar-item text-center {{ $submenu ? 'sidebar-menu' : 'position-relative' }}"
        style="color: {{ $principalColor }}" id="{{ $menuId }}">
        <div class="sidebar-header" style="cursor: {{ $submenu ? 'pointer' : 'default' }};">
            <i class="{{ $icon }}"></i>
            <p class="mb-0 fw-bold" style="font-size:10px;">
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
            var submenu = menu.querySelector('.sidebar-submenu');
            var hideTimeout = null;
            if (!header) return;

            var openMenu = function() {
                if (hideTimeout) {
                    clearTimeout(hideTimeout);
                    hideTimeout = null;
                }
                menu.classList.add('show');
            };

            var closeMenu = function(delay) {
                if (hideTimeout) {
                    clearTimeout(hideTimeout);
                }
                hideTimeout = setTimeout(function() {
                    menu.classList.remove('show');
                    hideTimeout = null;
                }, delay || 0);
            };

            menu.addEventListener('mouseenter', function() {
                openMenu();
            });

            menu.addEventListener('mouseleave', function() {
                closeMenu(220);
            });

            if (submenu) {
                submenu.addEventListener('mouseenter', function() {
                    openMenu();
                });

                submenu.addEventListener('mouseleave', function() {
                    closeMenu(120);
                });
            }

            header.addEventListener('click', function(e) {
                e.stopPropagation();
                if (menu.classList.contains('show')) {
                    closeMenu(0);
                } else {
                    openMenu();
                }
            });

            document.addEventListener('click', function(e) {
                if (!menu.contains(e.target)) {
                    closeMenu(0);
                }
            });
        })();
    </script>
@endif

@once
    <style>
        .sidebar-menu {
            display: block;
            position: relative;
        }

        .sidebar-header {
            border-radius: 12px;
            padding: 8px 6px;
            transition: background-color 0.2s ease;
        }

        .sidebar-menu.show .sidebar-header,
        .sidebar-header:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        .sidebar-submenu {
            display: none;
            position: absolute;
            left: 100%;
            margin-left: 4px;
            top: 0;
            min-width: 280px;
            max-width: 360px;
            max-height: 70vh;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #e6ebf2;
            border-radius: 12px;
            box-shadow: 0 18px 35px rgba(16, 24, 40, 0.15);
            padding: 0.5rem 0;
            margin-top: 0;
            text-align: left;
            z-index: 1040;
        }

        .sidebar-menu.show .sidebar-submenu {
            display: block;
        }

        .sidebar-submenu a {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: inherit;
            text-decoration: none;
            padding: 8px 16px;
            font-size: 11px;
            line-height: 1.35;
            text-align: left;
            transition: background 0.2s;
        }

        .sidebar-submenu a i {
            width: 16px;
            min-width: 16px;
        }

        .sidebar-submenu a span {
            display: block;
            text-align: left;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .sidebar-submenu a:hover {
            background: #f0f0f0;
        }

        @media (max-width: 991.98px) {
            .sidebar-submenu {
                position: static;
                left: auto;
                top: auto;
                min-width: 100%;
                max-width: none;
                max-height: none;
                margin-top: 0.5rem;
                box-shadow: 0 6px 14px rgba(16, 24, 40, 0.08);
            }
        }
    </style>
@endonce
