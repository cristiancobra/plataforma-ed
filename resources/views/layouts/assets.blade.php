<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

<!-- Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit/es2021/jodit.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha256-2FMn2Zx6PuH5tdBQDRNwrOo60ts5wWPC9R8jK67b3t4=" crossorigin="anonymous">
<link href="{{ url(mix('css/style.css')) }}" rel="stylesheet">
<style>
    /* moldura da página branca na cor principal da conta */
    .white-page { border-color: {{ $principalColor ?? '#c28dbf' }}; }

    /* linhas de listagem clicáveis (data-href) com hover na cor secundária da conta */
    :root {
        --principal-color: {{ $principalColor ?? '#874983' }};
        --secondary-color: {{ $complementaryColor ?? '#f9d0ff' }};
    }
    .row-link { cursor: pointer; }
    /* efeito de hover em todos os botões (os estilos inline de cor não mudam no hover, então usamos brilho/elevação) */
    .btn, .circular-button, .circular-button-mini, .text-button, .button-round, input[type="submit"] {
        cursor: pointer;
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }
    .btn:not(:disabled):not(.disabled):hover, .circular-button:hover, .circular-button-mini:hover,
    .text-button:hover, .button-round:hover, input[type="submit"]:not(:disabled):hover {
        transform: translateY(-2px);
        filter: brightness(1.12);
        box-shadow: 0 4px 10px rgba(0, 0, 0, .28);
    }
    .btn.rounded-circle:not(:disabled):not(.disabled):hover { transform: translateY(-2px) scale(1.08); }
    .btn:not(:disabled):not(.disabled):active, .circular-button:active, .circular-button-mini:active,
    .text-button:active, .button-round:active, input[type="submit"]:not(:disabled):active {
        transform: translateY(0) scale(.96);
        filter: brightness(.95);
        box-shadow: none;
    }
    @media (prefers-reduced-motion: reduce) {
        .btn, .circular-button, .circular-button-mini, .text-button, .button-round, input[type="submit"] { transition: none; }
    }

    .row-link:hover, .table2:hover {
        background-color: color-mix(in srgb, var(--secondary-color) 25%, white) !important;
    }
    .row-link:hover { position: relative; z-index: 10; }
    .row-link a, .row-link button, .row-link form { position: relative; z-index: 2; }

    /* avatares/miniaturas ampliam no hover, sem deslocar a tabela (transform não reflui o layout) */
    .avatar-zoom, .profile-picture-small { transition: transform .15s ease-in-out; transform-origin: center; position: relative; }
    .avatar-zoom:hover, .profile-picture-small:hover {
        transform: scale(4);
        z-index: 50;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .4);
        background-color: white;
    }
    .product-image-small { transition: transform .15s ease-in-out; }
    .product-image-small:hover { transform: scale(2.4); z-index: 50; position: relative; box-shadow: 0 6px 18px rgba(0, 0, 0, .4); background-color: white; }
</style>
<script>
    // clique em qualquer ponto da linha abre o show (ignora cliques em links/botões/campos da própria linha)
    document.addEventListener('click', function(e) {
        var row = e.target.closest('[data-href]');
        if (!row || e.target.closest('a, button, input, select, textarea, label, form')) return;
        if (e.ctrlKey || e.metaKey) { window.open(row.dataset.href, '_blank'); return; }
        window.location.href = row.dataset.href;
    });
</script>
<script>
    // confirmação por modal: qualquer <form data-confirm="mensagem"> abre um alerta antes de enviar
    // (opcional: data-confirm-title, data-confirm-label)
    (function() {
        var modalEl = null, modal = null, pendingForm = null;

        function build() {
            modalEl = document.createElement('div');
            modalEl.className = 'modal fade';
            modalEl.tabIndex = -1;
            modalEl.innerHTML =
                '<div class="modal-dialog modal-dialog-centered">' +
                '<div class="modal-content border-0 shadow">' +
                '<div class="modal-header border-0 pb-0">' +
                '<h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle text-danger me-2"></i><span data-role="title"></span></h5>' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>' +
                '</div>' +
                '<div class="modal-body" data-role="message"></div>' +
                '<div class="modal-footer border-0 pt-0">' +
                '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>' +
                '<button type="button" class="btn btn-danger" data-role="confirm"></button>' +
                '</div></div></div>';
            document.body.appendChild(modalEl);
            modal = new bootstrap.Modal(modalEl);
            modalEl.querySelector('[data-role="confirm"]').addEventListener('click', function() {
                var form = pendingForm;
                pendingForm = null;
                modal.hide();
                if (form) form.submit();
            });
        }

        document.addEventListener('submit', function(e) {
            var form = e.target;
            var message = form.dataset ? form.dataset.confirm : null;
            if (!message) return;
            e.preventDefault();
            if (!window.bootstrap) { if (confirm(message)) form.submit(); return; }
            if (!modalEl) build();
            pendingForm = form;
            modalEl.querySelector('[data-role="title"]').textContent = form.dataset.confirmTitle || 'Confirmação';
            modalEl.querySelector('[data-role="message"]').textContent = message;
            modalEl.querySelector('[data-role="confirm"]').textContent = form.dataset.confirmLabel || 'Confirmar';
            modal.show();
        }, true);
    })();
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha256-5P1JGBOIxI7FBAvT/mb1fCnI5n/NhQKzNUuW7Hq0fMc=" crossorigin="anonymous">
</script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.js"
    integrity="sha512-lUsN5TEogpe12qeV8NF4cxlJJatTZ12jnx9WXkFXOy7yFbuHwYRTjmctvwbRIuZPhv+lpvy7Cm9o8T9e+9pTrg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ url(mix('js/app.js')) }}" sync defer></script>
<script src='{{ url(mix('js/scripts.js')) }}' sync defer></script>
<script src="https://cdn.jsdelivr.net/npm/jodit/es2021/jodit.min.js"></script>
