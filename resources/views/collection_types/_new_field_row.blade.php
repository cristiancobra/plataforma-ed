<div class="new-field-row border rounded p-2 mb-2 bg-light">
    <div class="row g-2 align-items-end">
        <div class="col-md-5">
            <label class="small">Nome do campo</label>
            <input type="text" name="new_fields[{{ $index }}][label]" class="form-control" maxlength="100"
                placeholder="Ex.: Placa de vídeo" value="{{ $row['label'] ?? '' }}">
        </div>
        <div class="col-md-3">
            <label class="small">Tipo</label>
            <select name="new_fields[{{ $index }}][type]" class="form-select new-field-type">
                @foreach ($typeOptions as $value => $label)
                    <option value="{{ $value }}" @selected(($row['type'] ?? 'text') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="new_fields[{{ $index }}][required]" value="1"
                    id="new_field_required_{{ $index }}" @checked(!empty($row['required']))>
                <label class="form-check-label" for="new_field_required_{{ $index }}">Obrigatório</label>
            </div>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-sm btn-outline-danger remove-new-field mb-1" title="Remover">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="col-md-5 new-field-options">
            <label class="small">Opções da lista (uma por linha)</label>
            <textarea name="new_fields[{{ $index }}][options_text]" class="form-control" rows="3">{{ $row['options_text'] ?? '' }}</textarea>
        </div>
    </div>
</div>
