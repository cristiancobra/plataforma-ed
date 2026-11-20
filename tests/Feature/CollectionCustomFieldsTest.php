<?php

namespace Tests\Feature;

use App\Enums\CustomFieldType;
use App\Models\Account;
use App\Models\Collection as CollectionItem;
use App\Models\CollectionField;
use App\Models\CollectionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

class CollectionCustomFieldsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    private function makeType($accountId, string $name = 'Computador'): CollectionType
    {
        return CollectionType::create(['account_id' => $accountId, 'name' => $name, 'category' => 'físico']);
    }

    /**
     * Cria um campo e o associa aos tipos informados em $attributes['types'] (ids).
     */
    private function makeField($accountId, array $attributes): CollectionField
    {
        $typeIds = $attributes['types'] ?? [];
        unset($attributes['types']);

        $field = new CollectionField($attributes);
        $field->account_id = $accountId;
        $field->key = CollectionField::generateKey($attributes['label'], $accountId);
        $field->save();
        $field->types()->sync($typeIds);

        return $field;
    }

    private function itemPayload(CollectionType $type, array $customFields = []): array
    {
        return [
            'name' => 'Notebook',
            'type_id' => $type->id,
            'initial_location' => 'Sala 1',
            'status' => 'available',
            'custom_fields' => $customFields,
        ];
    }

    public function test_owner_creates_select_field_with_generated_key(): void
    {
        $user = $this->loginAsAccountOwner();
        $type = $this->makeType($user->account_id);

        $this->post(route('collection-field.store'), [
            'label' => 'Placa de vídeo',
            'collection_type_ids' => [$type->id],
            'type' => 'select',
            'options_text' => "RTX 3060\nRTX 4070\n\nRTX 3060",
            'required' => '1',
        ])->assertRedirect(route('collection-field.index'));

        $field = CollectionField::first();
        $this->assertSame('placa_de_video', $field->key);
        $this->assertSame(CustomFieldType::Select, $field->type);
        $this->assertSame(['RTX 3060', 'RTX 4070'], $field->options);
        $this->assertTrue($field->required);
        $this->assertSame([$type->id], $field->types->pluck('id')->all());

        $this->get(route('collection-field.index'))->assertOk()->assertSee('Placa de vídeo');
        $this->get(route('collection-field.edit', $field))->assertOk();
    }

    public function test_select_field_requires_options(): void
    {
        $this->loginAsAccountOwner();

        $this->post(route('collection-field.store'), ['label' => 'Cor', 'type' => 'select', 'options_text' => ''])
            ->assertSessionHasErrors('options');
    }

    public function test_values_are_validated_normalized_and_displayed(): void
    {
        $user = $this->loginAsAccountOwner();
        $type = $this->makeType($user->account_id);
        $otherType = $this->makeType($user->account_id, 'Livro');

        $this->makeField($user->account_id, ['label' => 'Valor de mercado', 'type' => 'currency', 'types' => [$type->id]]);
        $this->makeField($user->account_id, ['label' => 'Roda VRChat', 'type' => 'boolean', 'types' => [$type->id]]);
        $this->makeField($user->account_id, ['label' => 'Garantia até', 'type' => 'date', 'types' => [$type->id]]);
        $this->makeField($user->account_id, ['label' => 'Memória (GB)', 'type' => 'number', 'types' => [$type->id]]);
        $this->makeField($user->account_id, ['label' => 'ISBN', 'type' => 'text', 'required' => true, 'types' => [$otherType->id]]);

        $this->get(route('collection.create'))->assertOk()->assertSee('VALOR DE MERCADO')->assertSee('ISBN');

        // campo inválido é rejeitado com o rótulo do campo na mensagem
        $this->post(route('collection.store'), $this->itemPayload($type, ['memoria_gb' => 'muito']))
            ->assertSessionHasErrors('custom_fields.memoria_gb');

        // ISBN é obrigatório, mas só para "Livro": não é exigido num "Computador"
        $this->post(route('collection.store'), $this->itemPayload($type, [
            'valor_de_mercado' => '1.234,56',
            'roda_vrchat' => '1',
            'garantia_ate' => '2027-03-01',
            'memoria_gb' => '16,5',
        ]))->assertSessionHasNoErrors();

        $item = CollectionItem::first();
        $values = $item->custom_fields;
        ksort($values);
        $this->assertSame([
            'garantia_ate' => '2027-03-01',
            'memoria_gb' => 16.5,
            'roda_vrchat' => true,
            'valor_de_mercado' => 1234.56,
        ], $values);

        $this->get(route('collection.show', $item))->assertOk()
            ->assertSee('R$ 1.234,56')
            ->assertSee('01/03/2027')
            ->assertSee('16,5')
            ->assertDontSee('ISBN');

        $this->get(route('collection.edit', $item))->assertOk()->assertSee('1.234,56', false);
    }

    public function test_changing_item_type_preserves_values_of_other_type_fields(): void
    {
        $user = $this->loginAsAccountOwner();
        $computer = $this->makeType($user->account_id);
        $book = $this->makeType($user->account_id, 'Livro');
        $this->makeField($user->account_id, ['label' => 'Placa', 'type' => 'text', 'types' => [$computer->id]]);

        $this->post(route('collection.store'), $this->itemPayload($computer, ['placa' => 'RTX']));
        $item = CollectionItem::first();

        $payload = $this->itemPayload($book);
        unset($payload['initial_location']);
        $this->put(route('collection.update', $item), $payload)->assertSessionHasNoErrors();

        $this->assertSame(['placa' => 'RTX'], $item->fresh()->custom_fields);
    }

    public function test_type_change_is_blocked_when_field_has_values(): void
    {
        $user = $this->loginAsAccountOwner();
        $type = $this->makeType($user->account_id);
        $field = $this->makeField($user->account_id, ['label' => 'Ano', 'type' => 'number', 'types' => [$type->id]]);

        $this->post(route('collection.store'), $this->itemPayload($type, ['ano' => '2020']));

        $this->put(route('collection-field.update', $field), ['label' => 'Ano', 'type' => 'date'])
            ->assertSessionHasErrors('type');

        // compatível (não reinterpreta dados) continua permitido
        $text = $this->makeField($user->account_id, ['label' => 'Obs', 'type' => 'text']);
        $this->put(route('collection-field.update', $text), ['label' => 'Observações', 'type' => 'textarea'])
            ->assertSessionHasNoErrors();
        $this->assertSame('obs', $text->fresh()->key);
    }

    public function test_deactivating_hides_field_but_keeps_values(): void
    {
        $user = $this->loginAsAccountOwner();
        $type = $this->makeType($user->account_id);
        $field = $this->makeField($user->account_id, ['label' => 'Cor', 'type' => 'text', 'types' => [$type->id]]);
        $this->post(route('collection.store'), $this->itemPayload($type, ['cor' => 'Azul']));
        $item = CollectionItem::first();

        $this->delete(route('collection-field.destroy', $field))->assertRedirect();
        $this->assertFalse($field->fresh()->active);
        $this->get(route('collection.create'))->assertDontSee('COR:');

        $payload = $this->itemPayload($type);
        unset($payload['initial_location']);
        $this->put(route('collection.update', $item), $payload);
        $this->assertSame(['cor' => 'Azul'], $item->fresh()->custom_fields);

        $this->put(route('collection-field.activate', $field));
        $this->get(route('collection.show', $item))->assertSee('Azul');
    }

    public function test_fields_of_another_account_are_not_accessible(): void
    {
        $this->loginAsAccountOwner();
        $other = Account::create([
            'name' => 'Outra', 'city' => 'X', 'state' => 'XX', 'country' => 'Brasil',
            'status' => 'ativo', 'due_date' => now()->addYear(),
        ]);
        $field = $this->makeField($other->id, ['label' => 'Segredo', 'type' => 'text']);

        $this->get(route('collection-field.edit', $field))->assertForbidden();
        $this->get(route('collection-field.index'))->assertDontSee('Segredo');
    }

    public function test_employee_cannot_manage_fields(): void
    {
        $user = $this->loginAsAccountOwner();
        $user->perfil = 'funcionário';
        $user->save();

        $this->get(route('collection-field.index'))->assertForbidden();
    }

    public function test_type_form_selects_existing_fields_and_creates_new_ones(): void
    {
        $user = $this->loginAsAccountOwner();
        $existing = $this->makeField($user->account_id, ['label' => 'Sistema operacional', 'type' => 'text']);
        $this->makeField($user->account_id, ['label' => 'ISBN', 'type' => 'text']);

        $this->get(route('collection-types.create'))->assertOk()->assertSee('Sistema operacional');

        // opções obrigatórias para campo novo do tipo lista
        $this->post(route('collection-types.store'), [
            'name' => 'Computador',
            'category' => 'físico',
            'new_fields' => [['label' => 'Processador', 'type' => 'select', 'options_text' => '']],
        ])->assertSessionHasErrors('new_fields.0.options');
        $this->assertSame(0, CollectionType::count());

        $this->post(route('collection-types.store'), [
            'name' => 'Computador',
            'category' => 'físico',
            'field_ids' => [$existing->id],
            'new_fields' => [
                ['label' => 'Processador', 'type' => 'select', 'options_text' => "i5\ni7", 'required' => '1'],
                ['label' => '', 'type' => 'text'], // linha deixada em branco: ignorada
            ],
        ])->assertSessionHasNoErrors()->assertRedirect(route('collection-types.index'));

        $type = CollectionType::where('name', 'Computador')->first();
        $this->assertSame(['Processador', 'Sistema operacional'], $type->fields->pluck('label')->sort()->values()->all());
        $new = CollectionField::where('key', 'processador')->first();
        $this->assertSame(['i5', 'i7'], $new->options);
        $this->assertTrue($new->required);

        $this->get(route('collection-types.index'))->assertOk()->assertSee('Processador');
        $this->get(route('collection-types.edit', $type))->assertOk();

        // editar: desmarcar o campo existente deixa só o Processador
        $this->put(route('collection-types.update', $type), [
            'name' => 'Computador',
            'category' => 'físico',
            'field_ids' => [$new->id],
        ])->assertSessionHasNoErrors();
        $this->assertSame(['Processador'], $type->fresh()->fields->pluck('label')->all());
    }

    public function test_item_only_uses_fields_of_its_type(): void
    {
        $user = $this->loginAsAccountOwner();
        $computer = $this->makeType($user->account_id);
        $book = $this->makeType($user->account_id, 'Livro');
        $shared = $this->makeField($user->account_id, ['label' => 'Cor', 'type' => 'text', 'types' => [$computer->id, $book->id]]);
        $this->makeField($user->account_id, ['label' => 'Processador', 'type' => 'text', 'types' => [$computer->id]]);
        $this->makeField($user->account_id, ['label' => 'ISBN', 'type' => 'text', 'required' => true, 'types' => [$book->id]]);
        $this->makeField($user->account_id, ['label' => 'Sem tipo', 'type' => 'text']);

        // campo sem nenhum tipo não aparece no formulário
        $this->get(route('collection.create'))->assertOk()
            ->assertSee('PROCESSADOR')
            ->assertSee('data-type-ids=",' . $computer->id . ',"', false)
            ->assertDontSee('SEM TIPO');

        // ISBN (obrigatório só em Livro) não é exigido num Computador; valor de campo de outro tipo é ignorado
        $this->post(route('collection.store'), $this->itemPayload($computer, [
            'cor' => 'Preto', 'processador' => 'i7', 'isbn' => '123', 'sem_tipo' => 'x',
        ]))->assertSessionHasNoErrors();

        $item = CollectionItem::first();
        $values = $item->custom_fields;
        ksort($values);
        $this->assertSame(['cor' => 'Preto', 'processador' => 'i7'], $values);

        $this->get(route('collection.show', $item))->assertOk()->assertSee('PROCESSADOR')->assertDontSee('ISBN');

        $this->post(route('collection.store'), $this->itemPayload($book, ['cor' => 'Azul']))
            ->assertSessionHasErrors('custom_fields.isbn');
        $this->assertTrue($shared->types()->count() === 2);
    }

    public function test_show_displays_every_field_type_and_keeps_values_of_unlinked_fields(): void
    {
        $user = $this->loginAsAccountOwner();
        $type = $this->makeType($user->account_id);
        $a = $user->account_id;
        $t = [$type->id];
        $this->makeField($a, ['label' => 'Apelido', 'type' => 'text', 'types' => $t]);
        $this->makeField($a, ['label' => 'Observações', 'type' => 'textarea', 'types' => $t]);
        $this->makeField($a, ['label' => 'Memória', 'type' => 'number', 'types' => $t]);
        $this->makeField($a, ['label' => 'Valor', 'type' => 'currency', 'types' => $t]);
        $this->makeField($a, ['label' => 'Garantia', 'type' => 'date', 'types' => $t]);
        $this->makeField($a, ['label' => 'Roda VR', 'type' => 'boolean', 'types' => $t]);
        $this->makeField($a, ['label' => 'Cor', 'type' => 'select', 'options' => ['Preto', 'Azul'], 'types' => $t]);
        $this->makeField($a, ['label' => 'Manual', 'type' => 'url', 'types' => $t]);
        $this->makeField($a, ['label' => 'Senha', 'type' => 'secret', 'types' => $t]);
        $this->makeField($a, ['label' => 'Vazio', 'type' => 'text', 'types' => $t]);
        $unlinked = $this->makeField($a, ['label' => 'Antigo', 'type' => 'text', 'types' => $t]);
        $inactive = $this->makeField($a, ['label' => 'Desligado', 'type' => 'text', 'types' => $t]);

        $this->post(route('collection.store'), $this->itemPayload($type, [
            'apelido' => 'PC do lab', 'observacoes' => "linha 1\nlinha 2", 'memoria' => '16', 'valor' => '2.500,00',
            'garantia' => '2027-01-31', 'roda_vr' => '1', 'cor' => 'Azul', 'manual' => 'https://exemplo.com/m',
            'senha' => 'segredo', 'antigo' => 'valor antigo', 'desligado' => 'valor desligado',
        ]))->assertSessionHasNoErrors();
        $item = CollectionItem::first();

        $unlinked->types()->detach();
        $inactive->update(['active' => false]);

        $this->get(route('collection.show', $item))->assertOk()
            ->assertSee('CAMPOS DO TIPO COMPUTADOR')
            ->assertSeeInOrder(['APELIDO', 'PC do lab'])
            ->assertSee('linha 1<br />', false)
            ->assertSeeInOrder(['MEMÓRIA', '16'])
            ->assertSee('R$ 2.500,00')
            ->assertSee('31/01/2027')
            ->assertSeeInOrder(['RODA VR', 'Sim'])
            ->assertSeeInOrder(['COR', 'Azul'])
            ->assertSee('href="https://exemplo.com/m"', false)
            ->assertSeeInOrder(['SENHA', '••••••••', 'Mostrar'])
            ->assertDontSee('segredo')
            ->assertSee('VAZIO')
            ->assertSeeInOrder(['OUTROS CAMPOS PREENCHIDOS', 'ANTIGO', 'valor antigo', 'DESLIGADO', 'valor desligado']);
    }
}
