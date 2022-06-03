<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index() {
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

        // dump($response->json('data.0'));
    }

    public function test_show() {
        $dummy = Product::factory()->create();

        $response = $this->json($method = "GET", $uri = "/api/products/$dummy->id");

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals($dummy->id, $result['id'], "Response ID does not match expected.");
    }

    public function test_create() {
        $payload = [
            'user_id' => '18',
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'This is a test from unit testing',
            'price' => '9.99',
        ];

        $header = [
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5Njc0MDgzYS1jNTJhLTQ3MzktOWIwZC05ZmM1YmZhYmEzOTIiLCJqdGkiOiJhZWUwMWE3NGE2NDdkNmE4NTVlOTdlNzhjZjZiMGNkNWVjZmIzNDAwMmRjNTVkYWE1OWZhZGU1ZWNmMGIyMzkzNDBjYzIwMzk3ODc4MmJmZSIsImlhdCI6MTY1NDI1MTA1Mi41MjI1NDgsIm5iZiI6MTY1NDI1MTA1Mi41MjI1NTEsImV4cCI6MTY4NTc4NzA1Mi41MTgzNSwic3ViIjoiMTAyMCIsInNjb3BlcyI6WyJhbGwiXX0.ftKXjgHIvRgUtuAGOOEMGFxwbT9JlJqDx6ofnKWyZ5v7iqTWyNC7D6GTfVwXM-hxHSfOYt7cl675XOm872TO7eXOeD2amcl13iEY2fIpU_1E6mUfydd2yUUnBc77XMwPWFLQ9sMqh0Emcz7gEfPp3HWNkmVSSTp-MJU3ikvX-0e12fr6voXruVdELl_slrfqpr2Cxxbm8VidwBMgsS1vCo_MqxYeG-3zH0pBJ649WaSJva6Csz4b5uofWYkbxtMJYW6o_Yq-eeD_nV3reISIeCiUuVvd6H8BgdHOuDSK9-CCeIRH8U3kbbNubuEbCQC-QHARKsB8NweomAKm7AZEhJoIXbVATJT-95gRLF9QOpG0HvwLrhMAPO6Bn3rz6Y9MyJ10UQ4Y6y1wpcY7AkJX-aHF5Wk7gSnJpAw6YVSBEht4m1daHK25-faTwjpP3br-uUys6fLQh2XHg93C8nWvFqJQrg9cuZGCrHslfK5o9I7Vzje2b8KHrAn_ibNVg5kCU0bORsnmaPZkVE1_QkeDwGQIu7dtWT3KjLcwoPoYWfkoQW4vAthDUL_QP7TKIlSubR90Cl4IH4Ctg_hTS_mQfFaKy6Mb6XQh70bikuPsaRD5HEZTXz5s3O2XtvyR2GBalBzcf8otCtap4gkrbaq2yjDjtjocSFybtBTKFrm0gg8'
        ];

        $response = $this->json(
            $method = 'POST', 
            $uri = "/api/products",
            $data = $payload,
            $header = $header
        );

        dump($response);
    }
}
