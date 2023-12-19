<?php

namespace App\Http\Controllers\Dashboard\Order;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class OrderStatisticController extends Controller
{

    private function processOrders($orders)
    {
        $productCount = 0;
        $totalPrice = 0;

        foreach ($orders as $order) {
            foreach ($order->orderItems as $orderItem) {
                if ($orderItem->status !== 'pending') {
                    $productCount += $orderItem->quantity;
                    $originalPrice = $orderItem->product->price;
                    $discountedPrice = $originalPrice - ($originalPrice * ($orderItem->product->discount / 100));
                    // Accumulate the total price for each order item
                    $totalPrice += $discountedPrice * $orderItem->quantity;
                }
            }
        }

        return [
            'productCount' => $productCount,
            'totalPrice' => $totalPrice,
        ];
    }
    public function statistic($selectDay, $selectedMonth, $selectedYear, $selectStatus)
    {
        $YearlyMonthlyDailyOrders = Order::with('orderItems.product')
            ->where('status', $selectStatus)
            ->whereDay('created_at', $selectDay)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->get();

        $YearlyMonthlyOrders = Order::with('orderItems.product')
            ->where('status', $selectStatus)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->get();

        $YearlyOrders = Order::with('orderItems.product')
            ->where('status', $selectStatus)
            ->whereYear('created_at', $selectedYear)
            ->get();

        $result = [
            'YearlyMonthlyDailyOrders' => $this->processOrders($YearlyMonthlyDailyOrders),
            'YearlyMonthlyOrders' => $this->processOrders($YearlyMonthlyOrders),
            'YearlyOrders' => $this->processOrders($YearlyOrders),
        ];

        return response()->json($result);
    }



    // public function statistic($selectDay, $selectedMonth, $selectedYear, $selectStatus)
    // {
    //     $YearlyMonthlyDailyOrders = Order::with('orderItems.product')
    //         ->where('status', $selectStatus)
    //         ->whereDay('created_at', $selectDay)
    //         ->whereMonth('created_at', $selectedMonth)
    //         ->whereYear('created_at', $selectedYear)->get();
    //     $YearlyMonthlyOrders = Order::with('orderItems.product')
    //         ->where('status', $selectStatus)
    //         ->whereMonth('created_at', $selectedMonth)
    //         ->whereYear('created_at', $selectedYear)->get();
    //     $YearlyOrders = Order::with('orderItems.product')
    //         ->where('status', $selectStatus)
    //         ->whereYear('created_at', $selectedYear)->get();

    //     return response()->json([
    //         'YearlyMonthlyDailyOrders' => $YearlyMonthlyDailyOrders,
    //         'YearlyMonthlyOrders' => $YearlyMonthlyOrders,
    //         'YearlyOrders' => $YearlyOrders,
    //     ]);
    // }


    public function productsAreAboutRunOut()
    {
        $productsAreAboutRunOut = Product::with('Images')->where('quantity', '<', 50)->get();
        return $productsAreAboutRunOut;
    }

    // public function topSellingProducts()
    // {
    //     $topSellingProducts = (new Product())
    //         ->withCount('carts as orders_count')
    //         ->with('Images')
    //         ->orderByDesc('orders_count')
    //         ->take(5)
    //         ->get();
    //     return $topSellingProducts;
    // }
}
