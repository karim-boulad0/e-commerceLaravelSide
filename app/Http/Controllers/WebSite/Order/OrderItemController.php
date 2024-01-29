<?php

namespace App\Http\Controllers\WebSite\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Order\AddOrderItemRequest;
use App\Http\Requests\WebSite\EditOrderItemRequest;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{

    public function index()
    {
        $userId = auth()->user()->id;
        $orderItems = OrderItem::with('product.Images',  'user.userDetails')
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->get()
            ->map(function ($orderItem) {
                return [
                    // order Item info
                    'id' => $orderItem->id,
                    'status' => $orderItem->status,
                    'quantity' => $orderItem->quantity,
                    'note' => $orderItem->note,
                    // user info
                    'name' => $orderItem->user->name,
                    'email' => $orderItem->user->email,
                    'phone_number' => $orderItem->user->phone_number,
                    'address' => $orderItem->user->userDetails->address,
                    // product info
                    'title' => $orderItem->product->title,
                    'About' => $orderItem->product->About,
                    'description' => $orderItem->product->description,
                    'discount' => $orderItem->product->discount,
                    'price' => $orderItem->product->price,
                    'image' => $orderItem->product->Images->first()->image,
                ];
            });
        return $orderItems;
    }
    public function addOrderItem($product_id, AddOrderItemRequest $request)
    {
        // Get the authenticated user
        $user = auth()->user();
        // Find the product
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }
        // Create a new order item using data from the request
        $orderItem = OrderItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity, // Default to 1 if quantity is not provided
            'note' => $request->note,
            'status' => 'pending',
        ]);


        return response()->json(['success' => true, 'order_item' => $orderItem, 'product' => $product]);
    }



    private function updateProductQuantity(Product $product, OrderItem $orderItem, Request $request)
    {
        $quantityChange = $request->quantity - $orderItem->quantity;

        if ($request->status == 'confirmed') {
            if ($orderItem->status == 'pending') {
                $product->quantity -= $orderItem->quantity;
            } elseif ($orderItem->status == 'confirmed') {
                $product->quantity -= $quantityChange;
            }
        } elseif ($request->status == 'pending' && $orderItem->status == 'confirmed') {
            $product->quantity += $orderItem->quantity;
        }

        // Ensure the product's quantity does not go below zero
        $product->quantity = max(0, $product->quantity);

        $product->save();
    }
    public function editOrderItem(EditOrderItemRequest $request)
    {
        $orderItem = OrderItem::with('product')->find($request->id);

        if (!$orderItem) {
            return response()->json(['error' => 'Order item not found'], 404);
        }

        $product = Product::find($orderItem->product->id);

        $this->updateProductQuantity($product, $orderItem, $request);

        $orderItem->update([
            'quantity' => $request->quantity,
            'note' => $request->note,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Success update', 'id' => $request->id, 'orderItem' => $orderItem]);
    }
    public function deleteOrderItem($id)
    {
        $orderItem = OrderItem::with(['product', 'order' => function ($query) {
            $query->where('status', 'pending');
        }])
            ->find($id);

        if (!$orderItem) {
            return response()->json(['success' => false, 'message' => 'Order item not found'], 404);
        }

        // Check if the related order's status is 'confirmed'
        if ($orderItem->order->status == 'confirmed') {
            return response()->json(['success' => false, 'message' => 'You cannot delete this item; it is confirmed']);
        }
        if ($orderItem->status == 'confirmed') {
            $product = Product::find($orderItem->product->id);
            $product->quantity +=  $orderItem->quantity;
            $product->save();
        }
        $orderItem->delete();

        return response()->json(['success' => true, 'message' => 'Success delete', 'id' => $id, 'order' => $orderItem]);
    }
}
