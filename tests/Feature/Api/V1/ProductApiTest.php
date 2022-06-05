<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Carbon\Carbon;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        // Authenticate user
        // Passport::actingAs(
        //     User::factory()->create(),
        //     ['all']
        // );
    }

    public function test_product_index() {
        // Load data in DB
        $products = Product::factory(10)->create();
        $productIds = $products->map(fn ($product) => $product->id);

        // Call index endpoint
        $response = $this->json(
            $method = 'GET', 
            $uri = "/api/products"
        );

        // Asseert status
        $response->assertStatus(200);

        // Verify records
        $productData = $response->json('data');

        collect($productData)->each(
            fn ($product) => $this->assertTrue($productIds->contains($product['id']))
        );
    }

    public function test_show_product() {
        $dummy = Product::factory()->create();

        $response = $this->json($method = "GET", $uri = "/api/products/$dummy->id");

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals($dummy->id, $result['id'], "Response ID does not match expected.");
    }

    public function test_create_product_without_auth() {
        $product = Product::factory()->make([
            'user_id' => 0
        ])->toArray();

        $response = $this->json(
            $method = 'POST', 
            $uri = "/api/products",
            $data = $product,
        );
        
        $result = $response
                    ->assertStatus(401);
    }
    
    public function test_create_product_with_wrong_auth_scope() {
        Passport::actingAs(
            User::factory()->create()
        );

        $product = Product::factory()->make([
            'user_id' =>auth()->user()->id
        ])->toArray();

        $response = $this->json(
            $method = 'POST', 
            $uri = "/api/products",
            $data = $product,
        );

        $result = $response->assertStatus(403);
    }

    public function test_create_product_with_right_auth_scope() {
        Passport::actingAs(
            User::factory()->create(),
            ['all']
        );

        $product = Product::factory()->make([
            'user_id' => auth()->user()->id,
            // 'created_at' => Carbon::now(),
            // 'updated_at' => Carbon::now(),
        ])->toArray();

        $response = $this->json(
            $method = 'POST', 
            $uri = "/api/products",
            $data = $product,
        );

        // dump($product);
        // dump($response->json('data.id'));

        $result = $response->assertStatus(201)
                        ->assertJson(fn (AssertableJson $json) =>
                            $json->where('data.name', $product['name'])
                                    ->where('data.description', $product['description'])
                                    ->where('data.slug', $product['slug'])
                                    ->where('data.price', $product['price'])
                                    ->etc()
                        );
    }
}
