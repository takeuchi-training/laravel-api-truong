<?php 

namespace App\Repositories;

interface ProductRepositoryInterface {
    public function getAllProducts();
    public function getAllProductsPaginated($productPerPage);
    public function searchProductByContent($content);
    public function getProductById($productId);
    public function createProduct(array $productDetails);
    public function updateProduct($productId, array $newProductDetails);
    public function deleteProduct($productId);
}