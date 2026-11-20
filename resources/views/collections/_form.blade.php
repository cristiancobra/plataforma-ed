{{--
    Campos do item de acervo, compartilhados entre criar e editar.
    Variáveis: $collection (novo ou existente), $types, $status, $customFields e os *SelectOptions.
--}}
@php
    $isNew = !$collection->exists;
    $dateValue = fn ($field) => old($field, $collection->{$field}?->format('Y-m-d'));
@endphp

<x-form.section title="IDENTIFICAÇÃO" icon="fas fa-id-card">
    <div class="row">
        <div class="col-md-12">
            <label class='labels' for='name'>NOME: <span class="text-danger">*</span></label>
            <input type='text' name='name' id='name' class='form-control' value='{{ old('name', $collection->name) }}' required>
            @error('name')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <label class='labels' for='title'>TÍTULO:</label>
            <input type='text' name='title' id='title' class='form-control' value='{{ old('title', $collection->title) }}'>
            @error('title')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for='brand'>MARCA:</label>
            <input type='text' name='brand' id='brand' class='form-control' value='{{ old('brand', $collection->brand) }}'>
        </div>
        <div class="col-md-6">
            <label class='labels' for='model'>MODELO:</label>
            <input type='text' name='model' id='model' class='form-control' value='{{ old('model', $collection->model) }}'>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <label class='labels' for='description'>DESCRIÇÃO:</label>
            <textarea name='description' id='description' class='form-control' rows='3'>{{ old('description', $collection->description) }}</textarea>
            @error('description')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
    </div>
</x-form.section>

<x-form.section title="CÓDIGOS E RASTREAMENTO" icon="fas fa-barcode">
    <div class="row">
        <div class="col-md-4">
            <label class='labels' for='patrimony_number'>NÚMERO PATRIMÔNIO:</label>
            <input type='text' name='patrimony_number' id='patrimony_number' class='form-control'
                value='{{ old('patrimony_number', $collection->patrimony_number) }}'>
        </div>
        <div class="col-md-4">
            <label class='labels' for='control_code'>CÓDIGO DE CONTROLE:</label>
            <input type='text' name='control_code' id='control_code' class='form-control'
                value='{{ old('control_code', $collection->control_code) }}'>
        </div>
        <div class="col-md-4">
            <label class='labels' for='serial_number'>NÚMERO DE SÉRIE:</label>
            <input type='text' name='serial_number' id='serial_number' class='form-control'
                value='{{ old('serial_number', $collection->serial_number) }}'>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for='tracking_tag'>TAG DE RASTREAMENTO:</label>
            <input type='text' name='tracking_tag' id='tracking_tag' class='form-control'
                value='{{ old('tracking_tag', $collection->tracking_tag) }}'>
        </div>
        <div class="col-md-6">
            <label class='labels' for='redirect_link'>LINK DE REDIRECIONAMENTO:</label>
            <input type='text' name='redirect_link' id='redirect_link' class='form-control'
                value='{{ old('redirect_link', $collection->redirect_link) }}'>
        </div>
    </div>
</x-form.section>

<x-form.section title="ORGANIZAÇÃO E RESPONSÁVEL" icon="fas fa-sitemap">
    <div class="row">
        <div class="col-md-4">
            <label class='labels'>ACERVO:</label>
            <x-form.select name="collections_group_id" :options="$collectionsGroupSelectOptions"
                :selected="old('collections_group_id', $collection->collections_group_id)" placeholder="Selecione o grupo" class="fields" />
            @error('collections_group_id')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class='labels'>PROJETO:</label>
            <x-form.select name="project_id" :options="$projectsSelectOptions"
                :selected="old('project_id', $collection->project_id)" placeholder="Não possui" class="fields" />
            @error('project_id')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class='labels'>RESPONSÁVEL (CONTATO):</label>
            <x-form.select name="contact_id" :options="$contactsSelectOptions"
                :selected="old('contact_id', $collection->contact_id)" placeholder="Não possui" class="fields" />
            @error('contact_id')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
    </div>
</x-form.section>

<x-form.section title="AQUISIÇÃO" icon="fas fa-shopping-cart">
    <div class="row">
        <div class="col-md-3">
            <label class='labels' for='purchase_date'>DATA DA COMPRA:</label>
            <input type='date' name='purchase_date' id='purchase_date' class='form-control' value='{{ $dateValue('purchase_date') }}'>
        </div>
        <div class="col-md-3">
            <label class='labels' for='manufacturing_date'>DATA DE FABRICAÇÃO:</label>
            <input type='date' name='manufacturing_date' id='manufacturing_date' class='form-control'
                value='{{ $dateValue('manufacturing_date') }}'>
        </div>
        <div class="col-md-6">
            <label class='labels' for='accessories'>ACESSÓRIOS:</label>
            <textarea name='accessories' id='accessories' class='form-control' rows='2'>{{ old('accessories', $collection->accessories) }}</textarea>
        </div>
    </div>
</x-form.section>

<x-form.section title="ESPECIFICAÇÕES TÉCNICAS" icon="fas fa-microchip">
    <div class="row">
        <div class="col-md-4">
            <label class='labels' for='operating_system'>SISTEMA OPERACIONAL:</label>
            <input type='text' name='operating_system' id='operating_system' class='form-control'
                value='{{ old('operating_system', $collection->operating_system) }}'>
        </div>
        <div class="col-md-4">
            <label class='labels' for='video_card'>PLACA DE VÍDEO:</label>
            <input type='text' name='video_card' id='video_card' class='form-control'
                value='{{ old('video_card', $collection->video_card) }}'>
        </div>
        <div class="col-md-4">
            <label class='labels' for='best_ai'>MELHOR IA:</label>
            <input type='text' name='best_ai' id='best_ai' class='form-control' value='{{ old('best_ai', $collection->best_ai) }}'>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <label class='labels' for='users'>USUÁRIOS:</label>
            <input type='text' name='users' id='users' class='form-control' value='{{ old('users', $collection->users) }}'>
        </div>
        <div class="col-md-4">
            <label class='labels' for='password'>SENHA:</label>
            <input type='text' name='password' id='password' class='form-control'
                value='{{ old('password', $collection->password) }}' autocomplete="off">
        </div>
        <div class="col-md-4 d-flex gap-4">
            <x-form.checkbox name="runs_adobe" label="Roda no Adobe" :checked="old('runs_adobe', $collection->runs_adobe)" />
            <x-form.checkbox name="runs_vrchat" label="Roda no VRChat" :checked="old('runs_vrchat', $collection->runs_vrchat)" />
        </div>
    </div>
</x-form.section>

<x-form.section title="LINKS" icon="fas fa-link">
    <div class="row">
        <div class="col-md-4">
            <label class='labels' for='video_url'>URL DO VÍDEO:</label>
            <input type='url' name='video_url' id='video_url' class='form-control' value='{{ old('video_url', $collection->video_url) }}'>
            @error('video_url')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class='labels' for='code_url'>URL DO CÓDIGO:</label>
            <input type='url' name='code_url' id='code_url' class='form-control' value='{{ old('code_url', $collection->code_url) }}'>
            @error('code_url')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class='labels' for='image_url'>URL DA IMAGEM:</label>
            <input type='url' name='image_url' id='image_url' class='form-control' value='{{ old('image_url', $collection->image_url) }}'>
            @error('image_url')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
    </div>
</x-form.section>

<x-form.section :title="$isNew ? 'LOCALIZAÇÃO E SITUAÇÃO' : 'SITUAÇÃO'" icon="fas fa-map-marker-alt">
    <div class="row">
        @if ($isNew)
            <div class="col-md-6">
                <label class='labels' for='initial_location'>LOCALIZAÇÃO INICIAL: <span class="text-danger">*</span></label>
                <input type='text' name='initial_location' id='initial_location'
                    class='form-control @error('initial_location') is-invalid @enderror'
                    value='{{ old('initial_location') }}' required>
                @error('initial_location')
                    <span class='text-danger'>{{ $message }}</span>
                @enderror
            </div>
        @endif
        <div class="col-md-6">
            @if ($isNew)
                <label class='labels'>SITUAÇÃO:</label>
            @endif
            @if ($collection->status === 'in use')
                <p>Emprestado <span class="text-muted small">(volta a ficar disponível ao registrar a devolução do empréstimo)</span></p>
            @else
                {{ createSimpleSelect('status', 'form-select', $status, old('status', $collection->status)) }}
            @endif
        </div>
    </div>
    @if ($isNew)
        <div class="row mt-3">
            <div class="col-md-12">
                <label class='labels' for='location_notes'>NOTAS DA LOCALIZAÇÃO:</label>
                <textarea name='location_notes' id='location_notes' class='form-control' rows='2'>{{ old('location_notes') }}</textarea>
            </div>
        </div>
    @endif
</x-form.section>

<x-form.section title="TIPO E CAMPOS DO TIPO" icon="fas fa-tags"
    hint="Escolha o tipo de acervo; os campos específicos desse tipo aparecem logo abaixo.">
    <div style="columns: 4 180px;">
        @foreach ($types as $key => $value)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type_id" id="type_{{ $key }}"
                    value="{{ $key }}" @checked(old('type_id', $collection->type_id) == $key) required>
                <label class="form-check-label" for="type_{{ $key }}">{{ $value }}</label>
            </div>
        @endforeach
    </div>
    @error('type_id')
        <span class='text-danger'>{{ $message }}</span>
    @enderror

    <x-custom-fields.form :fields="$customFields" :values="$collection->custom_fields" />
</x-form.section>
