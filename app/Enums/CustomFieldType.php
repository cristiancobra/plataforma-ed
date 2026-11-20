<?php

namespace App\Enums;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

/**
 * Tipos dos campos personalizados do acervo.
 *
 * Cada tipo concentra tudo o que muda entre eles: validação, conversão do valor do formulário para
 * o que é gravado no JSON, formatação para exibição e o partial Blade do input
 * (resources/views/components/custom-fields/inputs/{value}.blade.php). Para criar um tipo novo,
 * basta um case aqui e o partial correspondente.
 */
enum CustomFieldType: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Number = 'number';
    case Currency = 'currency';
    case Date = 'date';
    case Boolean = 'boolean';
    case Select = 'select';
    case Url = 'url';
    // valor criptografado no banco (APP_KEY), mascarado na tela e revelado só sob demanda
    case Secret = 'secret';

    public function label(): string
    {
        return match ($this) {
            self::Text => 'Texto curto',
            self::Textarea => 'Texto longo',
            self::Number => 'Número',
            self::Currency => 'Valor em R$',
            self::Date => 'Data',
            self::Boolean => 'Sim / Não',
            self::Select => 'Lista de opções',
            self::Url => 'Link (URL)',
            self::Secret => 'Senha (protegida)',
        };
    }

    /**
     * Array value => label, para selects.
     */
    public static function selectOptions(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }

    /**
     * Mudanças de tipo permitidas para um campo que já tem valores gravados: só as que não
     * invalidam nem reinterpretam os dados existentes.
     */
    public function canChangeTo(self $new): bool
    {
        if ($new === $this) {
            return true;
        }

        return match ($this) {
            self::Text, self::Url, self::Select => $new === self::Textarea || $new === self::Text,
            default => false,
        };
    }

    /**
     * Decifra um valor do tipo Senha (null se estiver vazio ou não puder ser decifrado).
     */
    public static function decryptSecret(?string $stored): ?string
    {
        if ($stored === null || $stored === '') {
            return null;
        }
        try {
            return Crypt::decryptString($stored);
        } catch (\Illuminate\Contracts\Encryption\DecryptException) {
            return null;
        }
    }

    /**
     * Regras de validação do valor (sem required/nullable, que dependem da definição do campo).
     */
    public function rules(array $options = []): array
    {
        return match ($this) {
            self::Text => ['string', 'max:255'],
            self::Textarea => ['string', 'max:10000'],
            // aceita vírgula ou ponto como separador decimal
            self::Number => ['regex:/^-?\d+([.,]\d+)?$/'],
            // formato da máscara formatCurrencyReal(): 1.234,56
            self::Currency => ['regex:/^(R\$\s?)?-?\d{1,3}(\.?\d{3})*(,\d{1,2})?$/'],
            self::Date => ['date'],
            self::Boolean => ['boolean'],
            self::Select => [Rule::in($options)],
            self::Url => ['url', 'max:500'],
            self::Secret => ['string', 'max:255'],
        };
    }

    /**
     * Converte o valor vindo do formulário no que é gravado no JSON. Retorna null para "vazio".
     */
    public function normalize(mixed $value): mixed
    {
        if ($this === self::Boolean) {
            return (bool) $value;
        }

        if ($value === null || (is_string($value) && trim($value) === '')) {
            return null;
        }

        return match ($this) {
            self::Number => (float) str_replace(',', '.', $value),
            self::Currency => (float) removeCurrency($value),
            self::Date => Carbon::parse($value)->format('Y-m-d'),
            self::Secret => Crypt::encryptString(trim($value)),
            default => trim($value),
        };
    }

    /**
     * Texto para exibição (já escapado pelo Blade; links são tratados no partial de exibição).
     */
    public function display(mixed $value): string
    {
        if ($this === self::Boolean) {
            return $value ? 'Sim' : 'Não';
        }

        if ($value === null || $value === '') {
            return '-';
        }

        return match ($this) {
            self::Number => rtrim(rtrim(number_format((float) $value, 6, ',', '.'), '0'), ','),
            self::Currency => formatCurrencyReal($value),
            self::Date => Carbon::parse($value)->format('d/m/Y'),
            self::Secret => '••••••••',
            default => (string) $value,
        };
    }

    /**
     * Valor para preencher o input de edição.
     */
    public function inputValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($this) {
            self::Number => str_replace('.', ',', (string) $value),
            self::Currency => formatCurrency($value),
            // o valor guardado nunca volta para o formulário
            self::Secret => null,
            default => $value,
        };
    }
}
