<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create() {
        // 1. Define the goal
        // Test if the function will actually create a record in the DB
        // 2. Replicate the environment / restriction
        $repository = $this->app->make(ProductRepositoryInterface::class);

        // 3. Define the source of truth
        $payload = [
            'user_id' => '1020',
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'This is a test from unit testing',
            'price' => '9.99',
        ];

        // 4. Compare the result
        $result = $repository->createProduct($payload);

        $this->assertSame($payload['name'], $result->name, "Product created does not have the same name.");
    }

    public function test_update() {
        // 1. Define the goal
        // Test if the function will actually update a record in the DB
        // 2. Replicate the environment / restriction
        $repository = $this->app->make(ProductRepositoryInterface::class);
        $dummyProductId = Product::factory(1)->create()->first()->id;

        // 3. Define the source of truth
        $payload = [
            'name' => 'Test product',
        ];

        // 4. Compare the result
        $repository->updateProduct($dummyProductId, $payload);
        $result = Product::find($dummyProductId);

        $this->assertSame($payload['name'], $result->name, "Product updated does not have the same name");
    }

    public function test_delete() {
        // 1. Define the goal
        // Test if the function will actually delete a record in the DB
        // 2. Replicate the environment / restriction
        $repository = $this->app->make(ProductRepositoryInterface::class);
        $dummyProductId = Product::factory(1)->create()->first()->id;

        // 3. Define the source of truth

        // 4. Compare the result
        $repository->deleteProduct($dummyProductId);
        $result = Product::find($dummyProductId);

        $this->assertSame(null, $result, "Product wasn't deleted");
    }

    public function test_non_exist_delete() {
        $this->expectException(ModelNotFoundException::class);
        // $this->expectExceptionMessage('Sorry, there is no such product!');
        $repository = $this->app->make(ProductRepositoryInterface::class);
        $repository->deleteProduct(1);
    }
}
