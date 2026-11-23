<?php

namespace App\Http\Requests;

use App\Enums\CustomFieldType;
use App\Models\CollectionField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CollectionFieldRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * As opções do tipo "lista" vêm de um textarea, uma por linha.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'options' => CollectionField::parseOptions($this->input('options_text')),
            'required' => $this->boolean('required'),
            'is_global' => $this->boolean('is_global'),
            'position' => $this->input('position') === null || $this->input('position') === '' ? 0 : $this->input('position'),
        ]);
    }

    public function rules()
    {
        $accountId = auth()->user()->account_id;

        return [
            'label' => 'required|string|max:100',
            'collection_type_ids' => 'array',
            'collection_type_ids.*' => [Rule::exists('collection_types', 'id')->where('account_id', $accountId)],
            'type' => ['required', Rule::enum(CustomFieldType::class)],
            'options' => ['array', 'required_if:type,' . CustomFieldType::Select->value],
            'options.*' => 'string|max:255',
            'required' => 'boolean',
            'is_global' => 'boolean',
            'position' => 'integer|min:0|max:9999',
        ];
    }

    /**
     * Ao editar, impede trocar o tipo de um campo que já tem valores gravados por um tipo incompatível.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $field = $this->route('collectionField');
                $newType = CustomFieldType::tryFrom((string) $this->input('type'));
                if (!$field || !$newType || $field->type->canChangeTo($newType)) {
                    return;
                }
                if ($field->hasValues()) {
                    $validator->errors()->add(
                        'type',
                        'Este campo já tem valores gravados em itens do acervo; o tipo "' . $field->type->label()
                            . '" não pode ser trocado por "' . $newType->label() . '".'
                    );
                }
            },
        ];
    }

    public function messages()
    {
        return [
            'label.required' => 'O nome do campo é obrigatório.',
            'collection_type_ids.*.exists' => 'Um dos tipos de acervo selecionados é inválido.',
            'type.required' => 'Escolha o tipo do campo.',
            'options.required_if' => 'Informe ao menos uma opção (uma por linha).',
        ];
    }

    /**
     * Dados do próprio campo (sem os tipos, que são sincronizados à parte).
     */
    public function fieldData(): array
    {
        $data = $this->safe()->only(['label', 'type', 'options', 'required', 'is_global', 'position']);
        if ($data['type'] !== CustomFieldType::Select->value) {
            $data['options'] = null;
        }

        return $data;
    }

    public function typeIds(): array
    {
        // campo geral vale para todos os tipos: não tem vínculo com tipos específicos
        if ($this->boolean('is_global')) {
            return [];
        }

        return $this->validated('collection_type_ids') ?? [];
    }
}
