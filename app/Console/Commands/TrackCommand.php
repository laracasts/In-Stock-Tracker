<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    protected $signature = 'track';

    protected $description = 'Track all product stock.';

    public function handle()
    {
        Product::all()
            ->tap(fn($products) => $this->output->progressStart($products->count()))
            ->each(function ($product) {
                $product->track();

                $this->output->progressAdvance();
            });

        $this->showResults();
    }

    protected function showResults(): void
    {
        $this->output->progressFinish();

        $data = Product::query()
            ->leftJoin('stock', 'stock.product_id', '=', 'products.id')
            ->get($this->keys());

        $this->table(
            array_map('ucwords', $this->keys()),
            $data
        );
    }

    protected function keys(): array
    {
        return ['name', 'price', 'url', 'in_stock'];
    }
}
