<?php
namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    // private User $user;

    // public function __construct() 
    // {
    //     $this->user = User::factory()->create();

    //     $this->actingAs($this->user, 'api');
    // }

    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_a_basic_request()
    // {
    //     $response = $this
    //         ->withHeaders([
    //             'Authorization' => 'Bearer '
    //         ])
    //         ->post('/api/products', [
    //             'name' => 'Example test',
    //             'description' => 'Example description',
    //             'slug' => 'example-test',
    //             'price' => '55.55',
    //             'user_id' => '1020'
    //         ]);
 
    //     $response->assertStatus(302);
    // }

        /**
     * A basic functional test example.
     *
     * @return void
     */
    // public function test_making_an_api_request()
    // {
    //     $response = $this
    //         // ->withHeaders([
    //         //     'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NjcxZjE0OC05MTE5LTQ0NjYtOTYzNC0zOWY0NzhmNGJlNmIiLCJqdGkiOiIyZmE1YzFkZGVjODI3YTk5NDA3MTAzMWJjYmM1MmVjNDMyMDE3ZjcwNmQ2MzhmZjQ5ZmNkODUxNDM5ZGI4MDEyOGRlZGU3Y2VjNWQxZGZmZiIsImlhdCI6MTY1NDIyODM0Mi4xMjE2ODQsIm5iZiI6MTY1NDIyODM0Mi4xMjE2ODgsImV4cCI6MTY4NTc2NDM0Mi4wOTU3LCJzdWIiOiIxMDIwIiwic2NvcGVzIjpbImFsbCJdfQ.moQ4iaKOxNOy8RootQrt3aN5QEs3WS59iaI9pI34lwHj1Ve5SG1AZL68pR4zaMJh6aC80ri__ZU2ylpJ8QDuBquiy8rCKWzKH9rlWf-jtVOYr44dN8OxohGLxwUhijbmfFEV7ewLVmKgg388VFFj6fPT-qa4XmiushrJTjnERFgyN9QzvGi58wSzZLnl11nCUKxqvbg4KYBMR03gjI6NcyFZf98Ob2__giK_Zypd_Y8bO9NFJIWYDFs8t4qGC-mctzkgNTREJvOJYVPeEANbFrZxWL7WlBxqzuTM8o-1ozqckhVB-NRYNRsdz6J0DCwXbgo86OwmlFSm450Hyoslmp3ES2srQ4wI47Fa-Q-bemuNzLsCfv_zlo3oMeTX32f35H13JFG8SfEXDYygDGAOzMgUUz1LLNp4R6-4sSEPaSHziSeEHSmxM8ZvHQp1I6foHk4tNw4kgnGxaiAwwJtwUv-uiod8vpXC02b8qY0ceixYOtpJ3Q65O13WxFCOgERXwfPB8sjxvhIy0RGbQhvUKHWEaqkMRZRyDlelD9_PqoE5FFmQOOWMCfSDy5aKSlymg_T4E-0Q8CLU-iZ2Lj0tQlvObtQGE2dpDZTQujajfcuf01MhLdjOgzX15gh0ksV1fdDXZ8ZSyiZJ1cKZQJ_4vGofqA2RPbr0IgDEF4BLVxA'
    //         // ])
    //         ->postJson('/api/products', [
    //             'name' => 'Example test json 3',
    //             'description' => 'Example description json 3',
    //             'slug' => 'example-test-json-3',
    //             'price' => '55.55',
    //             'user_id' => '1020'
    //         ]);
 
    //     $response
    //         ->assertStatus(201);
    // }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    // public function test_fluent_json()
    // {
    //     $response = $this->getJson('/api/products/');
    
    //     $response
    //         ->assertJson(fn (AssertableJson $json) =>
    //             $json->has('data')
    //                 ->has('data', 1129, fn ($json) =>
    //                     $json
    //                         ->where('id', 7)
    //                         ->where('name', 'vel odio')
    //                         ->missing('password')
    //                         ->etc()
    //                 )
    //         );
    // }
}
