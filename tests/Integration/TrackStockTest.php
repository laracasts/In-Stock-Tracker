<?php

namespace Tests\Integration;

use App\Stock;
use App\History;
use App\UseCases\TrackStock;
use RetailerWithProductSeeder;
use Tests\TestCase;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackStockTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->mockClientRequest($available = true, $price = 24900);

        $this->seed(RetailerWithProductSeeder::class);

        (new TrackStock(Stock::first()))->handle();
    }

    /** @test */
    function it_notifies_the_user()
    {
        Notification::assertTimesSent(1, ImportantStockUpdate::class);
    }

    /** @test */
    function it_refreshes_the_local_stock()
    {
        $this->assertDatabaseHas('stock', [
            'price' => 24900,
            'in_stock' => true
        ]);
    }

    /** @test */
    function it_records_to_history()
    {
        $this->assertEquals(1, History::count());
    }
}
