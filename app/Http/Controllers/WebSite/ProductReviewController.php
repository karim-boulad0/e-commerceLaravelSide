<?php

namespace App\Http\Controllers\Website;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{

    public function CreateProductReview($id, Request $request)
    {
        $request->validate([
            'rate' => 'numeric',
        ]);
        $user = Auth::user();
        $product = Product::find($id);
        if ($product) {
            $existingReview = ProductReview::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
            if ($existingReview) {
                $existingReview->update([
                    'rate' => $request->rate,
                ]);
            } else {
                ProductReview::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rate' => $request->rate,
                    'comment' => 'none',
                ]);
            }
            return response()->json(['message' => 'Product rate updated successfully']);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}
