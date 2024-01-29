<?php

namespace App\Http\Controllers\Dashboard\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Dashboard\Order\UpdateOrderRequest;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Events\ChangeStatusNotificationEvent;
class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders =  QueryBuilder::for(Order::class)
            ->with(['orderItems.product', 'user.userDetails'])

            ->allowedFilters([
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('status', 'like', "%{$value}%")
                        ->orWhereHas('user.userDetails', function ($query) use ($value) {
                            $query->where('name', 'like', "%{$value}%")
                                ->orWhere('last_name', 'like', "%{$value}%")
                                ->orWhere('address', 'like', "%{$value}%")
                                ->orWhere('phone_number', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%");
                        });
                })
            ])
            ->get();


        if ($orders->count() > 0) {
            $confirmedOrders = $orders->filter(function ($order) {
                return $order->orderItems->where('status', 'confirmed')->count() > 0;
            });

            if ($confirmedOrders->count() > 0) {
                $formatOrders = $confirmedOrders->map(function ($order) {
                    $totalPrice = $order->orderItems->sum(function ($orderItem) {
                        if ($orderItem->status  !== 'pending') {
                            $originalPrice = $orderItem->product->price;
                            $discountedPrice = $originalPrice - ($originalPrice * ($orderItem->product->discount / 100));
                            return $discountedPrice * $orderItem->quantity;
                        }
                    });
                    return [
                        'id' => $order->id,
                        'status' => $order->status,
                        'note' => $order->note,
                        'totalPrice' => $totalPrice,
                        'countOrderItems' => $order->orderItems->where('status', 'confirmed')->count(),
                        'countProducts' => $order->orderItems->where('status', 'confirmed')->sum('quantity'),
                        'name' => $order->user->userDetails->first_name,
                        'address' => $order->user->userDetails->address,
                        'phone_number' => $order->user->userDetails->phone_number,
                    ];
                });
                return $formatOrders;
            } else {
                //
            }
        } else {
            //
        }
    }

    public function delete($id)
    {
        $order = Order::where('id', $id)
            ->where('status', 'pending')
            ->delete();
        return $order ? "success delete" : 'doesn\'t exist or not pending';
    }

    public function edit($id)
    {
        $order = Order::find($id);
        return $order;
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $request->validated();
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->status = $request->input('status');
        $order->note = $request->input('note');
        $order->save();
        $user = User::findOrFail($order->user_id);
        Event::dispatch(new ChangeStatusNotificationEvent($user,$request->status));
        return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
    }


    public function getOrderItemsInfo($id)
    {
        $orders = Order::with(['orderItems' => function ($query) {
            $query->whereIn('status', ['confirmed']);
        }, 'orderItems.product.images', 'user.userDetails'])
            ->where('id', $id)->get();


        $formattedOrders = $orders->map(function ($order) {
            $totalPrice = $order->orderItems->sum(function ($orderItem) {
                if ($orderItem->status !== 'pending') {
                    $originalPrice = $orderItem->product ? $orderItem->product->price : 0;
                    $discountedPrice = $originalPrice - ($originalPrice * ($orderItem->product->discount / 100));
                    return $discountedPrice * $orderItem->quantity;
                }
            });

            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'first_name' => $order->user->userDetails->first_name,
                'last_name' => $order->user->userDetails->last_name,
                'phone_number' => $order->user->userDetails->phone_number,
                'email' => $order->user->email,
                'address' => $order->user->userDetails->address,
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
}
