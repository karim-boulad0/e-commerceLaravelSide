<?php

namespace App\Http\Controllers\Dashboard\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Order\AddOrderItemRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{

    public function index()
    {
        $orderItems = OrderItem::with('product', 'order', 'user')
        ->get()
        ->map(function ($orderItems) {
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
        $product->quantity -= $orderItem->quantity;
        $product->save();
        return response()->json(['success' => true, 'order_item' => $orderItem, 'product' => $product]);
    }
}
