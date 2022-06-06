<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface {
    public function getAllProducts() {
        return Product::with('user')->get();
    }

    public function getAllProductsPaginated($productPerPage) {
        return Product::with('user')->paginate($productPerPage);
    }

    public function searchProductByContent($content) {
        return Product::with('user')
                ->where('name', 'ilike', '%' . $content . '%')
                ->orWhere('description', 'ilike', '%' . $content . '%')
                ->orWhere('slug', 'ilike', '%' . $content . '%')
                ->get();
    }

    public function getProductById($productId) {
        return Product::with('user')->findOrFail($productId);
    }

    public function createProduct(array $productDetails) {
        return Product::create($productDetails);
    }

    public function updateProduct($productId, array $newProductDetails) {
        return Product::find($productId)->update($newProductDetails);
    }

    public function deleteProduct($productId) {
        $product = Product::findOrFail($productId);

        // if ($product === null) {
        //     throw new ModelNotFoundException("Sorry, there is no such product!");
        // }

        $product->delete();
        // return Product::destroy($productId);
    }
}