<?php

namespace App\Http\Controllers\WebSite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ClientNotificationController extends Controller
{
    function  index()
    {
        $client = User::find(auth()->id());
        $notifications = $client->notifications->where('type', 'App\Notifications\EditOrderStatus');

        return response()->json([
            'notifications' => $notifications
        ]);
    }

    public function getById($id)
    {
        $client = User::find(auth()->id());
        $notification = $client->notifications->where('id', $id)->first();
            return $notification;
    }




    function  countUnreadNotifications()
    {
        $client = User::find(auth()->id());
        $notifications = $client->notifications;
        $countNotifications =   $notifications->where('read_at', null)->where('type','App\Notifications\EditOrderStatus')->count();
        return $countNotifications;
    }
    function unreadNotifications()
    {
        $client = User::find(auth()->id());
        return response()->json([
            'unreadNotifications' => $client->unreadNotifications
        ]);
    }
    function markAllAsRead()
    {
        $client = User::find(auth()->id());
        $client->unreadNotifications->markAsRead();
        // $client->unreadNotifications()->all()->update(['read_at' => now()]);
        return response()->json([
            'markAsRead' => 'success'
        ]);
    }
    function markAsReadById($id)
    {
        $client = User::find(auth()->id());
        $client->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json([
            'markAsReadById' => 'success'
        ]);
    }
    function deleteAll()
    {
        $client = User::find(auth()->id());
        $client->notifications()->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }
    function deleteById($id)
    {
        $client = User::find(auth()->id());
        $client->notifications()->where('id', $id)->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }
}
