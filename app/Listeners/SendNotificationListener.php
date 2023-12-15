<?php

namespace App\Listeners;

use Pusher\Pusher;
use App\Notifications\NewClientOrder;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NewOrderNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationListener
{
    public function handle(NewOrderNotificationEvent $event): void
    {
        $allAdmin = $event->getAllAdmin();
        $notification = Notification::send($allAdmin, new NewClientOrder($event->getClient(), $event->getOrder()));
    }
}
