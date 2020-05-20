<?php

namespace App\Events;

use App\Stock;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NowInStock
{
    use Dispatchable, SerializesModels;

    /**
     * @var \App\Stock
     */
    public Stock $stock;

    /**
     * Create a new event instance.
     *
     * @param  \App\Stock  $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }
}
