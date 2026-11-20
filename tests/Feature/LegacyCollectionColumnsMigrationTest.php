<?php

namespace Tests\Feature;

use App\Models\Collection as CollectionItem;
use App\Models\CollectionField;
use App\Models\CollectionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

class LegacyCollectionColumnsMigrationTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    private function migration()
    {
        return require database_path('migrations/2026_11_20_000003_migrate_legacy_collection_columns_to_custom_fields.php');
    }

    private function item(int $accountId, int $userId, ?int $typeId, array $legacy): int
    {
        return DB::table('collections')->insertGetId(array_merge([
            'account_id' => $accountId,
            'user_id' => $userId,
            'name' => 'Item',
            'type_id' => $typeId,
            'status' => 'available',
            'trash' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ], $legacy));
    }

    public function test_legacy_columns_become_type_fields_with_values(): void
    {
        $user = $this->loginAsAccountOwner();
        $a = $user->account_id;
        $pc = CollectionType::create(['account_id' => $a, 'name' => 'Computador', 'category' => 'físico']);
        $glasses = CollectionType::create(['account_id' => $a, 'name' => 'Óculos', 'category' => 'físico']);
        $cable = CollectionType::create(['account_id' => $a, 'name' => 'Cabo', 'category' => 'físico']);

        // campo já existente com outro valor: não pode ser sobrescrito
        $pcItem = $this->item($a, $user->id, $pc->id, ['operating_system' => ' Windows 11 ', 'video_card' => 'RTX', 'password' => 'abc', 'runs_adobe' => 1]);
        DB::table('collections')->where('id', $pcItem)->update(['custom_fields' => json_encode(['senha' => 'nova'])]);
        $glassesYes = $this->item($a, $user->id, $glasses->id, ['operating_system' => 'Android', 'runs_vrchat' => 1]);
        $glassesNo = $this->item($a, $user->id, $glasses->id, ['runs_vrchat' => 0]);
        $cableItem = $this->item($a, $user->id, $cable->id, ['operating_system' => '', 'runs_vrchat' => 0]);
        $noType = $this->item($a, $user->id, null, ['video_card' => 'Mali']);

        $this->migration()->up();

        $fields = CollectionField::where('account_id', $a)->with('types')->get()->keyBy('key');
        // best_ai / users não têm valor: não viram campo
        $this->assertEqualsCanonicalizing(
            ['sistema_operacional', 'placa_de_video', 'senha', 'roda_no_vrchat', 'roda_no_adobe'],
            $fields->keys()->all()
        );
        $this->assertEqualsCanonicalizing(['Computador', 'Óculos'], $fields['sistema_operacional']->types->pluck('name')->all());
        $this->assertSame(['Computador'], $fields['placa_de_video']->types->pluck('name')->all());
        $this->assertSame(['Óculos'], $fields['roda_no_vrchat']->types->pluck('name')->all());
        $this->assertSame('boolean', $fields['roda_no_adobe']->type->value);

        $this->assertEquals(
            ['sistema_operacional' => 'Windows 11', 'placa_de_video' => 'RTX', 'senha' => 'nova', 'roda_no_adobe' => true],
            CollectionItem::find($pcItem)->custom_fields
        );
        $this->assertEquals(['sistema_operacional' => 'Android', 'roda_no_vrchat' => true], CollectionItem::find($glassesYes)->custom_fields);
        $this->assertEquals(['roda_no_vrchat' => false], CollectionItem::find($glassesNo)->custom_fields);
        $this->assertNull(CollectionItem::find($cableItem)->custom_fields);
        $this->assertEquals(['placa_de_video' => 'Mali'], CollectionItem::find($noType)->custom_fields);

        // rodar de novo não duplica nada
        $this->migration()->up();
        $this->assertSame(5, CollectionField::where('account_id', $a)->count());

        // a tela do item mostra os valores migrados
        $this->get(route('collection.show', $pcItem))->assertOk()->assertSee('SISTEMA OPERACIONAL')->assertSee('Windows 11');

        $this->migration()->down();
        $this->assertSame(0, CollectionField::where('account_id', $a)->count());
        $this->assertNull(CollectionItem::find($pcItem)->custom_fields);
        $this->assertSame(' Windows 11 ', DB::table('collections')->where('id', $pcItem)->value('operating_system'));
    }
}
