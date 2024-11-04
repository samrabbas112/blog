<?php


use App\Models\Admin;
use App\Models\Post;
use App\Models\Tag;
use Database\Factories\PostFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PostTest extends TestCase
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
    public function it_returns_all_posts_for_authorized_users()
    {
        // Create an admin user and generate a token


        // Create some posts associated with the admin
        PostFactory::new()->count(3)->create(['admin_id' => $this->admin->id]);

        // Send a GET request to the API with the Authorization header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->json('GET', route('api.v1.posts.index'), ['Accept' => 'application/json']);

        // Assert that the response status is 200 and JSON structure is correct
        $response->assertStatus(201) // Adjust to 201 if that's the correct status code for successful responses
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'slug',
                    'body',
                    'excerpt',
                    'featured_image',
                    'category' => [
                        'id',
                        'name',
                    ],
                    'tags', // This is an array
                    'admin_id',
                    'status',
                    'is_trending',
                    'is_featured',
                    'is_top',
                    'published_at',
                    'meta_description',
                    'meta_keywords',
                    'likes_count',
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
        Post::factory()->count(10)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('GET', route('api.v1.posts.index'));


        // Assert DataTables-specific response structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'draw', 'recordsTotal', 'recordsFiltered', 'data'
            ]);
    }

    /** @test */
    public function it_should_store_the_post()
    {
        Post::factory()->count(1)->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('POST', route('api.v1.posts.store'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'draw', 'recordsTotal', 'recordsFiltered', 'data'
            ]);

    }

    /** @test */
    public function it_should_update_the_post()
    {
        // Create a post instance
        $post = Post::factory()->create();
        $tags = Tag::factory()->count(3)->create();
        // Define the data that should be sent in the request
        $requestData = [
            'title' => 'Updated Title',
            'slug' => 'updated-title',
            'content' => 'Updated content body',
            'excerpt' => 'Updated excerpt',
            'category_id' => 1, // Assuming a category ID is required
            'status' => 'published',
            'published_at' => now()->toDateTimeString(),
            'flag' => 'trending', // or 'featured' or 'top'
            'tags' => $tags->pluck('id')->toArray(), // Example tag IDs
        ];

        // Send the PUT request with the necessary headers and data
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'X-Requested-With' => 'XMLHttpRequest', // This header indicates an AJAX request
        ])->json('PUT', route('api.v1.posts.update', ['post' => $post->id]), $requestData);

        // Assert that the response status is 200 and that the expected structure is present
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'body',
                    'excerpt',
                    'category',
                    'status',
                    'published_at',
                    'is_trending',
                    'is_featured',
                    'is_top',
                    'tags' // If tags are returned as part of the response
                ]
            ]);

        // Optionally assert that the post was updated in the database
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'slug' => 'updated-title',
            'status' => 'published',
            'is_trending' => true,
        ]);
    }


    /** @test */
    public function it_should_delete_the_post()
    {
        $post = Post::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('DELETE', route('api.v1.posts.destroy',['post'=> $post->id]));

        $response->assertStatus(200);

    }





}
