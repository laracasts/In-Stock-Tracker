<?php

namespace App\Clients;

use App\Stock;

class Target implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        //
    }
}
