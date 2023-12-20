<?php

namespace App\Http\Controllers\WebSite;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status','published')->latest()->take(3)->get();
        return response()->json($products);
    }
    // app/Models/Product.php


    public function getBestProducts()
    {
        $products = Product::with('Images')->where('status','published')->get();

        // Calculate weighted average rating for each product
        foreach ($products as $product) {
            if ($product->ratings_number > 0) {
                $weightedAverage = ($product->rating * $product->ratings_number) / ($product->ratings_number + 1);
                $product->average_rate = round($weightedAverage, 2); // Round to 2 decimal places
            } else {
                $product->average_rate = $product->rating;
            }
        }

        // Sort products based on the calculated average rating in descending order
        $sortedProducts = $products->sortByDesc('average_rate');

        // Retrieve the top five products
        $topFiveProducts = $sortedProducts->take(20);

        return $topFiveProducts;
    }


    public function productsWithImages()
    {
        try {
            $productsWithImages = Product::with('Images', 'reviews')->get();
            $productsWithImages->each(function ($product) use (&$i) {
                $ratingsNumber  = $product->reviews->count();
                $averageRate = round($product->reviews->avg('rate'));
                $product->rating = $averageRate;
                $product->ratings_number = $ratingsNumber;
                $product->save();
            });
            return response()->json([$productsWithImages]);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }


    public function Product($id)
    {
        try {
            $product = Product::with('reviews', 'images')->findOrFail($id);
            if ($product->reviews->count() > 0) {
                $ratingsNumber  = $product->reviews->count();
                $averageRate = ($product->reviews->avg('rate'));
                $product->rating = $averageRate;
                $product->ratings_number = $ratingsNumber;
                $product->save();
            } else {
                $averageRate = null;
            }

            return response()->json(['data' => $product, 'average_rate' => $averageRate], 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 600);
        }
    }
}
