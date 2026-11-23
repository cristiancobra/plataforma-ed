<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

<!-- Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit/es2021/jodit.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link href="{{ url(mix('css/style.css')) }}" rel="stylesheet">
<style>
    /* moldura da página branca na cor principal da conta */
    .white-page { border-color: {{ $principalColor ?? '#c28dbf' }}; }

    /* linhas de listagem clicáveis (data-href) com hover na cor secundária da conta */
    :root { --secondary-color: {{ $complementaryColor ?? '#f9d0ff' }}; }
    .row-link { cursor: pointer; }
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
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
