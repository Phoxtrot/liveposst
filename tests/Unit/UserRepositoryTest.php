<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_create()
  {
     //    Basics Steps for Testing
    // 1. Define the goal of testing
    // check if the create method in the PostRepository actually creates a post
    // 2. Replicate the environment or restriction
    $repository = $this->app->make(UserRepository::class);
    // 3. Define the source of truth
    $payload = [
        "name" => "John Alfa",
        "email" => "john@alfa.com",
        "password" => "hitman47"
    ];
    // 4. Compare the results
    $result = $repository->store($payload);
    $this->assertSame($payload['name'], $result->name);
    $this->assertSame($payload['email'], $result->email);
    $this->assertSame($payload['password'], $result->password);
  }
  public function test_update()
  {
    $repository = $this->app->make(UserRepository::class);
    $user = User::factory(1)->create()->first();
    $payload = [
        "name" => "John New",
    ];
    $updated = $repository->update($user,$payload);
    $this->assertSame($payload['name'], $updated->name);
  }
  public function test_delete()
  {
    $repository = $this->app->make(UserRepository::class);
    $user = User::factory(1)->create()->first();
    $deleted = $repository->forceDelete($user);
    $findDeletedUser = User::find($user->id);
    $this->assertSame(null, $findDeletedUser,"Post not Deleted");
  }
  public function test_throw_exception_when_delete_user_not_exist()
  {
    $repository = $this->app->make(UserRepository::class);
    $user = User::factory(1)->make()->first();
    $this->expectException(GeneralJsonException::class);
    $deleted = $repository->forceDelete($user);
  }
}
