<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

/**
 * Todas as listagens usam layouts/index + x-table.filter: abre cada uma, sem e com filtro,
 * e confere o contador dentro do filtro.
 */
class IndexPagesTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    public static function pages(): array
    {
        return [
            'tarefas' => ['task.index', []],
            'propostas' => ['proposal.index', ['type' => 'receita']],
            'faturas' => ['invoice.index', []],
            'transacoes' => ['transaction.index', []],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider("pages")]
    public function test_index_renders_with_counter_in_filter(string $route, array $params): void
    {
        $this->loginAsAccountOwner();

        $this->get(route($route, $params))->assertOk()->assertSee('item(s)');
        $this->get(route($route, $params + ['name' => 'zzz']))->assertOk()->assertSee('item(s) encontrado(s)');
    }
}
