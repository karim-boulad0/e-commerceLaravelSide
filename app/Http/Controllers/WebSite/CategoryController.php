<?php

namespace App\Http\Controllers\WebSite;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // latest () it shows the newest first
        // skip (1) means the first category i don't want show
        // take(2) show just two categories
        $categories = Category::with('products')->latest()->take(6)->get();
        return $categories;
    }
    public function all(Request $request)
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters([
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('title', 'like', "%{$value}%");
                }),
            ])
            ->get();
        return $categories;
    }
    public function categoriesWithProducts()
    {
        $categoriesWithProducts = Category::with('products')->get();
        return $categoriesWithProducts;
    }

    public function categoriesWithProductsById(Request $request, $id)
    {
        try {
            $category = Category::with(['products' => function ($query) use ($request) {
                $query->where('status', 'published')->with('images');
                QueryBuilder::for($query, $request)
                    ->allowedFilters([
                        AllowedFilter::callback('item', function (Builder $query, $value) {
                            $query->where('title', 'like', "%{$value}%");
                        }),
                    ]);
            }])->where('id', $id)->first();
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }
            return $category->products;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}
