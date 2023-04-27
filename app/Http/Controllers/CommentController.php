<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->pageSize ?? 20;
        $comments = Comment::query()->paginate($pageSize);
        return new JsonResponse([
            'data' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::query()->create([
            'title' => $request->title,
            'body' => []
        ]);
        return new JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $updated = $comment->update([
            'title' => $request->title ?? $comment->title,
            'body' => $request->body ?? $comment->body,

        ]);
        if (!$updated) {
            return new JsonResponse([
                'error' => 'Request not updated.'
            ],status:400);
        }
        return new JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $deletedComment = $comment->forceDelete();
        if (!$deletedComment) {
            return new JsonResponse([
                'error' => 'Post not deleted.'
            ],status:400);
        }
        return new JsonResponse([
            'data' => $deletedComment
        ]);
    }
}
