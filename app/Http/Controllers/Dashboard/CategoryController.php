<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Categories\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Categories\CategoryUpdateRequest;
use Illuminate\Support\Facades\File;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

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
            ->orderBy('created_at', 'desc')
            ->get();
        return $categories;
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = new Category();
        $category->title = $request->title;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = 'images';
            $file->move($path, $filename);
            $category->image = url('/') . '/images/' . $filename;
        }
        $category->save();
        return response()->json(
            [
                'message' => 'success create category',
                'category' => $category
            ],
            200
        );
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function edit(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->title = $request->title;
        if ($request->hasFile('image')) {
            $oldPath = public_path() . '/images/' . substr($category['image'], strrpos($category['image'], '/') + 1);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $file = $request->file('image');
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = 'images';
            $file->move($path, $filename);
            $category->image = url('/') . '/images/' . $filename;
        }
        $category->save();
        return $category;
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $path = public_path() . '/images/' . substr($category['image'], strrpos($category['image'], '/') + 1);
        if (File::exists($path)) {
            File::delete($path);
        }
        $category->delete();
        return 'success';
    }
}
