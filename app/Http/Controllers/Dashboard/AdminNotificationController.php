<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminNotificationController extends Controller
{

    public function index()
    {
        $admin = User::find(auth()->id());
        $notifications = $admin->notifications->where('type', 'App\Notifications\NewClientOrder');
        return response()->json([
            'notifications' => $notifications,
        ]);
    }

    public function getById($id)
    {
        $admin = User::find(auth()->id());
        $notification = $admin->notifications->where('id', $id)->first();
        if ($notification) {
            $orderData = $notification->data['order'];
            $notificationInfo = [
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
                'id' => $notification->id,
            ];
            $resultArray = array_merge($orderData, $notificationInfo);
            return $resultArray;
        }
        return null;
    }



    function  countUnreadNotifications()
    {
        $admin = User::find(auth()->id());
        $notifications = $admin->notifications;
        $countNotifications =   $notifications->where('read_at', null)->where('type','App\Notifications\NewClientOrder')->count();
        return $countNotifications;
    }

    function unreadNotifications()
    {
        $admin = User::find(auth()->id());
        return response()->json([
            'unreadNotifications' => $admin->unreadNotifications
        ]);
    }

    function markAllAsRead()
    {
        $admin = User::find(auth()->id());
        $admin->unreadNotifications->markAsRead();
        // $admin->unreadNotifications()->all()->update(['read_at' => now()]);
        return response()->json([
            'markAsRead' => 'success'
        ]);
    }
    function markAsReadById($id)
    {
        $admin = User::find(auth()->id());
        $admin->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json([
            'markAsReadById' => 'success'
        ]);
    }
    function deleteAll()
    {
        $admin = User::find(auth()->id());
        $admin->notifications()->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }
    function deleteById($id)
    {
        $admin = User::find(auth()->id());
        $admin->notifications()->where('id', $id)->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }
}
