<?php

namespace App\Clients;

use App\Stock;

interface Client
{
    public function checkAvailability(Stock $stock): StockStatus;
}
