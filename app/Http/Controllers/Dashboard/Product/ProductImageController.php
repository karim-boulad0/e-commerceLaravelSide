<?php

namespace App\Http\Controllers\Dashboard\Product;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Products\ProductImagesRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductImageController extends Controller
{

    public function store(Request $request)
    {

        try {
            $product = new ProductImage();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $product->image = url('/') . '/images/' . $filename;
                $path = 'images';
                $file->move($path, $filename);
            }
            $product->product_id = $request->product_id;
            $product->save();
            return $product;
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['error' => 'Internal Server Error'], 500);
        }

    }

    public function productImages($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $productImages = $product->images;
        return response()->json([
            'message' => 'success',
            'data' => $productImages
        ], 200);
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        $path = public_path() . '/images/' . substr($image['image'], strrpos($image['image'], '/') + 1);
        if (File::exists($path)) {
            File::delete($path);
        }
        DB::table('product_images')->where('id', '=', $id)->delete();
        return response()->json(['message' => 'success delete'], 200);
    }
}
