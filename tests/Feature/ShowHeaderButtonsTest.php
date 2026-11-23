<?php

namespace Tests\Feature;

use App\Models\Proposal;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

/**
 * As ações do antigo painel flutuante "FLUXO" ficam agora nos botões circulares do header.
 */
class ShowHeaderButtonsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    protected function setUp(): void
    {
        parent::setUp();
        // Só checa a renderização do header: dispensa montar a cadeia Stage -> Project / Opportunity.
        Schema::disableForeignKeyConstraints();
    }

    public function test_task_show_has_journey_and_complete_buttons(): void
    {
        $user = $this->loginAsAccountOwner();

        $task = Task::forceCreate([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'contact_id' => $user->contact_id,
            'name' => 'Tarefa de teste',
            'date_entered' => now()->toDateString(),
            'created_by' => $user->id,
            'description' => 'Descrição',
            'stage_id' => 0,
            'project_id' => 0,
            'trash' => 0,
            'department' => 'vendas',
            'priority' => 'média',
            'status' => 'fazendo',
            'date_start' => now()->toDateString(),
            'date_due' => now()->toDateString(),
        ]);

        $this->get(route('task.show', $task))
            ->assertOk()
            ->assertDontSee('workflow-container', false)
            ->assertSee('Iniciar jornada com a hora atual')
            ->assertSee(route('journey.storeFromTask', ['taskId' => $task->id]), false)
            ->assertSee('Concluir tarefa com a data atual');
    }

    public function test_proposal_show_has_generate_invoices_button(): void
    {
        $user = $this->loginAsAccountOwner();

        $proposal = Proposal::forceCreate([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'contact_id' => $user->contact_id,
            'identifier' => 1,
            'opportunity_id' => 0,
            'trash' => 0,
            'name' => 'Proposta de teste',
            'date_creation' => now()->toDateString(),
            'expiration_date' => 30,
            'pay_day' => now()->toDateString(),
            'installment' => 1,
            'type' => 'receita',
            'status' => 'pendente',
        ]);

        $this->get(route('proposal.show', $proposal))
            ->assertOk()
            ->assertDontSee('workflow-container', false)
            ->assertSee('Gerar faturas dos pagamentos')
            ->assertSee(route('proposal.generateInstallment', ['proposal' => $proposal]), false);
    }
}
