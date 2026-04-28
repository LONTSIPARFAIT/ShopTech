<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Cat', 'slug' => 'test-cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'base_price' => 1000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        
        $cartService = app(CartService::class);
        $cart = $cartService->getCart();
        
        $this->assertEquals(2000, $cartService->getTotal($cart));
        $this->assertCount(1, $cart->items);
    }

    public function test_can_add_product_with_variant_supplement()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Cat', 'slug' => 'test-cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'base_price' => 1000,
            'is_active' => true,
        ]);

        $variant = Variant::create([
            'product_id' => $product->id,
            'name' => 'Size',
            'value' => 'XL',
            'price_override' => 500,
            'stock' => 10,
        ]);

        $response = $this->actingAs($user)->post(route('cart.store'), [
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect();
        
        $cartService = app(CartService::class);
        $cart = $cartService->getCart();
        
        // Base 1000 + Supplement 500 = 1500
        $this->assertEquals(1500, $cartService->getTotal($cart));
    }
}
