<?php


namespace App\Services\Dashboard\Product;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;

class DeleteProductWithItsImages
{
    private function deleteProductImage(ProductImage $productImage)
    {
        // Build the full path to the image file
        $path = public_path('/images/') . basename($productImage->image);
        if (File::exists($path)) {
            File::delete($path);
        }
        $productImage->delete();
    }

    public function destroy($id)
    {
        // Retrieve product images associated with the product
        $productImages = ProductImage::where('product_id', $id)->get();
        // Delete images from storage and database
        foreach ($productImages as $productImage) {
            $this->deleteProductImage($productImage);
        }
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'success delete product with its images'], 200);
    }
}
