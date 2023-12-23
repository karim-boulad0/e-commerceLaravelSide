<?php

namespace App\Http\Controllers\WebSite\Order;

use App\Events\NewOrderNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewClientOrder;
use Illuminate\Support\Facades\Event;

use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{

    public function index()
    {
        $userId = auth()->user()->id;
        $orders = Order::with(['orderItems' => function ($query) {
            $query->whereIn('status', ['confirmed', 'pending']);
        }, 'orderItems.product.images', 'user'])
            ->whereHas('orderItems')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();


        $formattedOrders = $orders->map(function ($order) {
            $totalPrice = $order->orderItems->sum(function ($orderItem) {
                if ($orderItem->status === 'confirmed') {
                    $originalPrice = $orderItem->product ? $orderItem->product->price : 0;
                    $discountedPrice = $originalPrice - ($originalPrice * ($orderItem->product->discount / 100));
                    return $discountedPrice * $orderItem->quantity;
                }
            });

            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'note' => $order->note,
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'total_price' => $totalPrice,
                'order_items' => $order->orderItems->map(function ($orderItem) {
                    return [
                        'id' => $orderItem->id,
                        'order_id' => $orderItem->order_id,
                        'product_id' => $orderItem->product_id,
                        'user_id' => $orderItem->user_id,
                        'quantity' => $orderItem->quantity,
                        'note' => $orderItem->note,
                        'status' => $orderItem->status,
                        'created_at' => $orderItem->created_at,
                        'updated_at' => $orderItem->updated_at,
                        'product' => [
                            'id' => optional($orderItem->product)->id,
                            'price' => optional($orderItem->product)->price,
                            'discount' => optional($orderItem->product)->discount,
                            'title' => optional($orderItem->product)->title,
                            'image' => optional($orderItem->product->Images->first())->image,
                        ],
                    ];
                }),
            ];
        });
        return $formattedOrders;
    }


    public function confirmAll(Request $request)
    {
        // $table->enum('payment_method', ['net', 'on_delivery'])->default('on_delivery');
$request->validate(['payment_method'=>'required']);
        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Retrieve the user's order items
        $userOrderItems = OrderItem::where('user_id', $userId)
            ->where('status', 'pending')
            ->get();

        if ($userOrderItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No pending order items to confirm.']);
        }

        // Create a new order
        $order = Order::create(['user_id' => $userId]);
        if($request){
            $order->payment_method = $request->payment_method;
            $order->save();
        }

        // Update order_id in existing order items
        $userOrderItems->each(function ($orderItem) use ($order) {
            $orderItem->update(['order_id' => $order->id, 'status' => 'confirmed']);
            $product = Product::find($orderItem->product_id);
            $product->quantity -= $orderItem->quantity;
            $product->save();
        });
        $allAdmin = User::where('role', '1995')->get();
        $user = User::with('userDetails')->where('id', $userId)->get();
        $orderN = Order::with('orderItems.product')->where('id', $order->id)->get();
        Event::dispatch(new NewOrderNotificationEvent($user, $orderN, $allAdmin));
        return response()->json(['success' => true, 'message' => 'Order confirmed successfully.']);
    }
}
