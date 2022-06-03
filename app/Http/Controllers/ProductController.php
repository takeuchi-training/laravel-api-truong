<?php

namespace App\Http\Controllers;

use App\Events\ProductPost;
use App\Http\Requests\ProductPostRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Notifications\PostSuccessFullNotification;
use App\Repositories\ProductRepositoryInterface;
use Barryvdh\Reflection\DocBlock\Type\Collection as TypeCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use phpDocumentor\Reflection\Types\Collection as TypesCollection;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productRepository->getAllProducts());
    }

    /**
     * Display a search result for the resource.
     *
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    public function search($content): ProductResource
    {
        return new ProductResource($this->productRepository->searchProductByContent($content));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $storeProductRequest): ProductResource
    {
        // if (!$user->tokenCan('manipulate_product')) {
        //     abort(403, "Sorry! You don't have permission.'");
        // }
            
        $user = auth()->user();

        $productInputs = $storeProductRequest->validated();
        $productInputs['user_id'] = $user->id;

        $product = $this->productRepository->createProduct($productInputs);

        event(new ProductPost($user, $product));

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($productId): ProductResource
    {
        return new ProductResource($this->productRepository->getProductById($productId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $updateProductRequest, $productId) : JsonResponse
    {
        // if (!$request->user()->tokenCan('manipulate_product')) {
        //     abort(403, "Sorry! You don't have permission.'");
        // }

        
        $newProductInputs = $updateProductRequest->validated();
        return response()->json([
            'data' => $this->productRepository->updateProduct($productId, $newProductInputs)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId) : JsonResponse
    {
        // if (!$request->user()->tokenCan('manipulate_product')) {
        //     abort(403, "Sorry! You don't have permission.'");
        // }

        return response()->json([
            'data' => $this->productRepository->deleteProduct($productId)
        ]);
    }
}