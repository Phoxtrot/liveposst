<?php

namespace Tests\Feature\Api\V1\User;

use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_index()
    {
        // Load data to Db
        $users = User::factory(10)->create();
        $userIds = $users->map(fn ($user)=>$user->id);
        // Call the endpoint
        $response = $this->json("get","api/v1/users");
        // Assert the status code
        $response->assertStatus(200);
        $data = $response->json("data");
        collect($data)->each(fn ($user)=> assertTrue(in_array($user["id"], $userIds->toArray())));
    }
    public function test_show()
    {
        $user = User::factory()->create();
        $response = $this->json("get","api/v1/users/".$user->id);
        $result= $response->assertStatus(200)->json("data");
        $this->assertEquals(data_get($result, 'name'), $user->name);
    }
    public function test_create()
    {
        $user =  User::factory()->make();
        $userArr = $user->toArray();
        $userArr['password'] = data_get($user, 'password');
        $response = $this->json("post","api/v1/users", $userArr);
        // Assert status code is 201
        $result = $response->assertStatus(201)->json('data');

        $result = collect($result)->only(array_keys($user->getAttributes()));
        $result->each(function ($value, $field) use ($user){
            $this->assertSame(data_get($user, $field), $value, "Fillable is not the same");
        });
    }
    public function test_update()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->make();
        $fillable = collect((new User())->getFillable());
        $fillable->each(function ($toUpdate) use ($user, $user2){
            $response = $this->json("put", "api/v1/users/".$user->id,[
                $toUpdate = data_get($user2, $toUpdate)
            ]);
            $result = $response->assertStatus(200)->json('data');
            $this->assertSame(data_get($user2, $toUpdate), data_get($user->refresh(),$toUpdate,),"User not updated");
        } );
    }
    public function test_delete()
    {
        $user = User::factory()->create();
        $response = $this->json("delete", "api/v1/users/".$user->id);
        $response->assertStatus(200)->json('data');
        $this->expectException(ModelNotFoundException::class);
        User::query()->findOrFail($user->id);
    }
}
