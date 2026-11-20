{{--
    Campos personalizados do acervo no formulário de criação/edição.
    Recebe todos os campos ativos da conta; o JS abaixo mostra só os globais e os do tipo marcado
    em input[name=type_id] (e desabilita os escondidos, para não serem enviados nem validados pelo navegador).
--}}
@props(['fields', 'values' => []])

@php
    $values = $values ?? [];
    $hasOldInput = !empty(session()->getOldInput());
@endphp

@if ($fields->isNotEmpty())
    <div id="custom-fields-section">
        <div class="row">
            @foreach ($fields as $field)
                @php
                    $name = 'custom_fields[' . $field->key . ']';
                    $id = 'custom_field_' . $field->key;
                    $value = $hasOldInput
                        ? old('custom_fields.' . $field->key)
                        : $field->type->inputValue($values[$field->key] ?? null);
                @endphp
                <div class="col-md-6 mt-3 custom-field" data-type-id="{{ $field->collection_type_id }}">
                    @if ($field->type !== \App\Enums\CustomFieldType::Boolean)
                        <label class='labels' for='{{ $id }}'>
                            {{ mb_strtoupper($field->label) }}:@if ($field->required)<span class="text-danger"> *</span>@endif
                        </label>
                    @endif
                    @include('components.custom-fields.inputs.' . $field->type->value, [
                        'field' => $field,
                        'name' => $name,
                        'id' => $id,
                        'value' => $value,
                    ])
                    @error('custom_fields.' . $field->key)
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
            @endforeach
        </div>
    </div>

    <script>
        (function () {
            var section = document.getElementById('custom-fields-section');

            function selectedType() {
                var checked = document.querySelector('input[name="type_id"]:checked');
                return checked ? checked.value : null;
            }

            function refreshCustomFields() {
                var typeId = selectedType();
                section.querySelectorAll('.custom-field').forEach(function (wrapper) {
                    var fieldType = wrapper.dataset.typeId;
                    var visible = fieldType === '' || fieldType === typeId;
                    wrapper.style.display = visible ? '' : 'none';
                    wrapper.querySelectorAll('input, select, textarea').forEach(function (input) {
                        input.disabled = !visible;
                    });
                });
            }

            document.querySelectorAll('input[name="type_id"]').forEach(function (radio) {
                radio.addEventListener('change', refreshCustomFields);
            });
            refreshCustomFields();
        })();
    </script>
@endif
