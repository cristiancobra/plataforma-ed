<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

/**
 * O campo "Senha" criado na migração das colunas fixas (key `senha`, tipo texto) passa a ser do tipo
 * Senha (protegida): os valores já gravados em collections.custom_fields são criptografados com a APP_KEY.
 */
return new class extends Migration
{
    private const KEY = 'senha';

    public function up()
    {
        $this->convert('text', 'secret', fn (string $value) => Crypt::encryptString($value));
    }

    public function down()
    {
        $this->convert('secret', 'text', fn (string $value) => Crypt::decryptString($value));
    }

    private function convert(string $from, string $to, callable $transform): void
    {
        DB::transaction(function () use ($from, $to, $transform) {
            $fields = DB::table('collection_fields')->where('key', self::KEY)->where('type', $from)->get();

            foreach ($fields as $field) {
                $items = DB::table('collections')
                    ->where('account_id', $field->account_id)
                    ->whereNotNull('custom_fields')
                    ->get(['id', 'custom_fields']);

                foreach ($items as $item) {
                    $values = json_decode($item->custom_fields, true) ?: [];
                    if (!isset($values[self::KEY]) || $values[self::KEY] === '') {
                        continue;
                    }
                    $values[self::KEY] = $transform((string) $values[self::KEY]);
                    DB::table('collections')->where('id', $item->id)
                        ->update(['custom_fields' => json_encode($values, JSON_UNESCAPED_UNICODE)]);
                }

                DB::table('collection_fields')->where('id', $field->id)->update(['type' => $to, 'updated_at' => now()]);
            }
        });
    }
};
