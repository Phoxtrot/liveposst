<?php
namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository{
    public function store($attributes)
    {
        return DB::transaction(function() use ($attributes){
            $user = User::query()->create([
                'name' => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email'),
                'password' => data_get($attributes, 'password'),
            ]);
            throw_if(!$user, GeneralJsonException::class, "User not created",422);
            return $user;
        });

    }
    public function update($user,$attributes )
    {
        return DB::transaction(function() use ($attributes,$user){
            $updated = $user->update([
                'name' => data_get($attributes, 'name') ?? $user->name,
                'email' => data_get($attributes, 'email') ?? $user->email,
                'password' => data_get($attributes, 'password') ?? $user->password,

            ]);
            throw_if(!$updated, GeneralJsonException::class, "User not updated", 422);
            return $user;
        });


    }
    public function forceDelete($user)
    {
        $deletedUser = $user->forceDelete();
        throw_if(!$deletedUser, GeneralJsonException::class, "User not deleted", 422);
        return $user;
    }
}
