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
            'jornadas' => ['journey.index', []],
            'metas' => ['goal.index', []],
            'projetos' => ['project.index', []],
            'imagens' => ['image.index', []],
            'documentos' => ['text.index', []],
            'textos do sistema' => ['systemText.index', []],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider("pages")]
    public function test_index_renders_with_counter_in_filter(string $route, array $params): void
    {
        $this->loginAsAccountOwner();

        $this->get(route($route, $params))->assertOk()->assertSee('item(s)');
        $this->get(route($route, $params + ['name' => 'zzz']))->assertOk()->assertSee('item(s) encontrado(s)');
    }

    /** Listagens sem filtro (ainda sem contador): só conferem que abrem no layout index. */
    public function test_plain_indexes_render(): void
    {
        $this->loginAsAccountOwner();

        foreach (['user.index', 'bank.index', 'bankAccount.index', 'competitor.index', 'contract.index',
            'contractTemplate.index', 'domain.index', 'site.index', 'socialmedia.index', 'email.index'] as $route) {
            $this->get(route($route))->assertOk();
        }
    }
}
