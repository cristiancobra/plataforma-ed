{{-- Mensagens de feedback exibidas no topo das páginas (erros de validação e mensagens de sessão) --}}
@php
    $alerts = [];

    if ($errors->any()) {
        $alerts[] = [
            'type' => 'danger',
            'icon' => 'fas fa-exclamation-circle',
            'title' => 'Não foi possível salvar. Verifique os campos abaixo:',
            'items' => $errors->all(),
        ];
    }

    // 'failed' pode conter links em HTML montados nos controllers
    foreach (['failed' => true, 'error' => false] as $key => $allowHtml) {
        if (Session::has($key)) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'fas fa-exclamation-circle',
                'message' => Session::get($key),
                'html' => $allowHtml,
            ];
            Session::forget($key);
        }
    }

    foreach (['success', 'attachment_success', 'message'] as $key) {
        if (Session::has($key)) {
            $alerts[] = [
                'type' => 'success',
                'icon' => 'fas fa-check-circle',
                'message' => Session::get($key),
            ];
            Session::forget($key);
        }
    }
@endphp

@foreach ($alerts as $alert)
    <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show d-flex align-items-start shadow-sm"
        role="alert">
        <i class="{{ $alert['icon'] }} me-2 mt-1" style="font-size:20px"></i>
        <div>
            @isset($alert['title'])
                <strong>{{ $alert['title'] }}</strong>
            @endisset
            @isset($alert['items'])
                <ul class="mb-0 mt-1">
                    @foreach ($alert['items'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @endisset
            @isset($alert['message'])
                @if ($alert['html'] ?? false)
                    {!! $alert['message'] !!}
                @else
                    {{ $alert['message'] }}
                @endif
            @endisset
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endforeach
