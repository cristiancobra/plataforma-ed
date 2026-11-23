<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

class ProductViewsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    public function test_index_filters_create_and_edit_render(): void
    {
        $user = $this->loginAsAccountOwner();

        foreach (['receita', 'despesa'] as $variation) {
            $product = new Product([
                'account_id' => $user->account_id,
                'name' => "Item $variation",
                'category' => 'serviço',
                'type' => $variation,
                'tax_rate' => 0,
                'price' => 100,
                'status' => 'disponível',
                'shop' => 0,
            ]);
            $product->trash = 0;
            $product->priority = 'media';
            $product->save();

            $this->get(route('product.index', ['variation' => $variation]))
                ->assertOk()->assertSee("Item $variation");
            $this->get(route('product.index', ['variation' => $variation, 'name' => 'zzz', 'category' => 'serviço']))
                ->assertOk()->assertDontSee("Item $variation")->assertSee('encontrado(s)');
            $this->get(route('product.create', ['variation' => $variation]))->assertOk()->assertSee('IDENTIFICAÇÃO');
            $this->get(route('product.edit', ['product' => $product, 'variation' => $variation]))->assertOk();
        }
    }
}
