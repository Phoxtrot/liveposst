<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
->name('users')
->group(function(){
    Route::get('/',[UserController::class, 'index']);
    Route::get('/{user}',[UserController::class, 'show']);
    Route::post('/',[UserController::class, 'store']);
    Route::put('/{user}',[UserController::class, 'update']);
    Route::delete('/{user}',[UserController::class, 'destroy']);
});
