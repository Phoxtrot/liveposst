<?php
namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostRepository extends Repository{
    public function store($attributes)
    {
        return DB::transaction(function () use ($attributes){
            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'untitled'),
                'body' => data_get($attributes, 'body'),
            ]);
            throw_if(!$created, GeneralJsonException::class, "Fail to create post",401);
            if ($userId = data_get($attributes,'user_id')) {
                $created->users()->sync($userId);
            }
            return $created;
        });
    }
    public function update($post,$attributes )
    {
        return DB::transaction(function () use ($post, $attributes){
            $updated = $post->update([
                'title' => data_get($attributes, 'title') ?? $post->title,
                'body' => data_get($attributes, 'body') ?? $post->body,

            ]);
            if ($userId = data_get($attributes,'user_id')) {
                $post->users( )->sync($userId);
            }
            throw_if(!$updated, GeneralJsonException::class, "Failed to update", 401);
            return $post;
        });

    }
    public function forceDelete($post)
    {
        $deletedPost = $post->forceDelete();
        throw_if(!$deletedPost, GeneralJsonException::class, "failed to delete post", 401);
        return $post;
    }
}
