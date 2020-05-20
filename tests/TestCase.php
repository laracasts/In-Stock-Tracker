<?php

namespace Tests;

use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function mockClientRequest($available = true, $price = 29900)
    {
        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available, $price));
    }
}
