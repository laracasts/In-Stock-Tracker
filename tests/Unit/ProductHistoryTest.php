<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;
use App\Clients\StockStatus;
use RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_when_a_product_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 99));

        $product = tap(Product::first(), function ($product) {
            $this->assertCount(0, $product->history);

            $product->track();

            $this->assertCount(1, $product->refresh()->history);
        });

        $history = $product->history->first();
        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }
}
