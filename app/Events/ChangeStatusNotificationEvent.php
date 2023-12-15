<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeStatusNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $client, $status;

    public function __construct($client, $status)
    {
        $this->client = $client;
        $this->status = $status; // Set the $status property here
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getStatus()
    {
        return $this->status;
    }

    // public function broadcastOn(): array
    // {
    //     return [
    //         new Channel('ChangeOrderStatusNotifications'),
    //     ];
    // }

    // public function broadcastAs()
    // {
    //     return 'ChangeStatusNotificationEvent';
    // }
}
