<?php

use App\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->name('api.')->group(function () {
    Route::apiResource('user', 'API\\UserController');
});

Route::post('/token', function (Request $request) {
    if ($user = User::whereEmail($request->get('email'))->first()) {
        if (Hash::check($request->get('password'), $user->password)) {
            if (!$user->api_token)
                $user->forceFill(['api_token' => date('dmYHis') . Str::random(46)])->save();
            return response()->json($user->api_token);
        }
    }

    return response()->json('Wrong credentials', 400);
})->name('api.token');
