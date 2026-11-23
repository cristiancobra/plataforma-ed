<?php

use App\Models\Text;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('texts', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->unique(['account_id', 'slug']);
        });

        // Gera o slug dos documentos existentes a partir do nome
        DB::table('texts')->orderBy('id')->select('id', 'account_id', 'name')->get()
            ->each(function ($text) {
                DB::table('texts')->where('id', $text->id)->update([
                    'slug' => Text::uniqueSlug($text->name, $text->account_id, $text->id),
                ]);
            });
    }

    public function down(): void
    {
        Schema::table('texts', function (Blueprint $table) {
            $table->dropUnique(['account_id', 'slug']);
            $table->dropColumn('slug');
        });
    }
};
