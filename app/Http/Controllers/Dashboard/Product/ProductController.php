<?php

namespace App\Http\Controllers\Dashboard\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Products\ProductStoreRequest;
use App\Http\Requests\Dashboard\Products\ProductUpdateRequest;
use App\Services\Dashboard\Product\DeleteProductWithItsImages;
use App\Services\Dashboard\Product\UpdateProductWithItsImages;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{

    public function index()
    {
        return Product::with('Images')
            ->where('status', '=', 'published')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function filterProducts(Request $request)
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters([
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('title', 'like', "%{$value}%")
                        ->orWhere('About', 'like', "%{$value}%")
                        ->orWhere('price', 'like', "%{$value}%")
                        ->orWhere('status', 'like', "%{$value}%")
                        ->orWhereHas('category', function ($query) use ($value) {
                            $query->where('title', 'like', "%{$value}%");
                        });
                }),
            ])
            ->with('Images', 'category')
            ->orderBy('created_at', 'desc')
            ->get();
        if ($products->count() > 0) {
            $formatProducts =     $products->map(function ($product) {
                $image = isset($product->Images[0]) ? $product->Images[0]->image : null;
                return [
                    'image' => $image,
                    'title' => $product->title,
                    'category' => $product->category,
                    'description' => $product->description,
                    'rating' => $product->rating,
                    'ratings_number' => $product->ratings_number,
                    'status' => $product->status,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'delivery_price' => $product->delivery_price,
                    'About' => $product->About,
                    'quantity' => $product->quantity,
                    'id' => $product->id,
                ];
            });
        } else {
            $formatProducts
                = [];
        }

        return response()->json([
            'products' => $formatProducts
        ], 200);
    }

    public function store(ProductStoreRequest $request)
    {
        $productCreated = Product::create($request->validated());
        return $productCreated;
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        return (new UpdateProductWithItsImages())->update($request, $id);
    }

    public function destroy($id)
    {
        return (new DeleteProductWithItsImages())->destroy($id);
    }
}
