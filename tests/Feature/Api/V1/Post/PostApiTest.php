<?php

namespace Tests\Feature\Api\V1\Post;

use App\Events\Models\User\UserCreated;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
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
    public function test_show()
    {
        // create a new post
        $post = Post::factory()->create();
        // Call the show endpoint
        $response = $this->json('get','api/v1/posts/'.$post->id);
        // Asset status code is 200
        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(data_get($result, 'id'), $post->id);
    }
    public function test_create()
    {
        Event::fake();
        // Make a new post
        $post =  Post::factory()->make();
        // Call the create endpoint
        $response = $this->json('post','api/v1/posts', $post->toArray());
        // Assert status code is 201
        $result = $response->assertStatus(201)->json('data');
        // Check if Event is dispatched
        // Event::assertDispatched(PostCreated::class);
        $result = collect($result)->only(array_keys($post->getAttributes()));
        $result->each(function ($value, $field) use ($post){
            $this->assertSame(data_get($post, $field), $value, "Fillable is not the same");
        });
    }
    public function test_update()
    {
        $post = Post::factory()->create();
        $post1 = Post::factory()->make();
        $fillable = collect((new Post())->getFillable());
        $fillable->each(function ($toUpdate) use ($post, $post1){
            $response = $this->json("put", 'api/v1/posts/'. $post->id,[
                $toUpdate => data_get($post1, $toUpdate)
            ]);

            // Assert status code
            $result = $response->assertStatus(200)->json('data');
            $this->assertSame(data_get($post1, $toUpdate), data_get($post->refresh(), $toUpdate), "Post not updated successfully");
        });
    }
    public function test_delete()
    {
        $post =  Post::factory()->create();
        $response = $this->json("delete", "api/v1/posts/".$post->id);
        // Assert status code
        $response->assertStatus(200)->json('data');
        $this->expectException(ModelNotFoundException::class);
        Post::query()->findOrFail($post->id);
    }
}
