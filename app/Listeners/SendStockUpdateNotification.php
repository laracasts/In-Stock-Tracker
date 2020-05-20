<?php

namespace App\Listeners;

use App\User;
use App\Events\NowInStock;
use App\Notifications\ImportantStockUpdate;

class SendStockUpdateNotification
{
    /**
     * Handle the event.
     *
     * @param  NowInStock  $event
     * @return void
     */
    public function handle(NowInStock $event)
    {
        User::first()->notify(new ImportantStockUpdate($event->stock));
    }
}
