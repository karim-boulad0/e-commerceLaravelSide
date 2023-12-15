<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewClientOrder extends Notification
{
    use Queueable;

    protected $client, $order;
    public function __construct($client, $order)
    {
        $this->client = $client;
        $this->order = $order;
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'order' => $this->order,
            'client' => $this->client,
        ]))->onConnection('sqs')->onQueue('broadcasts');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'client' => $this->client,
            'order' => $this->order,
        ];
    }
}
