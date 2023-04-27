<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_create()
    {
        //    Basics Steps for Testing
    // 1. Define the goal of testing
    // check if the create method in the PostRepository actually creates a post
    // 2. Replicate the environment or restriction
    $repository = $this->app->make(PostRepository::class);
    // 3. Define the source of truth
    $payload = [
        "title" => "heyy",
        "body" => []
    ];
    // 4. Compare the results
    $result = $repository->store($payload);
    $this->assertSame($payload['title'],$result->title, "The post title does not match the request title");
    }
    public function test_update()
    {
        // Check if the update method actualy updates the post
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->create()->first();
        $payload = [
            'title' => 'new title'
        ];
        $updated = $repository->update($dummyPost, $payload);
        $this->assertSame($payload['title'],$updated->title, "The post title does not match the request title");
    }
    public function test_delete()
    {
        // Check if forceDelete is actually delete post
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->create()->first();
        $deleted = $repository->forceDelete($dummyPost);
        $findDeletedUser = Post::find($dummyPost->id);
        $this->assertSame(null, $findDeletedUser, "Post not deleted");
    }
    public function test_delete_should_throw_exception_while_trying_to_delete_post_that_doe_not_exist()
    {
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->make()->first();
        $this->expectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($dummyPost);

    }
}
