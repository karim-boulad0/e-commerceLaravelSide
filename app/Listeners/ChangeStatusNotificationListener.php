<?php

namespace App\Listeners;

use App\Events\ChangeStatusNotificationEvent;
use App\Notifications\EditOrderStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ChangeStatusNotificationListener
{

    public function handle(ChangeStatusNotificationEvent $event): void
    {
        $notification = Notification::send($event->getClient(), new EditOrderStatus($event->getStatus()));
    }
}
