<?php

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use function Termwind\render;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/reset-password/{token}',function($token){
    return $token;
})
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.reset');
if (App::environment('local')) {
    // App::setLocale('yor');
    $trans = Lang::get('auth.failed');
    $trans = __("auth.password");
    $trans = __("auth.throttle",['seconds' =>"mewa"]);
    $pant = trans_choice("auth.apples",5);
    $welcome = __("auth.welcome", ["name" =>"Same"]);
    dump(App::getLocale());
    dd($welcome);

    Route::get('/play', function () {
        $user = User::factory()->make();
        Mail::to($user)
        ->send(new WelcomeMail($user));
        return null;
    });

}
Route::get('/app',function(){
    return view('app');
});

