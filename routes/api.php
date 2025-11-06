<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function(){
    return response()->json(['message' => 'Trusttech Blog Portal API']);
});

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware(['jwt.verify'])->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    Route::get('/user/posts', [PostController::class, 'userIndex'])->name('api.user.posts');
});
 Route::get('/posts', [PostController::class, 'index'])->name('api.posts');