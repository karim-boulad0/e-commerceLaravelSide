<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $client, $order, $allAdmin;
    public function __construct($client, $order, $allAdmin)
    {
        $this->client = $client;
        $this->order = $order;
        $this->allAdmin = $allAdmin;
    }
    public function getClient()
    {
        return $this->client;
    }
    public function getOrder()
    {
        return $this->order;
    }
    public function getAllAdmin()
    {
        return $this->allAdmin;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('Notifications'),
        ];
    }
    public function broadcastAs()
    {
        return 'NewOrderNotificationEvent';
    }
}
