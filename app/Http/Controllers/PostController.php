<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * @group Post Management
 *
 * Apis to manage post repositories
 */
class PostController extends Controller
{
   /**
     * Display a listing of the Post resource.
     *
     * Get a list of all Post instances
     *
     * @queryParam pageSize String optional. Default is 20. Example: 10
     * @queryParam page String optional. Page you want to view
     *
     * @apiResourceCollection App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function index(Request $request)
    {
        $pageSize = $request->pageSize ?? 10;
        $posts = Post::query()->paginate($pageSize);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created Post in storage.
     *
     * @bodyParam title String required Title of the post
     * @bodyParam body String required Body of the post.
     * @bodyParam user_ids Array required Array of users contributing to the post.
     *
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function store(StorePostRequest $request, PostRepository $postRepository)
    {
        $created = $postRepository->store($request->only([
            'title',
            'body',
            'user_ids'
        ]));

        return new PostResource($created);
    }

    /**
     * Display the specified  Post resource.
     *
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified Post resource in storage.
     *
     * @bodyParam title String Title of the post. Example: "A new beginning"
     * @bodyParam body String Body of the post.
     * @bodyParam user_ids Array IDs of the users contributing to the post
     *
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function update(PostRepository $postRepository, Post $post, Request $request)
    {
        // $updated = Post::query()->update($request->only(['title','body']));
        $updated = $postRepository->update($post, $request->only(['title','body', 'user_ids']));
        return new PostResource($updated);
    }

    /**
     * Remove the specified post resource from storage.
     *
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     */
    public function destroy(Post $post, PostRepository $postRepository)
    {
         $deletedPost=$postRepository->forceDelete($post);
        return new PostResource($deletedPost);
    }
}
