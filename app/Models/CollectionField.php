<?php

namespace App\Models;

use App\Enums\CustomFieldType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Definição de um campo personalizado dos itens de acervo, criada pelo cliente.
 * O valor de cada item fica em Collection::$custom_fields[$field->key].
 */
class CollectionField extends Model
{
    protected $table = 'collection_fields';

    protected $fillable = [
        'label',
        'type',
        'options',
        'required',
        'position',
        'active',
    ];

    protected $casts = [
        'type' => CustomFieldType::class,
        'options' => 'array',
        'required' => 'boolean',
        'active' => 'boolean',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Tipos de acervo que usam este campo.
     */
    public function types()
    {
        return $this->belongsToMany(CollectionType::class, 'collection_field_type');
    }

    public function scopeOfCurrentAccount(Builder $query): Builder
    {
        return $query->where('account_id', auth()->user()->account_id);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('label');
    }

    /**
     * Campos associados a um tipo de acervo (sem tipo, nenhum campo).
     */
    public function scopeForType(Builder $query, $typeId): Builder
    {
        return $query->whereHas('types', fn ($q) => $q->where('collection_types.id', $typeId ?: 0));
    }

    /**
     * Opções da lista digitadas num textarea, uma por linha (sem vazias nem repetidas).
     */
    public static function parseOptions(?string $text): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $text))
            ->map(fn ($option) => trim($option))
            ->filter(fn ($option) => $option !== '')
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Cria um campo na conta atual, gerando a key a partir do rótulo e colocando-o no fim da ordem.
     */
    public static function createForCurrentAccount(array $data): self
    {
        $accountId = auth()->user()->account_id;

        $field = new self($data);
        if ($field->type !== CustomFieldType::Select) {
            $field->options = null;
        }
        $field->account_id = $accountId;
        $field->key = self::generateKey($field->label, $accountId);
        if (!array_key_exists('position', $data)) {
            $field->position = (int) self::where('account_id', $accountId)->max('position') + 1;
        }
        $field->save();

        return $field;
    }

    /**
     * Gera uma key única na conta a partir do rótulo (ex.: "Placa de vídeo" -> placa_de_video).
     * A key é fixa depois de criada, porque é ela que liga o campo aos valores gravados.
     */
    public static function generateKey(string $label, int $accountId): string
    {
        $base = Str::limit(Str::slug($label, '_'), 90, '') ?: 'campo';
        $key = $base;
        $i = 2;
        while (self::where('account_id', $accountId)->where('key', $key)->exists()) {
            $key = $base . '_' . $i++;
        }

        return $key;
    }

    /**
     * Existe algum item da conta com valor gravado para este campo?
     */
    public function hasValues(): bool
    {
        return Collection::where('account_id', $this->account_id)
            ->whereJsonContainsKey('custom_fields->' . $this->key)
            ->exists();
    }

    /**
     * Regras de validação deste campo para o input custom_fields.{key}.
     * $currentValue é o valor já gravado no item: numa lista, continua aceito mesmo que a opção
     * tenha sido removida depois, para o item poder ser salvo sem perder o dado.
     */
    public function validationRules(mixed $currentValue = null): array
    {
        if ($this->type === CustomFieldType::Boolean) {
            return ['nullable', 'boolean'];
        }

        return array_merge(
            [$this->required ? 'required' : 'nullable'],
            $this->type->rules(array_values(array_filter(
                array_merge($this->options ?? [], [$currentValue]),
                fn ($option) => $option !== null
            )))
        );
    }

    /**
     * Campos ativos da conta atual aplicáveis a um tipo de acervo, na ordem de exibição.
     */
    public static function applicableTo($typeId)
    {
        return self::ofCurrentAccount()->active()->forType($typeId)->ordered()->get();
    }

    /**
     * Regras e nomes de atributo (para as mensagens de erro) de um conjunto de campos.
     */
    public static function validationFor($fields, ?array $currentValues = null): array
    {
        $rules = [];
        $attributes = [];
        foreach ($fields as $field) {
            $rules['custom_fields.' . $field->key] = $field->validationRules($currentValues[$field->key] ?? null);
            $attributes['custom_fields.' . $field->key] = $field->label;
        }

        return [$rules, $attributes];
    }

    public function displayValue(?array $values): string
    {
        return $this->type->display($values[$this->key] ?? null);
    }
}
