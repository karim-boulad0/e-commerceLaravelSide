<?php


namespace App\Services\Dashboard\Product;

use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Requests\Dashboard\products\ProductUpdateRequest;

class UpdateProductWithItsImages
{

    private function updateProductImages($request, $productId)
    {
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $index => $file) {
                $image = new ProductImage();
                $image->product_id = $productId;
                $filename = date('YmdHis') . ($index + 1) . '.' . $file->getClientOriginalExtension();
                $path = 'images';
                $file->move($path, $filename);
                $image->image = url('/') . "/$path/$filename";
                $image->save();
            }
        }
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        $product->save();
        $productId = $product->id;
        $this->updateProductImages($request, $productId);
        return $product;
    }
}
