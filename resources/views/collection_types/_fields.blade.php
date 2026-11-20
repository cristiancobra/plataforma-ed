{{--
    Campos personalizados do tipo de acervo: marcar campos já existentes e/ou criar campos novos,
    que serão criados ao salvar o tipo. Os itens deste tipo mostram exatamente estes campos.
--}}
@php
    $collectionType = $collectionType ?? null;
    $checkedFields = array_map('intval', old('field_ids', $collectionType ? $collectionType->fields->pluck('id')->all() : []));
    $oldNewFields = old('new_fields', []);
    $typeOptions = \App\Enums\CustomFieldType::selectOptions();
@endphp

<div class="mt-4">
    <label class="labels">CAMPOS DOS ITENS DESTE TIPO:</label>
    <p class="text-muted small mb-2">
        Ao cadastrar um item deste tipo, o usuário preenche os campos marcados aqui.
    </p>

    @if ($availableFields->isNotEmpty())
        <div class="row">
            @foreach ($availableFields as $availableField)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="field_ids[]" value="{{ $availableField->id }}"
                            id="field_{{ $availableField->id }}" @checked(in_array($availableField->id, $checkedFields))>
                        <label class="form-check-label {{ $availableField->active ? '' : 'text-muted' }}" for="field_{{ $availableField->id }}">
                            {{ $availableField->label }}
                            <small class="text-muted">({{ $availableField->type->label() }}{{ $availableField->required ? ', obrigatório' : '' }}{{ $availableField->active ? '' : ', desativado' }})</small>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Ainda não há campos cadastrados. Crie o primeiro abaixo.</p>
    @endif

    <div id="new-fields" class="mt-3">
        @foreach ($oldNewFields as $i => $row)
            @include('collection_types._new_field_row', ['index' => $i, 'row' => $row, 'typeOptions' => $typeOptions])
        @endforeach
    </div>

    <button type="button" id="add-new-field" class="btn btn-sm btn-outline-secondary mt-2">
        <i class="fas fa-plus"></i> Novo campo
    </button>

    <template id="new-field-template">
        @include('collection_types._new_field_row', ['index' => '__INDEX__', 'row' => [], 'typeOptions' => $typeOptions])
    </template>
</div>

<script>
    (function () {
        var container = document.getElementById('new-fields');
        var template = document.getElementById('new-field-template');
        var nextIndex = {{ count($oldNewFields) ? max(array_keys($oldNewFields)) + 1 : 0 }};

        function bindRow(row) {
            var type = row.querySelector('.new-field-type');
            var options = row.querySelector('.new-field-options');
            function refresh() {
                options.style.display = type.value === 'select' ? '' : 'none';
            }
            type.addEventListener('change', refresh);
            refresh();
            row.querySelector('.remove-new-field').addEventListener('click', function () {
                row.remove();
            });
        }

        container.querySelectorAll('.new-field-row').forEach(bindRow);

        document.getElementById('add-new-field').addEventListener('click', function () {
            var html = template.innerHTML.replace(/__INDEX__/g, nextIndex++);
            var wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            var row = wrapper.firstElementChild;
            container.appendChild(row);
            bindRow(row);
            row.querySelector('input[type=text]').focus();
        });
    })();
</script>
