<?php
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::prefix('comments')
->name('comments')
->group(function(){
    Route::get('/',[CommentController::class, 'index']);
    Route::get('/{comment}',[CommentController::class, 'show']);
    Route::post('/',[CommentController::class, 'store']);
    Route::put('/{comment}',[CommentController::class, 'update']);
    Route::delete('/{comment}',[CommentController::class, 'destroy']);
});
