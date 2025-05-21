<?php


use App\Models\Admin;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TagTest extends TestCase
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
    public function it_returns_all_tags_for_authorized_users()
    {

        // Create some tags associated with the admin
        \Database\Factories\TagFactory::new()->count(3)->create();

        // Send a GET request to the API with the Authorization header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->json('GET', route('api.v1.tags.index'), ['Accept' => 'application/json']);

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
        Tag::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('GET', route('api.v1.tags.index'));


        // Assert DataTables-specific response structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'draw', 'recordsTotal', 'recordsFiltered', 'data'
            ]);
    }

    /** @test */
    public function it_should_store_the_tag()
    {
        $post = Post::factory()->count(1)->create();
        $data = [
            'name' => 'New Tag',
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('api.v1.tags.store',$data));

        $response->assertStatus(201);
        $this->assertDatabaseHas('tags', ['name' => 'New Tag']);


    }

    /** @test */
    public function it_should_update_the_tag()
    {
        // Create a post instance
        $tag = Tag::factory()->create();

        // Define the data that should be sent in the request
        $requestData = [
            'name' => 'Updated Title',
        ];

        // Send the PUT request with the necessary headers and data
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('PUT', route('api.v1.tags.update', ['tag' => $tag->id]), $requestData);

        // Assert that the response status is 200 and that the expected structure is present
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',

                ]
            ]);

        // Optionally assert that the post was updated in the database
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'Updated Title',
        ]);
    }


    /** @test */
    public function it_should_delete_the_tag()
    {
        $tag = Tag::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('DELETE', route('api.v1.tags.destroy',['tag'=> $tag->id]));

        $response->assertStatus(200);

    }





}
