<?php

namespace App;

use App\Events\NowInStock;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track($callback = null)
    {
        $status = $this->retailer
            ->client()
            ->checkAvailability($this);

        if (! $this->in_stock && $status->available) {
            event(new NowInStock($this));
        }

        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price
        ]);

        $callback && $callback($this);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
