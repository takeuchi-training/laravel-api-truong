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
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5Njc0MDU2OS1hNjE4LTQ3YWMtOTI4Mi1kMWE4MWE5ZThlZWMiLCJqdGkiOiI2NDc2ZTliMzVkZTBkZTcyYjQzNDBhMjhkNzAyYTkwNmFkM2QzODQ2ODFjNGQyMDhhN2FlMzY3ZmRjNDA2MzE1MGZhOGExMDllNmUzMWRmNCIsImlhdCI6MTY1NDI1MDUyMS43MzY5NTMsIm5iZiI6MTY1NDI1MDUyMS43MzY5NTYsImV4cCI6MTY4NTc4NjUyMS43MzA4NTcsInN1YiI6IjMxIiwic2NvcGVzIjpbXX0.pBDWrLw4yuBTaT-64ZLNJYRDg-hTzuiQJqUypj-pCC7dMqjYvE4sgrzzGYvnDCG1mVC-rVNIR2l1Jlhs25OMpcF8osoIv4OqfMrTR_camhL5PydnT-XUgbkfO2Xutec7vBnn3TdR-8QLaKnkT0Y6U_bc7DhyE1OKUJVsn7Ofdu2AYaokJal3eZQjCHzTVizncKdDpGslMwOWoBoMLWc-Dp6XVUUPUGJQ_az_IxUxtbtZVR4CbW2D17Vs0-jXuUnt6xuAh0xrzxr5SFCPsOwpZ4PDNuCVSqR5DBYhJuzgz9jvtw2Aquz-iZ70bIV64d7yq0Bu4QocUPJ_I3IKWDkbi9H6kbO8pBGTMF40tdtSuHNfJZgZB0T3SLDSqZFGGS7CPfHqb621IezBVMEI3tbL0IUCAn7xFYdi4Lcrw7LY_gbf30-DI7GCa3wWd1rJNdNpXyF1k8KYFDOKmH8KTYP5zLESyZihTtPMBom-WHy7UbB1ZAzLBox-TRLG7DqXLLGT1Uy2-Wtmb-Cw5ZmHBIXM6GaK3lpE7nECxb9-iSoeS-HSp8Bjcv3qKC2H5laOV0uzb2Cd0_VdY1RA64qmNaHJZM1AB0EvrVqb6cLLv0-_7l2NU7GZ0c80oTweXGDvprEozlfZX8lYKSNgEGcN9o3puV7OhS_am4nMMLlW5VJUoTY'
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
