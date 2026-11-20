<?php

namespace Tests\Feature;

use App\Enums\CustomFieldType;
use App\Models\Account;
use App\Models\Collection as CollectionItem;
use App\Models\CollectionField;
use App\Models\CollectionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

class CollectionSecretFieldTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    private function setUpType($accountId, bool $required = false): array
    {
        $type = CollectionType::create(['account_id' => $accountId, 'name' => 'Computador', 'category' => 'físico']);
        $field = new CollectionField(['label' => 'Senha', 'type' => 'secret', 'required' => $required]);
        $field->account_id = $accountId;
        $field->key = 'senha';
        $field->save();
        $field->types()->sync([$type->id]);

        return [$type, $field];
    }

    private function payload(CollectionType $type, array $custom = [], array $extra = []): array
    {
        return array_merge([
            'name' => 'PC',
            'type_id' => $type->id,
            'initial_location' => 'Sala',
            'status' => 'available',
            'custom_fields' => $custom,
        ], $extra);
    }

    public function test_secret_is_encrypted_masked_and_revealed_on_demand(): void
    {
        $user = $this->loginAsAccountOwner();
        [$type] = $this->setUpType($user->account_id);

        $this->post(route('collection.store'), $this->payload($type, ['senha' => 's3nh@']))->assertSessionHasNoErrors();
        $item = CollectionItem::first();

        $stored = $item->custom_fields['senha'];
        $this->assertNotSame('s3nh@', $stored);
        $this->assertSame('s3nh@', Crypt::decryptString($stored));

        // tela de ver: só a máscara; o valor vem pela rota de revelar
        $this->get(route('collection.show', $item))->assertOk()->assertDontSee('s3nh@')->assertSee('••••••••');
        $this->getJson(route('collection.reveal-secret', [$item, 'senha']))->assertOk()->assertExactJson(['value' => 's3nh@']);

        // edição: o valor guardado não vai para o formulário
        $this->get(route('collection.edit', $item))->assertOk()->assertDontSee('s3nh@')->assertDontSee($stored);

        $update = $this->payload($type);
        unset($update['initial_location']);

        // em branco mantém
        $this->put(route('collection.update', $item), $update)->assertSessionHasNoErrors();
        $this->assertSame('s3nh@', Crypt::decryptString($item->fresh()->custom_fields['senha']));

        // nova senha substitui
        $this->put(route('collection.update', $item), array_merge($update, ['custom_fields' => ['senha' => 'outra']]));
        $this->assertSame('outra', Crypt::decryptString($item->fresh()->custom_fields['senha']));

        // "apagar" remove
        $this->put(route('collection.update', $item), array_merge($update, ['custom_fields_clear' => ['senha' => '1']]));
        $this->assertNull($item->fresh()->custom_fields);
        $this->getJson(route('collection.reveal-secret', [$item, 'senha']))->assertNotFound();
    }

    public function test_required_secret_only_required_when_nothing_stored(): void
    {
        $user = $this->loginAsAccountOwner();
        [$type] = $this->setUpType($user->account_id, true);

        $this->post(route('collection.store'), $this->payload($type))->assertSessionHasErrors('custom_fields.senha');
        $this->post(route('collection.store'), $this->payload($type, ['senha' => 'x']))->assertSessionHasNoErrors();

        $update = $this->payload($type);
        unset($update['initial_location']);
        $this->put(route('collection.update', CollectionItem::first()), $update)->assertSessionHasNoErrors();
    }

    public function test_reveal_is_blocked_for_other_accounts(): void
    {
        $other = Account::create([
            'name' => 'Outra', 'city' => 'X', 'state' => 'XX', 'country' => 'Brasil',
            'status' => 'ativo', 'due_date' => now()->addYear(),
        ]);
        $item = new CollectionItem(['name' => 'PC', 'status' => 'available']);
        $item->account_id = $other->id;
        $item->user_id = 1;
        $item->custom_fields = ['senha' => Crypt::encryptString('segredo')];
        $item->save();

        $this->loginAsAccountOwner();
        $this->getJson(route('collection.reveal-secret', [$item, 'senha']))->assertForbidden();
    }

    public function test_migration_encrypts_existing_password_values(): void
    {
        $user = $this->loginAsAccountOwner();
        $field = new CollectionField(['label' => 'Senha', 'type' => 'text']);
        $field->account_id = $user->account_id;
        $field->key = 'senha';
        $field->save();
        $id = DB::table('collections')->insertGetId([
            'account_id' => $user->account_id, 'user_id' => $user->id, 'name' => 'PC', 'status' => 'available',
            'trash' => 0, 'custom_fields' => json_encode(['senha' => '1234', 'cor' => 'azul']),
        ]);

        $migration = require database_path('migrations/2026_11_20_000004_protect_collection_password_fields.php');
        $migration->up();

        $this->assertSame(CustomFieldType::Secret, $field->fresh()->type);
        $values = CollectionItem::find($id)->custom_fields;
        $this->assertSame('1234', Crypt::decryptString($values['senha']));
        $this->assertSame('azul', $values['cor']);

        $migration->up(); // idempotente: não criptografa duas vezes
        $this->assertSame('1234', Crypt::decryptString(CollectionItem::find($id)->custom_fields['senha']));

        $migration->down();
        $this->assertSame('1234', CollectionItem::find($id)->custom_fields['senha']);
        $this->assertSame(CustomFieldType::Text, $field->fresh()->type);
    }
}
