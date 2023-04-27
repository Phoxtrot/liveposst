<?php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')
->name('posts')
->group(function(){
    Route::get('/',[PostController::class, 'index']);
    Route::get('/{post}',[PostController::class, 'show']);
    Route::post('/',[PostController::class, 'store']);
    Route::put('/{post}',[PostController::class, 'update']);
    Route::delete('/{post}',[PostController::class, 'destroy']);
});
