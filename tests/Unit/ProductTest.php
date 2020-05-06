<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_stock_for_products_at_retailers()
    {
        $this->seed(RetailerWithProductSeeder::class);

        tap(Product::first(), function ($product) {
            $this->assertFalse($product->inStock());

            $product->stock()->first()->update(['in_stock' => true]);

            $this->assertTrue($product->inStock());
        });

    }
}
