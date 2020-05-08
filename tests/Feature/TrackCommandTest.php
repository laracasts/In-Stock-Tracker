<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use App\Clients\StockStatus;
use RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 29900));

        $this->artisan('track')
            ->expectsOutput('All done!');

        $this->assertTrue(Product::first()->inStock());
    }
}
