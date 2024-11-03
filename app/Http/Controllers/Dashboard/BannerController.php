<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Dashboard\Banners\StoreBannerRequest;
use App\Http\Requests\Dashboard\Banners\BannerUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
class BannerController extends Controller
{
    public function index(Request $request)
    {
        $categories = QueryBuilder::for(Banner::class)
            ->allowedFilters([
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('title', 'like', "%{$value}%");
                }),
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        return $categories;
    }


    public function store(StoreBannerRequest $request)
    {

        $banner = new Banner();
        $banner->title = $request->title;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = 'images';
            $file->move($path, $filename);
            $banner->image = url('/') . '/images/' . $filename;
        }
        $banner->save();
        return response()->json(
            [
                'message' => 'success create banner',
                'banner' => $banner
            ],
            200
        );
    }

    public function show($id)
    {
        return Banner::findOrFail($id);
    }

    public function edit(BannerUpdateRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        if ($request->hasFile('image')) {
            $oldPath = public_path() . '/images/' . substr($banner['image'], strrpos($banner['image'], '/') + 1);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $file = $request->file('image');
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = 'images';
            $file->move($path, $filename);
            $banner->image = url('/') . '/images/' . $filename;
        }
        $banner->save();
        return $banner;
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $path = public_path() . '/images/' . substr($banner['image'], strrpos($banner['image'], '/') + 1);
        if (File::exists($path)) {
            File::delete($path);
        }
        $banner->delete();
        return 'success';
    }
}
