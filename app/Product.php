<?php

namespace App;

class Product extends Model
{
    public function track()
    {
        $this->stock->each->track(
            fn($stock) => $this->recordHistory($stock)
        );
    }

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function recordHistory(Stock $stock)
    {
        $this->history()->create([
            'price' => $stock->price,
            'in_stock' => $stock->in_stock,
            'stock_id' => $stock->id
        ]);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
