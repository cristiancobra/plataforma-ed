<?php

namespace Tests\Feature\Smoke;

use App\Models\Collection as CollectionItem;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

/**
 * Rede de segurança mínima para o upgrade Laravel 8 -> 13 / PHP -> 8.5.
 * Não é cobertura completa: só o suficiente para pegar quebras sistêmicas de
 * roteamento, middleware `roles` e renderização de view a cada salto de versão.
 */
class CoreModulesSmokeTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    public function test_login_page_loads(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_user_can_login(): void
    {
        $this->loginAsAccountOwner();

        // Não usa '/' (dashboard.operational): tem o middleware `redirect_domain`, que depende do
        // Host real da requisição e não se aplica ao ambiente de teste.
        $this->get(route('dashboard.financial'))->assertOk();
    }

    public function test_task_index_loads(): void
    {
        // Sem registro de Task: criar uma exigiria montar a cadeia Stage -> Project + Opportunity
        // também, fora do escopo deste teste de fumaça (só checa roteamento/middleware/view).
        $this->loginAsAccountOwner();

        $this->get(route('task.index'))->assertOk();
    }

    public function test_company_index_and_show(): void
    {
        $user = $this->loginAsAccountOwner();

        $company = Company::create([
            'account_id' => $user->account_id,
            'name' => 'Empresa de teste',
            'status' => 'ativo',
        ]);

        $this->get(route('company.index'))->assertOk();
        $this->get(route('company.show', $company))->assertOk();
    }

    public function test_contact_index_and_show(): void
    {
        $user = $this->loginAsAccountOwner();

        $contact = Contact::create([
            'account_id' => $user->account_id,
            'name' => 'Contato de teste',
            'first_name' => 'Contato',
            'status' => 'ativo',
        ]);

        $this->get(route('contact.index'))->assertOk();
        $this->get(route('contact.show', $contact))->assertOk();
    }

    public function test_product_index_and_show(): void
    {
        $user = $this->loginAsAccountOwner();

        // 'trash' não está em $fillable no model Product: setado via atribuição direta.
        $product = new Product([
            'account_id' => $user->account_id,
            'name' => 'Produto de teste',
            'category' => 'servico',
            'type' => 'produto',
            'tax_rate' => 0,
            'price' => 100,
            'status' => 'ativo',
            'shop' => 0,
        ]);
        $product->trash = 0;
        $product->priority = 'media';
        $product->save();

        $this->get(route('product.index'))->assertOk();
        $this->get(route('product.show', $product))->assertOk();
    }

    public function test_collection_index_and_show(): void
    {
        $user = $this->loginAsAccountOwner();

        $item = CollectionItem::create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'name' => 'Item de acervo de teste',
            'category' => 'equipamento',
            'type' => 'notebook',
        ]);

        $this->get(route('collection.index'))->assertOk();
        $this->get(route('collection.show', $item))->assertOk();
    }

    public function test_opportunity_index_loads(): void
    {
        $this->loginAsAccountOwner();

        $this->get(route('opportunity.index'))->assertOk();
    }

    public function test_invoice_index_loads(): void
    {
        $this->loginAsAccountOwner();

        $this->get(route('invoice.index'))->assertOk();
    }

    public function test_transaction_index_loads(): void
    {
        $this->loginAsAccountOwner();

        $this->get(route('transaction.index'))->assertOk();
    }

    public function test_loan_index_loads(): void
    {
        $this->loginAsAccountOwner();

        $this->get(route('loan.index'))->assertOk();
    }
}
