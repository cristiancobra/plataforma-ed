<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Converte as colunas fixas específicas de alguns tipos de item (sistema operacional, placa de vídeo,
 * melhor IA, usuários, senha, roda no Adobe/VRChat) em campos personalizados dos tipos de acervo.
 *
 * Para cada conta e coluna com algum valor: cria o campo (ou reaproveita um campo com a mesma key),
 * liga-o aos tipos dos itens que têm o valor e copia o valor para collections.custom_fields.
 * Itens sem tipo também têm o valor copiado (fica guardado e aparece quando o item ganhar um tipo
 * que tenha o campo).
 *
 * As colunas antigas NÃO são removidas aqui: isso fica para uma migration posterior, depois de conferir
 * os dados em produção.
 */
return new class extends Migration
{
    /**
     * coluna antiga => [key, rótulo, tipo do campo]
     */
    private const COLUMNS = [
        'operating_system' => ['sistema_operacional', 'Sistema operacional', 'text'],
        'video_card' => ['placa_de_video', 'Placa de vídeo', 'text'],
        'users' => ['usuarios', 'Usuários', 'text'],
        'password' => ['senha', 'Senha', 'text'],
        'best_ai' => ['melhor_ia', 'Melhor IA', 'text'],
        'runs_vrchat' => ['roda_no_vrchat', 'Roda no VRChat', 'boolean'],
        'runs_adobe' => ['roda_no_adobe', 'Roda no Adobe', 'boolean'],
    ];

    public function up()
    {
        $accountIds = DB::table('collections')->distinct()->pluck('account_id');

        foreach ($accountIds as $accountId) {
            $position = (int) DB::table('collection_fields')->where('account_id', $accountId)->max('position');

            foreach (self::COLUMNS as $column => [$key, $label, $type]) {
                $isBoolean = $type === 'boolean';

                // itens que usam a coluna: texto preenchido, ou booleano marcado em ao menos um item
                $used = DB::table('collections')->where('account_id', $accountId)
                    ->when($isBoolean, fn ($q) => $q->where($column, 1))
                    ->when(!$isBoolean, fn ($q) => $q->whereNotNull($column)->whereRaw("TRIM($column) <> ''"));
                if (!$used->exists()) {
                    continue;
                }

                $fieldId = DB::table('collection_fields')->where('account_id', $accountId)->where('key', $key)->value('id');
                if (!$fieldId) {
                    $fieldId = DB::table('collection_fields')->insertGetId([
                        'account_id' => $accountId,
                        'label' => $label,
                        'key' => $key,
                        'type' => $type,
                        'options' => null,
                        'required' => false,
                        'position' => ++$position,
                        'active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $typeIds = (clone $used)->whereNotNull('type_id')->distinct()->pluck('type_id');
                foreach ($typeIds as $typeId) {
                    DB::table('collection_field_type')->insertOrIgnore([
                        'collection_field_id' => $fieldId,
                        'collection_type_id' => $typeId,
                    ]);
                }

                // texto: copia os preenchidos. Booleano: copia Sim/Não dos itens dos tipos que ganharam o campo
                // (para continuarem mostrando "Não" como antes) e dos itens sem tipo que estavam marcados.
                $items = DB::table('collections')->where('account_id', $accountId)
                    ->when(!$isBoolean, fn ($q) => $q->whereNotNull($column)->whereRaw("TRIM($column) <> ''"))
                    ->when($isBoolean, fn ($q) => $q->where(fn ($w) => $w->whereIn('type_id', $typeIds)->orWhere($column, 1)))
                    ->get(['id', $column, 'custom_fields']);

                foreach ($items as $item) {
                    $values = json_decode($item->custom_fields ?? '', true) ?: [];
                    if (array_key_exists($key, $values)) {
                        continue; // não sobrescreve valor já preenchido no campo novo
                    }
                    $values[$key] = $isBoolean ? (bool) $item->{$column} : trim($item->{$column});
                    DB::table('collections')->where('id', $item->id)
                        ->update(['custom_fields' => json_encode($values, JSON_UNESCAPED_UNICODE)]);
                }
            }
        }
    }

    /**
     * Desfaz removendo os campos criados e os valores copiados (as colunas antigas continuam intactas).
     */
    public function down()
    {
        $keys = array_column(self::COLUMNS, 0);

        foreach (DB::table('collections')->whereNotNull('custom_fields')->get(['id', 'custom_fields']) as $item) {
            $values = json_decode($item->custom_fields, true) ?: [];
            $remaining = array_diff_key($values, array_flip($keys));
            if (count($remaining) !== count($values)) {
                DB::table('collections')->where('id', $item->id)
                    ->update(['custom_fields' => $remaining ? json_encode($remaining, JSON_UNESCAPED_UNICODE) : null]);
            }
        }

        DB::table('collection_fields')->whereIn('key', $keys)->delete();
    }
};
