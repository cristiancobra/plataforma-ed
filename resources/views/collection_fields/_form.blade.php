<div class="row">
    <div class="col-md-6">
        <label class='labels' for='label'>NOME DO CAMPO: <span class="text-danger">*</span></label>
        <input type='text' name='label' id='label' class='form-control' maxlength="100"
            value='{{ old('label', $field->label) }}' placeholder="Ex.: Placa de vídeo" required>
        @error('label')
            <span class='text-danger'>{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-6">
        <label class='labels' for='collection_type_id'>VALE PARA:</label>
        <x-form.select name="collection_type_id" :options="$collectionTypeOptions"
            :selected="old('collection_type_id', $field->collection_type_id)" placeholder="Todos os tipos de acervo"
            id="collection_type_id" />
        @error('collection_type_id')
            <span class='text-danger'>{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label class='labels' for='type'>TIPO DO CAMPO: <span class="text-danger">*</span></label>
        @php $currentType = old('type', $field->type?->value); @endphp
        <select name="type" id="type" class="form-select" required>
            @foreach ($typeOptions as $value => $label)
                <option value="{{ $value }}" @selected($currentType === $value) @disabled(in_array($value, $lockedTypes))>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @if ($lockedTypes)
            <small class="text-muted">
                Este campo já tem valores preenchidos, então só pode mudar para tipos compatíveis.
            </small>
        @endif
        @error('type')
            <span class='text-danger d-block'>{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label class='labels' for='position'>ORDEM:</label>
        <input type='number' name='position' id='position' class='form-control' min="0" max="9999"
            value='{{ old('position', $field->position ?? 0) }}'>
        @error('position')
            <span class='text-danger'>{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <x-form.checkbox name="required" label="Obrigatório" :checked="old('required', $field->required)" />
    </div>
</div>

<div class="row mt-3" id="options-row">
    <div class="col-md-6">
        <label class='labels' for='options_text'>OPÇÕES DA LISTA (uma por linha): <span class="text-danger">*</span></label>
        <textarea name='options_text' id='options_text' class='form-control' rows='5'>{{ old('options_text', implode("\n", $field->options ?? [])) }}</textarea>
        @error('options')
            <span class='text-danger'>{{ $message }}</span>
        @enderror
    </div>
</div>

<br>
<div style="display: flex; gap: 10px; align-items: center;">
    <x-buttons.cancel />
    <x-buttons.save />
</div>

<script>
    (function () {
        var type = document.getElementById('type');
        var optionsRow = document.getElementById('options-row');

        function refresh() {
            optionsRow.style.display = type.value === 'select' ? '' : 'none';
        }

        type.addEventListener('change', refresh);
        refresh();
    })();
</script>
