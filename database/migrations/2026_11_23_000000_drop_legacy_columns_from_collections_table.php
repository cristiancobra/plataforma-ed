<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Remove as colunas fixas que viraram campos dos tipos de acervo (migrations 2026_11_20_000003 e 000004).
 *
 * Antes de remover, confere que todo valor das colunas está no campo personalizado correspondente
 * (a senha comparada já decifrada); se faltar algum, aborta sem apagar nada.
 */
return new class extends Migration
{
    /**
     * coluna antiga => key do campo personalizado
     */
    private const COLUMNS = [
        'operating_system' => 'sistema_operacional',
        'video_card' => 'placa_de_video',
        'users' => 'usuarios',
        'password' => 'senha',
        'best_ai' => 'melhor_ia',
        'runs_vrchat' => 'roda_no_vrchat',
        'runs_adobe' => 'roda_no_adobe',
    ];

    public function up()
    {
        $existing = array_values(array_filter(array_keys(self::COLUMNS), fn ($c) => Schema::hasColumn('collections', $c)));
        if (!$existing) {
            return;
        }

        $missing = [];
        foreach (DB::table('collections')->get(array_merge(['id', 'custom_fields'], $existing)) as $item) {
            $values = json_decode($item->custom_fields ?? '', true) ?: [];
            foreach ($existing as $column) {
                $key = self::COLUMNS[$column];
                $old = $item->{$column};
                if (in_array($column, ['runs_vrchat', 'runs_adobe'], true)) {
                    if ((int) $old === 1 && empty($values[$key])) {
                        $missing[] = "#{$item->id} {$column}";
                    }
                    continue;
                }
                $old = trim((string) $old);
                if ($old === '') {
                    continue;
                }
                $new = $values[$key] ?? null;
                if ($column === 'password' && $new !== null) {
                    try {
                        $new = Crypt::decryptString($new);
                    } catch (\Throwable) {
                        // valor não criptografado: compara como está
                    }
                }
                if ($new !== $old) {
                    $missing[] = "#{$item->id} {$column}";
                }
            }
        }

        if ($missing) {
            throw new RuntimeException(
                'Valores das colunas antigas que não estão nos campos personalizados; nada foi removido: '
                . implode(', ', array_slice($missing, 0, 20)) . (count($missing) > 20 ? ' ...' : '')
            );
        }

        Schema::table('collections', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }

    /**
     * Recria as colunas vazias (os dados ficam nos campos personalizados).
     */
    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('operating_system')->nullable();
            $table->string('video_card')->nullable();
            $table->string('best_ai')->nullable();
            $table->string('password')->nullable();
            $table->string('users')->nullable();
            $table->boolean('runs_adobe')->nullable();
            $table->boolean('runs_vrchat')->nullable();
        });
    }
};
