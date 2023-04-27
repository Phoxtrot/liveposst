<?php

namespace App\Http\Controllers;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Events\Models\User\UserUpdated;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        event(new UserCreated(User::factory()->make()));
        $pageSize = $request->pageSize ?? 20;
        $users = User::query()->paginate($pageSize);
        return  UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UserRepository $userRepository)
    {
        $user = $userRepository->store($request->only([
            'name',
            'email',
            'password',
        ]));
        event(new UserCreated($user));
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, UserRepository $userRepository)
    {
        $updated = $userRepository->update($user,$request->only([
            'name',
            'email',
            'password',
        ]));
        event(new UserUpdated($updated));
        return new UserResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserRepository $userRepository)
    {
        $deletedUser = $userRepository->forceDelete($user);
        event(new UserDeleted($deletedUser));
        return new UserResource($user);
    }
}
