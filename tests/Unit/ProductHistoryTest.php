<?php

namespace Tests\Unit;

use App\Stock;
use App\History;
use Tests\TestCase;
use RetailerWithProductSeeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_each_time_stock_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Http::fake(fn() => ['salePrice' => 99, 'onlineAvailability' => true]);

        $this->assertEquals(0, History::count());

        $stock = tap(Stock::first())->track();

        $this->assertEquals(1, History::count());

        $history = History::first();

        $this->assertEquals($stock->price, $history->price);
        $this->assertEquals($stock->in_stock, $history->in_stock);
        $this->assertEquals($stock->product_id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);
    }
}
