<?php

namespace App\Notifications;

use App\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportantStockUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Stock
     */
    protected Stock $stock;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Stock  $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Important Stock Update for ' . $this->stock->product->name)
                    ->line('We have an important update to the product you have been tracking.')
                    ->action('Buy It Now', url($this->stock->url))
                    ->line('Go get it!');
    }
}
