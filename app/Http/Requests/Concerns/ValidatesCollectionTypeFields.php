<?php

namespace App\Http\Requests\Concerns;

use App\Enums\CustomFieldType;
use App\Models\CollectionField;
use Illuminate\Validation\Rule;

/**
 * Campos personalizados escolhidos/criados no formulário do tipo de acervo:
 * - field_ids[]: campos já existentes que o tipo passa a ter;
 * - new_fields[n][label|type|options_text|required]: campos novos, criados ao salvar o tipo.
 */
trait ValidatesCollectionTypeFields
{
    protected function prepareFieldsForValidation(): void
    {
        $newFields = collect($this->input('new_fields', []))
            // linhas adicionadas e deixadas em branco são ignoradas
            ->filter(fn ($row) => is_array($row) && trim((string) ($row['label'] ?? '')) !== '')
            ->map(fn ($row) => [
                'label' => trim($row['label']),
                'type' => $row['type'] ?? null,
                'options_text' => $row['options_text'] ?? '',
                'options' => CollectionField::parseOptions($row['options_text'] ?? ''),
                'required' => !empty($row['required']),
            ])
            ->values()
            ->all();

        $this->merge(['new_fields' => $newFields, 'field_ids' => $this->input('field_ids', [])]);
    }

    protected function fieldRules(): array
    {
        $accountId = auth()->user()->account_id;

        return [
            'field_ids' => 'array',
            'field_ids.*' => [Rule::exists('collection_fields', 'id')->where('account_id', $accountId)],
            'new_fields' => 'array',
            'new_fields.*.label' => 'required|string|max:100',
            'new_fields.*.type' => ['required', Rule::enum(CustomFieldType::class)],
            'new_fields.*.options' => ['array', 'required_if:new_fields.*.type,' . CustomFieldType::Select->value],
            'new_fields.*.options.*' => 'string|max:255',
            'new_fields.*.required' => 'boolean',
        ];
    }

    protected function fieldMessages(): array
    {
        return [
            'field_ids.*.exists' => 'Um dos campos selecionados é inválido.',
            'new_fields.*.label.max' => 'O nome do campo deve ter no máximo 100 caracteres.',
            'new_fields.*.type.required' => 'Escolha o tipo de cada campo novo.',
            'new_fields.*.options.required_if' => 'Informe as opções (uma por linha) dos campos novos do tipo lista.',
        ];
    }

    public function typeData(): array
    {
        return $this->safe()->only(['name', 'category']);
    }

    public function fieldIds(): array
    {
        return $this->validated('field_ids') ?? [];
    }

    public function newFields(): array
    {
        return $this->validated('new_fields') ?? [];
    }
}
