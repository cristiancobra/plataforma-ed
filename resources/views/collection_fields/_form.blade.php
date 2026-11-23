<div class="row">
    <div class="col-md-12">
        <label class='labels' for='label'>NOME DO CAMPO: <span class="text-danger">*</span></label>
        <input type='text' name='label' id='label' class='form-control' maxlength="100"
            value='{{ old('label', $field->label) }}' placeholder="Ex.: Placa de vídeo" required>
        @error('label')
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

<div class="row">
    <div class="col-md-12">
        <x-form.checkbox name="is_global"
            label="Campo geral (aparece em todos os tipos de acervo, inclusive os criados depois)"
            :checked="old('is_global', $field->is_global)" />
    </div>
</div>

<div class="row mt-3" id="types-row">
    <div class="col-md-12">
        <label class='labels'>TIPOS DE ACERVO QUE USAM ESTE CAMPO:</label>
        @php $checkedTypes = array_map('intval', old('collection_type_ids', $field->exists ? $field->types->pluck('id')->all() : [])); @endphp
        @if (count($collectionTypeOptions))
            <div style="columns: 4 160px;">
                @foreach ($collectionTypeOptions as $typeId => $typeName)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="collection_type_ids[]" value="{{ $typeId }}"
                            id="collection_type_{{ $typeId }}" @checked(in_array($typeId, $checkedTypes))>
                        <label class="form-check-label" for="collection_type_{{ $typeId }}">{{ $typeName }}</label>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Nenhum tipo de acervo cadastrado.</p>
        @endif
        @error('collection_type_ids.*')
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

        // campo geral não escolhe tipos: esconde e desabilita os checkboxes para não serem enviados
        var isGlobal = document.getElementById('is_global');
        var typesRow = document.getElementById('types-row');

        function refreshGlobal() {
            typesRow.style.display = isGlobal.checked ? 'none' : '';
            typesRow.querySelectorAll('input[type=checkbox]').forEach(function (input) {
                input.disabled = isGlobal.checked;
            });
        }

        isGlobal.addEventListener('change', refreshGlobal);
        refreshGlobal();
    })();
</script>
