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

    public function index(Request $request)
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters([
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('title', 'like', "%{$value}%");
                }),
            ])
            ->take(30)
            ->orderBy('created_at', 'desc')
            ->get();
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
            return response()->json([
             'data'  => $category->products,
             'category'=>$category->title,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}
