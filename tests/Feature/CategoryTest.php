<?php


use App\Models\Admin;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function  setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh --seed');
        $this->admin = Admin::factory()->create();
        $this->token = $this->admin->createToken('AdminToken')->plainTextToken;
        $this->actingAs($this->admin,'admin');
    }
    /** @test */
    public function it_returns_all_categories_for_authorized_users()
    {
        // Create an admin user and generate a token


        // Create some posts associated with the admin
        \Database\Factories\CategoryFactory::new()->count(3)->create();

        // Send a GET request to the API with the Authorization header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->json('GET', route('api.v1.category.index'), ['Accept' => 'application/json']);

        // Assert that the response status is 200 and JSON structure is correct
        $response->assertStatus(201) // Adjust to 201 if that's the correct status code for successful responses
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ],
            ],
            'message'
        ]);

    }


    /** @test */
    public function it_returns_datatables_formatted_response_when_ajax_request()
    {
        // Create posts to test DataTable transformation
        \App\Models\Category::factory()->count(10)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('GET', route('api.v1.category.index'));


        // Assert DataTables-specific response structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'draw', 'recordsTotal', 'recordsFiltered', 'data'
            ]);
    }

    /** @test */
    public function it_should_store_the_category()
    {
        $data = [
          'name' => 'New Category'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('POST', route('api.v1.category.store',$data));

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $data);

    }

    /** @test */
    public function it_should_update_the_category()
    {
        // Create a post instance
        $category = \App\Models\Category::factory()->create();
        // Define the data that should be sent in the request
        $requestData = [
            'name' => 'Updated Title',
        ];

        // Send the PUT request with the necessary headers and data
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('PUT', route('api.v1.category.update', ['category' => $category->id]), $requestData);

        // Assert that the response status is 200 and that the expected structure is present
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',

                ]
            ]);

        // Optionally assert that the post was updated in the database
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Title',

        ]);
    }


    /** @test */
    public function it_should_delete_the_category()
    {
        $category = \App\Models\Category::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('DELETE', route('api.v1.category.destroy',['category'=> $category->id]));

        $response->assertStatus(200);

    }





}
