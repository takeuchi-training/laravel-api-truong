<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPostRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Display a search result for the resource.
     *
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    public function search($name) {
        return Product::where('name', 'LIKE', '%' . $name . '%')
                ->orWhere('description', 'LIKE', '%' . $name . '%')
                ->orWhere('slug', 'LIKE', '%' . $name . '%')
                ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreProductRequest $storeProductRequest)
    {
        if (!$request->user()->tokenCan('product_manipulate')) {
            abort(403, "Sorry! You don't have permission.'");
        }

        $product = $storeProductRequest->validated();

        return Product::create($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UpdateProductRequest $updateProductRequest, Product $product)
    {
        if (!$request->user()->tokenCan('product_manipulate')) {
            abort(403, "Sorry! You don't have permission.'");
        }

        $updatedProduct = $updateProductRequest->validated();

        $product->update($updatedProduct);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        if (!$request->user()->tokenCan('product_manipulate')) {
            abort(403, "Sorry! You don't have permission.'");
        }

        return $product->delete();
    }
}