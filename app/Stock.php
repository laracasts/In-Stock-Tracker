<?php

namespace App;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        $status = $this->retailer
            ->client()
            ->checkAvailability($this);

        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price
        ]);

        $this->recordHistory();
    }

    protected function recordHistory(): void
    {
        $this->history()->create([
            'price' => $this->price,
            'in_stock' => $this->in_stock,
            'product_id' => $this->product_id
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
