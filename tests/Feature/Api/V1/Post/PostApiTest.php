<?php

namespace Tests\Feature\Api\V1\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPSTORM_META\map;

class PostApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_index()
    {
        // Load data to the database
        $posts = Post::factory(10)->create();
        $postIds = $posts->map(fn ($post)=> $post->id);
        // Call the index endpoint
        $response = $this->json('get', 'api/v1/posts');
        // assert status code 200
        $response->assertStatus(200);
        // verify response
        $data = $response->json('data');
        collect($data)->each(fn ($post)=> $this->assertTrue(in_array($post['id'], $postIds->toArray())));
    }
}
